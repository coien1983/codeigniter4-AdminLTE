<?php

namespace App\Controllers\admin;

use App\Libraries\Breadcrumbs;
use CodeIgniter\Controller;
use Config\Services;

/**
 * @title 加载权限，角色和路由数据
 * Class BackendController
 * @package App\Controllers\admin
 */
class BackendController extends Controller
{

    public $aci_config;
    public $aci_status;
    public $all_module_menu;
    public $groups;

    public $system;

    protected $page_data = array(
        'module_name' => '',
        'controller_name' => '',
        'method_name' => '',
    );

    function __construct()
    {
        //获取当前路由
        $request_url = uri_string();
        $urls = explode("/", $request_url);

        $this->page_data['module_name'] = $urls[0];
        $this->page_data['controller_name'] = $urls[1];
        $this->page_data['method_name'] = $urls[2];

        $aci = config("Aci");
        $this->aci_config = $aci->aci_module;
        $this->aci_status = $aci->aci_status;
        $this->all_module_menu = $this->getCacheModuleMenu();

        $renderer = Services::renderer();
        $renderer->setData($this->page_data);
    }

    /**
     * @title 获取缓存中的菜单数据
     * @return array|mixed
     */
    public function getCacheModuleMenu()
    {
        $cache = \Config\Services::cache();
        $cache_module_menu_all = $cache->get("cache_module_menu_all");
        if ($cache_module_menu_all) {
            $cache_module_menu_all = json_decode($cache_module_menu_all, true);
        } else {
            $cache_module_menu_all = $this->reloadMenu($cache);
        }

        return $cache_module_menu_all;
    }

    /**
     * @title 获取权限列表
     * @return mixed
     */
    public function getCacheRolePriv()
    {
        $cache = \Config\Services::cache();
        $cache_member_role_priv = $cache->get("cache_member_role_priv");
        if ($cache_member_role_priv) {
            $cache_member_role_priv = json_decode($cache_member_role_priv, true);
        } else {
            $this->reloadRoleData($cache);
            $cache_member_role_priv = $cache->get("cache_member_role_priv");
            $cache_member_role_priv = json_decode($cache_member_role_priv, true);
        }
        return $cache_member_role_priv;
    }

    /**
     * @title 重载菜单
     * @param \CodeIgniter\Cache\CacheInterface $cache
     * @return array
     */
    public function reloadMenu(\CodeIgniter\Cache\CacheInterface $cache)
    {
        $menus = [];

        $db = \Config\Database::connect();
        $query = $db->table("admin_module_menu")
            ->orderBy("list_order", "asc")
            ->orderBy("menu_id", "asc")
            ->get();
        $result = $query->getResultArray();
        $query->freeResult();

        foreach ($result as $key => $value) {
            $value["url"] = $this->load_submenu($db, $value);
            $menus[$value['menu_id']] = $value;
        }

        //一个月有效期
        $cache->save("cache_module_menu_all", json_encode($menus), 30 * 86400);

        return $menus;
    }

    /**
     * @title 递归构建子菜单
     * @param $first_child_arr
     * @return string
     */
    public function load_submenu(\CodeIgniter\Database\BaseConnection $db, $first_child_arr)
    {

        if ($first_child_arr && str_exists($first_child_arr['method'], 'go_') && $first_child_arr['is_parent']) {

            $arr_childid = explode(",", $first_child_arr['arr_childid']);

            $query = $db->table("admin_module_menu")->where("parent_id", $arr_childid[1])->get();
            $first_sub_child_arr = $query->getRowArray();
            $query->freeResult();

            if (!empty($first_sub_child_arr)) return $this->load_submenu($db, $first_sub_child_arr);
        }

        return base_url($first_child_arr['folder'] . '/' . $first_child_arr['controller'] . '/' . $first_child_arr['method']);
    }

    /**
     * @title 重载角色和权限数据
     * @param \CodeIgniter\Cache\CacheInterface $cache
     */
    public function reloadRoleData(\CodeIgniter\Cache\CacheInterface $cache)
    {
        $db = \Config\Database::connect();
        $query = $db->table("admin_role_priv")->get();
        $result = $query->getResultArray();
        $query->freeResult();

        $new_priv_arr = [];
        foreach ($result as $k => $v) {
            $new_priv_arr[$v['role_id']][$v['menu_id']] = $v;
            $cache->save("cache_member_role_priv", json_encode($new_priv_arr), 30 * 86400);

            $query = $db->table("admin_role")->orderBy("role_id", "asc")->where('status',1)->get();
            $infos = $query->getResultArray();
            $query->freeResult();

            $this->groups = [];

            foreach ($infos as $info) {
                $role[$info['role_id']] = $info['role_name'];
                $this->groups[$info['role_id']] = $info;
            }

            $cache->save('cache_member_group', json_encode($this->groups), 30 * 86400);
        }
    }

