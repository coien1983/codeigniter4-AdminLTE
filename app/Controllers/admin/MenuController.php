<?php
namespace App\Controllers\admin;

use App\Libraries\Breadcrumbs;
use App\Libraries\Tree;
use App\Models\AdminModel;
use App\Service\AdminService;
use CodeIgniter\Controller;

/**
 * @title 员工信息
 * Class StaffController
 * @package App\Controllers\admin
 */
class MenuController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(2,"菜单管理","/admin/menu/index");
    }

    /**
     * 菜单管理
     * @return string
     */
    public function index()
    {
        $breadcrumb = $this->breadcrumbs->show();

        $tree = new Tree();

        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        $admin_model = new AdminModel();

        $result = $admin_model->getMenuList();

        $array = [];

        foreach ($result as $r) {
            $r['is_display_text'] = $r['is_display']==1 ? '显示' : '隐藏';
            $r['str_manage'] = aci_ui_a($this->current_role_priv_arr,$this->role_id,$this->page_data['module_name'], $this->page_data['controller_name'], 'add', $r['id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-plus"></span> 新增子菜单', true);
            $r['str_manage'] .= " " . aci_ui_a($this->current_role_priv_arr,$this->role_id,$this->page_data['module_name'], $this->page_data['controller_name'], 'edit', $r['id'], ' class="btn btn-default btn-xs"', '<span class="glyphicon glyphicon-wrench"></span> 修改', true);
            $r['str_manage'] .= " " . aci_ui_a($this->current_role_priv_arr,$this->role_id,$this->page_data['module_name'], $this->page_data['controller_name'], 'delete', $r['id'], ' class="btn btn-default btn-xs"', '<span class="fa fa-trash"></span> 删除', true);
            $array[] = $r;
        }

        $str = "<tr>
					<td><input type='checkbox' name='pid[]' value='\$menu_id' /></td>
					<td>\$menu_id</td>
					<td>\$spacer\$menu_name</td>
					<td>\$folder/\$controller/\$method</td>
					<td>\$parent_id</td>
					<td><span class='fa \$css_icon'></span>&nbsp;\$css_icon</td>
					<td>\$list_order</td>
					<td>\$is_display_text</td>
					<td>\$str_manage</td>
				</tr>";

        $tree->init($array);
        $table_html = $tree->get_tree(0, $str);

        $this->data['table_html'] = $table_html;
        $this->data['breadcrumb'] = $breadcrumb;
        return view("admin/menu/index",$this->data);

    }

    /**
     * @ittle 删除菜单
     */
    public function delete()
    {
        $menu_id = $this->request->uri->getSegment(4);

        try {
            $admin_service = new AdminService();
            $admin_service->deleteMenu($menu_id);
            $this->reload_all_cache();

            showmessage("操作成功",base_url("admin/menu/index"));
        }catch (\Exception $e) {
            showmessage($e->getMessage());
        }
    }

    /**
     * @title 编辑菜单
     * @return string
     */
    public function edit()
    {
        $admin_service = new AdminService();

        if ($this->request->isAJAX()) {

            //这里写过滤规则
            $config_arr = config("Validation");
            $rules = $config_arr->rules['editMenu']['rules'];
            $errors = $config_arr->rules['editMenu']['errors'];

            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }

            $request = $this->request->getPost();

            try {

                $admin_service->editMenu($request);
                $this->reload_all_cache();

                jsonMessage(true,"操作成功");

            }catch (\Exception $e){

                jsonMessage(false,$e->getMessage());
            }

        } else {

            $menu_id = $this->request->uri->getSegment(4);

            try{

                $this->breadcrumbs->unshift(3,"编辑菜单","/admin/menu/edit");

                $breadcrumb = $this->breadcrumbs->show();
                $this->data['aci_config'] = $this->aci_config;
                $datainfo = $admin_service->getMenuDataForEdit($menu_id);

                $this->data['data'] = $datainfo;
                $this->data['breadcrumb'] = $breadcrumb;

                return view("admin/menu/edit",$this->data);

            }catch (\Exception $e){

                showmessage($e->getMessage());
            }

        }
    }

    /**
     * @title 添加菜单
     * @return string
     */
    public function add()
    {
        $admin_service = new AdminService();
        $menu_id = $this->request->uri->getSegment(4);

        if ($this->request->isAJAX()) {
            //这里写过滤规则
            $config_arr = config("Validation");
            $rules = $config_arr->rules['editMenu']['rules'];
            $errors = $config_arr->rules['editMenu']['errors'];

            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }

            $request = $this->request->getPost();

            try {

                $admin_service->addMenu($request);
                $this->reload_all_cache();

                jsonMessage(true,"操作成功");

            }catch (\Exception $e){

                jsonMessage(false,$e->getMessage());
            }

        } else {

            try{
                $this->breadcrumbs->unshift(3,"添加菜单","/admin/menu/add");

                $breadcrumb = $this->breadcrumbs->show();
                $this->data['aci_config'] = $this->aci_config;
                $datainfo = $admin_service->getMenuDataForEdit($menu_id);

                $this->data['data'] = $datainfo;
                $this->data['breadcrumb'] = $breadcrumb;

                return view("admin/menu/add",$this->data);

            }catch (\Exception $e){

                showmessage($e->getMessage());
            }

        }
    }
}