    /**
     * @title 重载所有数据
     */
    public function reload_all_cache()
    {
        $cache = \Config\Services::cache();
        $this->reloadMenu($cache);

        $this->reloadRoleData($cache);
    }


}

/**
 * @title 成员权限控制
 * Class MemberController
 * @package App\Controllers\admin
 */
class MemberController extends BackendController
{
    public $module_info, $a_id, $a_name, $role_id, $current_member_info, $menu_side_list, $cache_module_menu_arr, $current_role_priv_arr;

    function __construct()
    {
        parent::__construct();
        $this->module_info = $this->aci_config;
        $this->cache_module_menu_arr = $this->getCacheModuleMenu();
        $this->a_id = intval(session("a_id"));

        $this->a_name = session("a_name");
        $this->role_id = intval(session("role_id"));

        $_cache_member_role_priv_arr = $this->getCacheRolePriv();

        $this->current_role_priv_arr = $this->role_id == 1 ? $this->cache_module_menu_arr : (isset($_cache_member_role_priv_arr[$this->role_id]) ? $_cache_member_role_priv_arr[$this->role_id] : NULL);

        $this->check_member();
        $this->check_priv();


    }

    /**
     * @title 判断用户登录
     */
    protected function check_member()
    {
        $db = \Config\Database::connect();
        $query = $db->table("admin")->where("a_id", $this->a_id)->where("a_name", $this->a_name)->get();
        $_datainfo = $query->getRowArray();
        $query->freeResult();

        if (!($this->page_data['folder_name'] == 'admin' && $this->page_data['controller_name'] == 'manage' && $this->page_data['method_name'] == 'login') && !$_datainfo) {
            showmessage('请您重新登录', base_url('admin/manage/login'));
            exit(0);
        } else if ($_datainfo) {

            $this->current_member_info = $_datainfo;
        }
    }

    /**
     * @title 判断用户权限
     * @return bool
     */
    protected function check_priv()
    {
        if (strtolower($this->page_data['folder_name']) == 'admin' && strtolower($this->page_data['controller_name']) == 'manage' && in_array(strtolower($this->page_data['method_name']), array('login', 'manage'))) return true;
        if ($this->role_id == 1) return true;

        // 如果有缓存，缓存优先
        if ($this->current_role_priv_arr) {
            $found = false;
            foreach ($this->current_role_priv_arr as $k => $v) {
                if (strtolower($v['method']) == strtolower($this->page_data['method_name']) &&
                    strtolower($v['controller']) == strtolower($this->page_data['controller_name'])
                    && strtolower($v['folder']) == strtolower($this->page_data['folder_name'])) {
                    $found = true;
                    break;
                }
            }
            if (!$found) showmessage('您没有权限操作该项', 'blank');
        } else {
            $db = \Config\Database::connect();
            $count = $this->checkRolePriv($db,
                $this->page_data["folder_name"],
                $this->page_data["controller_name"],
                $this->page_data["method_name"],
                $this->role_id);
            if (!$count) showmessage('您没有权限操作该项', 'blank');
        }
    }

    /**
     * 权限检测
     * @param \CodeIgniter\Database\BaseConnection $db
     * @param $folder
     * @param $controller
     * @param $method
     * @param $role_id
     * @return int|string
     */
    public function checkRolePriv(\CodeIgniter\Database\BaseConnection $db, $folder, $controller, $method, $role_id)
    {
        $count = $db->table("admin_role_priv")
            ->where("method", $method)
            ->where("controller", $controller)
            ->where("folder", $folder)
            ->where("role_id", $role_id)
            ->countAll();
        return $count;
    }


    /**
     * 按父ID查找菜单子项
     * @param integer $parentid 父菜单ID
     * @param integer $with_self 是否包括他自己
     */
    protected function nav_menu($parent_id, $with_self = 0, $show_where = 0)
    {
        $db = \Config\Database::connect();

        $parent_id = intval($parent_id);

        $result = array();
        if ($this->all_module_menu)
            foreach ($this->all_module_menu as $k => $v) {
                if ($show_where == 1 && strtolower($v['folder']) != "admin") continue;
                if ($show_where == 0 && strtolower($v['folder']) == "admin") continue;
                if ($v['parent_id'] == $parent_id && $v['is_display'] == 1 && $v['is_side_menu'] == 1) {
                    $result[] = $v;
                }
            }

        if ($with_self) {
            if (isset($this->all_module_menu[$parent_id])) {
                $result = array_merge($this->all_module_menu[$parent_id], $result);
            }
        }

        if ($this->role_id == 1) return $result;;
        //权限检查
        $array = array();

        foreach ($result as $v) {
            $action = base_url($v['folder'] . '/' . $v['controller'] . '/' . $v['method']);
            $v['url'] = $action;
            if (preg_match('/^public_/', $v['method'])) {
                $array[] = $v;
            } else {
                $r = $this->checkRolePriv($db,
                    $v["folder"],
                    $v["controller"],
                    $v["method"],
                    $this->role_id);
                if ($r) $array[] = $v;
            }
        }
        return $array;
    }

    /**
     * @title 当前位置
     * @param $id
     * @return string
     */
    final  public function current_pos($id)
    {
        $str = '';
        if (isset($this->all_module_menu[$id])) {

            if ($this->all_module_menu[$id]['is_side_menu']) {
                $str = $this->current_pos($this->all_module_menu[$id]['parent_id']);

                if ($this->all_module_menu[$id]['is_parent'])
                    $str = $str . '<li><a href="' . $this->all_module_menu[$id]['url'] . '">' . $this->all_module_menu[$id]['menu_name'] . '</a></li>';

                else
                    $str = $str . '<li> ' . $this->all_module_menu[$id]['menu_name'] . ' </li>';

                return $str;
            }
        }
    }


}

/**
 * @title 后台总控制器
 * Class AdminController
 * @package App\Controllers\admin
 */
class AdminController extends MemberController
{
    public $data = [];
    public $breadcrumbs;


    function __construct()
    {
        parent::__construct();

        //终端判断
        $mobile = checkMobileOrPc();
        if ($mobile) {

            $ios = checkIOS();

            $android = !$ios;
        } else {

            $ios = false;
            $android = false;
        }

        $this->data["mobile_ie"] = isIE();
        $this->data['mobile'] = $mobile;
        $this->data['ios'] = $ios;
        $this->data['android'] = $android;

        $this->breadcrumbs = new Breadcrumbs();
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1,"首页","/admin/index/index");

        $this->getMenus();
    }

    /**
     * @title 组装菜单
     */
    public function getMenus()
    {
        $menus = $this->getViewAction($this->role_id);
        $menu_str = '';
        if ($menus) {

            foreach ($menus as $k => $v) {

                if (!isset($v['child'])) {
                    $menu_str .= '<li>';
                    $menu_str .= '   <a href="/' . $v['folder'] . '/' . $v['controller'] . '/' . $v['method'] . '">';
                    $menu_str .= '      <i class="fa '.$v['css_icon'].' text-primary"></i> <span>' . $v['menu_name'] . '</span>';
                    $menu_str .= '   </a>';
                    $menu_str .= '</li>';

                } else {
                    $menu_str .= '<li class="treeview">';
                    $menu_str .= '<a href="#">';
                    $menu_str .= '<i class="fa '.$v['css_icon'].'"></i>';
                    $menu_str .= '<span>' . $v['menu_name'] . '</span>';
                    $menu_str .= '<i class="fa fa-angle-left pull-right"></i>';
                    $menu_str .= '</a>';

                    $menu_str .= '<ul class="treeview-menu">';
                    foreach ((array)$v['child'] as $tk => $tv) {
                        $tv['method'] = ($tv['method'] == '*') ? 'index' : $tv['method'];
                        if (trim($tv['folder']) != '') {
                            $nurl = "/" . $tv['folder'] . "/" .
                                $tv['controller'] . "/" . $tv['method'];
                        } else {
                            $nurl = "/" . $tv['controller'] . "/" . $tv['method'];
                        }

                        $menu_str .= '<li id="J_' . $tv['controller']."_".$tv['method']. '" class="">
                        <a href="'.$nurl.'"><i class="fa '.$tv['css_icon'].'"></i><span>'.$tv['menu_name'].'</span></a>
                        </li>';
                    }

                    $menu_str .= '</ul></li>';
                }
            }
        }

        $this->data["menu_str"] = $menu_str;
    }

    /**
     * 当前操作员拥有的菜单
     */
    private function getViewAction($roleid)
    {
        $actions = $this->cache_module_menu_arr;
        $out = array();
        foreach ($actions as $k => $v) {
            if ($v['parent_id'] == 0) {
                $out[$v['menu_id']] = $v;
            }
        }
        foreach ($actions as $k => $v) {
            if (array_key_exists($v['parent_id'], $out)) {
                $out[$v['parent_id']]['child'][$v['menu_id']] = $v;
            }
        }
        $role_actions = array();
        if ($roleid) {
            $tmp_actions = $this->current_role_priv_arr;
            if ($tmp_actions) {
                foreach ($tmp_actions as $k => $v) {
                    $role_actions[] = $v['menu_id'];
                }
            }
        }
        $role_actions = array_unique($role_actions);
        foreach ($out as $k => $v) {

            // 主菜单权限判断
            if (!in_array($k, $role_actions)) {
                unset($out[$k]);
            } else {
                // 子菜单权限判断
                if (!empty($v['child'])) {
                    foreach ($v['child'] as $tk => $tv) {
                        if (!in_array($tk, $role_actions))
                            unset($out[$k]['child'][$tk]);
                    }
                }
            }
        }
        return $out ? $out : NULL;
    }
}



