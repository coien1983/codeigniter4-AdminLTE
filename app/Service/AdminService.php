<?php
namespace App\Service;

use App\Libraries\Tree;
use App\Models\AdminModel;

class AdminService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @title 管理员登录
     * @param $param
     * @return bool
     * @throws \Exception
     */
    public function adminLogin($param)
    {
        $admin_model = new AdminModel();

        $where = [
            'a_name'=>$param['a_name']
        ];

        $admin = $admin_model->findByWhere('admin',$where);
        if (empty($admin))
        {
            throw new \Exception("管理员不存在",1000007);
        }

        $password = md5(md5(trim($param['password']) . $admin['encrypt']));

        if($password != $admin['a_password'])
        {
            throw new \Exception("登录密码有误",100007);
        }

        if($admin['is_lock'] == 1)
        {
            throw new \Exception("账号被锁定，暂时无法登录",100007);
        }

        //设置session数据
        $data = [
            'a_id'=>$admin['a_id'],
            'a_name'=>$admin['a_name'],
            'role_id'=>$admin['role_id']
        ];
        session()->set($data);

        //记住登录
        if($param['remember'] == 1)
        {
            set_cookie('a_serial',$admin['a_serial'],86400*7);
        }

        return true;
    }

    /**
     * @title 重载用户数据
     * @param $a_serial
     * @return bool
     */
    public function reloadAdmin($a_serial)
    {
        $admin_model = new AdminModel();
        $where = [
            'a_serial'=>$a_serial
        ];

        $admin = $admin_model->findByWhere('admin',$where);
        if(empty($admin))
        {
            delete_cookie("a_serial");
            throw new \Exception("用户不存在",100007);
        }

        if($admin['is_lock'] == 1)
        {
            delete_cookie("a_serial");
            throw new \Exception("用户被锁定，请联系管理员",100007);
        }

        //设置session数据
        $data = [
            'a_id'=>$admin['a_id'],
            'a_name'=>$admin['a_name'],
            'role_id'=>$admin['role_id']
        ];
        session()->set($data);

        return true;
    }

    /**
     * @title 获取已登录的管理员信息
     * @return mixed
     * @throws \Exception
     */
    public function getStaffInfo()
    {
        $a_id = session("a_id");

        $admin_model = new AdminModel();

        $where = [
            'a_id'=>$a_id
        ];

        $admin = $admin_model->findByWhere('admin',$where);

        if(empty($admin))
        {
            throw new \Exception("管理员不存在",100007);
        }

        return $admin;
    }

    /**
     * @title 获取角色列表
     * @param $request
     * @return array
     */
    public function getRoleList($request)
    {
        $admin_model = new AdminModel();
        $query = $admin_model->setTable("admin_role")->select("role_id,role_name,desc,status");
        if(isset($request['keyword']) && !empty($request['keyword']))
        {
            $query = $query->like('role_name','%'.$request['keyword'].'%')->orLike('desc','%'.$request['keyword'].'%');
        }
        if(isset($request['per_page']))
        {
            $query1= $query->paginate($request['per_page']);
            $per_page = $request['per_page'];
        }else{
            $query1= $query->paginate(20);
            $per_page = 20;
        }

        $query2 = $query->get();
        $query2_num = count($query2->getResultArray());

        $data = [
            'lists'=>$query1,
            'count'=>$query2_num,
            'per_page'=>$per_page,
            'pager'=>$admin_model->pager,
            'keyword'=>$request['keyword']
        ];

        return $data;
    }

    /**
     * @title 添加角色
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function addRole($request)
    {
        $admin_model = new AdminModel();
        $where = [
            'role_name'=>$request['role_name']
        ];

        $check_role = $admin_model->findByWhere('admin_role',$where);
        if(!empty($check_role))
        {
            throw new \Exception("同名角色已经存在",100007);
        }

        $data = [
            'role_name'=>$request['role_name'],
            'desc'=>$request['desc'],
            'status'=>$request['status'],
            'created_at'=>time()
        ];

        $res = $admin_model->addDataForAutoInc('admin_role',$data);

        if(!$res)
        {
            throw new \Exception("操作失败",100007);
        }

        return true;
    }

    /**
     * @title 根据角色id查询角色
     * @param $role_id
     * @return mixed
     * @throws \Exception
     */
    public function getRoleById($role_id)
    {
        $admin_model = new AdminModel();
        $where = [
            'role_id'=>$role_id,
        ];
        $role = $admin_model->findByWhere('admin_role',$where);
        if(empty($role))
        {
            throw new \Exception("角色不存在",100007);
        }

        return $role;
    }

    /**
     * @title 编辑角色
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function editRole($request)
    {

        if($request['role_id'] == 1)
        {
            throw new \Exception("超级管理员无法编辑",100007);
        }

        $role = $this->getRoleById($request['role_id']);

        $admin_model = new AdminModel();

        //如果修改后的角色名不一样，做一下排重操作
        if($role['role_name'] != $request['role_name'])
        {
            $query = $admin_model->setTable("admin_role")
                ->where("role_name",$request['role_name'])
                ->where("role_id !=",$request['role_id'])
                ->get();

            $check_data = $query->getResultArray();
            $query->freeResult();
            if(count($check_data) > 0)
            {
                throw new \Exception("同名角色已经存在",100007);
            }
        }

        $data = [
            'role_name'=>$request['role_name'],
            'desc'=>$request['desc'],
            'updated_at'=>time()
        ];

        $where = [
            'role_id'=>$request['role_id']
        ];

        $res = $admin_model->resetDataByWhere('admin_role',$data,$where);

        if(!$res)
        {
            throw new \Exception("操作失败",100007);
        }

        return true;
    }

    /**
     * @title 删除菜单
     * @param $menu_id
     * @return bool
     * @throws \Exception
     */
    public function deleteMenu($menu_id)
    {
        $admin_model = new AdminModel();
        $where = [
            'menu_id'=>$menu_id
        ];

        $check_menu = $admin_model->findByWhere('admin_module_menu',$where);
        if(empty($check_menu))
        {
            throw new \Exception("菜单不存在",100007);
        }

        if($check_menu['is_parent'] == 1) {
            $where = [
                'parent_id'=>$menu_id
            ];
            $check_child = $admin_model->findByWhere('admin_module_menu',$where);

            if(!empty($check_child))
            {
                throw new \Exception("菜单下存在子菜单",100007);
            }
        }

        $where = [
            'menu_id'=>$menu_id
        ];

        $res = $admin_model->deleteByWhere('admin_module_menu',$where);

        if(!$res)
        {
            throw new \Exception("操作失败",100007);
        }


        return true;
    }

    /**
     * @title 获取编辑/添加 菜单需要的数据
     * @param $menu_id
     * @return array
     * @throws \Exception
     */
    public function getMenuDataForEdit($menu_id)
    {

        $tree = new Tree();

        $admin_model = new AdminModel();

        if($menu_id != 0)
        {
            $where = [
                'menu_id'=>$menu_id
            ];

            $check_menu = $admin_model->findByWhere("admin_module_menu",$where);
            if(empty($check_menu))
            {
                throw new \Exception("菜单不存在",100007);
            }

            $result = $admin_model->getMenuList();

            foreach ($result as $r) {
                $r['cname'] = $r['menu_name'];
                $r['selected'] = $r['menu_id'] == $check_menu['parent_id'] ? 'selected' : '';
                $array[] = $r;
            }
            $str = "<option depth='\$depth'  value='\$id' \$selected>\$spacer \$cname</option>";
            $tree->init($array);
            $select_categorys = $tree->get_tree(0, $str);

            $data = [
                'categorys'=>$select_categorys,
                'menu'=>$check_menu
            ];

            return $data;
        }else{
            $result = $admin_model->getMenuList();

            foreach ($result as $r) {
                $r['cname'] = $r['menu_name'];
                $r['selected'] = '';
                $array[] = $r;
            }
            $str = "<option depth='\$depth'  value='\$id' \$selected>\$spacer \$cname</option>";
            $tree->init($array);
            $select_categorys = $tree->get_tree(0, $str);

            $data = [
                'categorys'=>$select_categorys,
            ];

            return $data;
        }
    }

    /**
     * @title 编辑菜单
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function editMenu($request)
    {
        $parent_id= $request['parent_id'];
        $menu_url = $request['menu_url'];
        $menu_id = $request['menu_id'];
        $is_display = $request['is_display'];
        $menu_name = $request['menu_name'];
        $css_icon = $request['css_icon'];
        $sort_id = $request['sort_id'];

        $admin_model = new AdminModel();
        $where = [
            'menu_id'=>$menu_id
        ];
        $menu = $admin_model->findByWhere('admin_module_menu',$where);
        if(empty($menu))
        {
            throw new \Exception("菜单不存在",100007);
        }

        $menu_url_arr = explode(",", $menu_url);
        list($folder, $controller, $methodName) = $menu_url_arr;

//        $depth = $parent_id > 0 ? getDepth($parent_id) : 0;

        //只有不是一级菜单,现在更改为二级菜单也有链接
//        if ($depth > 0) {
//            $menu_url_arr = explode(",", $menu_url);
//            list($folder, $controller, $methodName) = $menu_url_arr;
//        } else {
//            $folder = "admin";
//            $controller = "manage";
//            $methodName = "go_" . $menu_id;
//        }

        $edit_data = array(
            'menu_name' => $menu_name,
            'parent_id' => $parent_id,
            'is_display' => $is_display,
            'controller' => $controller,
            'folder' => $folder,
            'method' => $methodName,
            'css_icon' => $css_icon,
            'list_order' => $sort_id,
            'updated_at'=>time()
        );

        $res = $admin_model->resetDataByWhere("admin_module_menu",$edit_data,$where);

        if(!$res){
            throw new \Exception("操作失败",100007);
        }

        return true;
    }

    /**
     * @title 添加菜单
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function addMenu($request)
    {
        $parent_id= $request['parent_id'];
        $menu_url = $request['menu_url'];
//        $menu_id = $request['menu_id'];
        $is_display = $request['is_display'];
        $menu_name = $request['menu_name'];
        $css_icon = $request['css_icon'];
        $sort_id = $request['sort_id'];

        $admin_model = new AdminModel();

        $menu_url_arr = explode(",", $menu_url);
        list($folder, $controller, $methodName) = $menu_url_arr;

//        $depth = $parent_id > 0 ? getDepth($parent_id) : 0;
//
//        //只有不是一级菜单,现在更改为二级菜单也有链接
//        if ($depth > 0) {
//            $menu_url_arr = explode(",", $menu_url);
//
//        } else {
//            $folder = "admin";
//            $controller = "manage";
//            $methodName = "go_0";
//        }

        $edit_data = array(
            'menu_name' => $menu_name,
            'list_order'=>$sort_id,
            'parent_id' => $parent_id,
            'is_display' => $is_display,
            'controller' => $controller,
            'folder' => $folder,
            'method' => $methodName,
            'css_icon' => $css_icon,
            'created_at'=>time()
        );

        $res = $admin_model->addDataForAutoInc("admin_module_menu",$edit_data);

        if(!$res){
            throw new \Exception("操作失败",100007);
        }

        return true;
    }

    /**
     * @title 删除角色
     * @param $role_id
     * @return bool
     * @throws \Exception
     */
    public function deleteRole($role_id)
    {
        $db = \Config\Database::connect();

        if($role_id == 1)
        {
            throw new \Exception("超级权限无法操作",100007);
        }

        $query = $db->table("admin_role")->where(['role_id'=>$role_id])->get();
        $role = $query->getRowArray();
        $query->freeResult();

        if (empty($role_id))
        {
            throw new \Exception("角色不存在",100007);
        }

        $db->transBegin();
        try{

            $res = $db->table('admin_role')->where('role_id',$role_id)->delete();
            if(!$res) {
                throw new \Exception("操作失败",100007);
            }

            $res = $db->table("admin_role_priv")->where('role_id',$role_id)->delete();
            if(!$res) {
                throw new \Exception("操作失败",100007);
            }

            $res = $db->table('admin')->where('role_id',$role_id)->delete();
            if(!$res) {
                throw new \Exception("操作失败",100007);
            }

            $db->transCommit();

        }catch (\Exception $e){
            $db->transRollback();
            throw new \Exception($e->getMessage(),100007);
        }

        return true;
    }

    /**
     * @title 更新角色状态
     * @param $role_id
     * @return bool
     * @throws \Exception
     */
    public function roleStatus($role_id)
    {
        $db = \Config\Database::connect();

        if($role_id == 1)
        {
            throw new \Exception("超级权限无法操作",100007);
        }

        $query = $db->table("admin_role")->where(['role_id'=>$role_id])->get();
        $role = $query->getRowArray();
        $query->freeResult();

        if (empty($role_id))
        {
            throw new \Exception("角色不存在",100007);
        }

        if($role['status'] == 1)
        {
            $data_role = [
                'status'=>0,
                'updated_at'=>time()
            ];

            $data_admin = [
                'is_lock'=>1,
                'updated_at'=>time()
            ];
        }else{
            $data_role = [
                'status'=>1,
                'updated_at'=>time()
            ];

            $data_admin = [
                'is_lock'=>0,
                'updated_at'=>time()
            ];
        }

        $db->transBegin();
        try{

            $res = $db->table('admin_role')->where('role_id',$role_id)->update($data_role);
            if(!$res) {
                throw new \Exception("操作失败",100007);
            }

            $res = $db->table('admin')->where('role_id',$role_id)->update($data_admin);
            if(!$res) {
                throw new \Exception("操作失败",100007);
            }

            $db->transCommit();

        }catch (\Exception $e){
            $db->transRollback();
            throw new \Exception($e->getMessage(),100007);
        }

        return true;
    }

    /**
     * @title 角色授权
     * @param $role_id
     * @return array
     * @throws \Exception
     */
    public function getRolePrivForAccess($role_id)
    {
        $admin_model = new AdminModel();
        $where = [
            'role_id'=>$role_id
        ];

        $role = $admin_model->findByWhere('admin_role',$where);
        if(empty($role))
        {
            throw new \Exception("角色不存在",100007);
        }

        if($role['status'] != 1)
        {
            throw new \Exception("角色被禁用",100007);
        }

        $tree= new Tree();

        $menu = $admin_model->getMenuListForAccess();

        $role_menu = $admin_model->getRolePriv($role_id);


        foreach($menu as $k=>$r) {
            $menu[$k]['url'] = $r['folder']."/".$r['controller']."/".$r['method'];
            $menu[$k]['checked'] = in_array($r['menu_id'],$role_menu) ? "checked" :"";
            $menu[$k]['level'] = $tree->getLevel($r['menu_id'],$menu);
            $menu[$k]['width']   = 100 - $menu[$k]['level'];
        }

        $tree->init($menu);
        $tree->text = [
            'other' => "<label class='checkbox'  >
                        <input \$checked  name='pid[]' value='\$menu_id' level='\$level'
                        onclick='javascript:checkNode(this);' type='checkbox'>
                       \$menu_name
                   </label>",
            '0'     => [
                '0' => "<dl class='checkMod'>
                    <dt class='hd'>
                        <label class='checkbox'>
                            <input \$checked name='pid[]' value='\$menu_id' level='\$level'
                             onclick='javascript:checkNode(this);'
                             type='checkbox'>
                            \$menu_name
                        </label>
                    </dt>
                    <dd class='bd'>",
                '1' => '</dd></dl>',
            ],
            '1'     => [
                '0' => "
                        <div class='menu_parent'>
                            <label class='checkbox'>
                                <input \$checked  name='pid[]' value='\$menu_id' level='\$level'
                                onclick='javascript:checkNode(this);' type='checkbox'>
                               \$menu_name
                            </label>
                        </div>
                        <div class='rule_check' style='width'\$width%;'>",
                '1' => "</div><span class='child_row'></span>",
            ]
        ];


        $table_html = $tree->getAuthTreeAccess(0);

        $data = [
            'table_html'=>$table_html,
            'role'=>$role
        ];

        return $data;
    }

    /**
     * @title 设置用户权限
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function setAccess($request)
    {
        $admin_model = new AdminModel();
        $where = [
            'role_id'=>$request['role_id']
        ];

        $role = $admin_model->findByWhere('admin_role',$where);
        if(empty($role))
        {
            throw new \Exception("角色不存在",100007);
        }

        if($role['status'] != 1)
        {
            throw new \Exception("角色被禁用，无法操作",100007);
        }

        if(empty($request['pid']))
        {
            throw new \Exception("权限树不能为空",100007);
        }

        if(!in_array(1,$request['pid']))
        {
            throw new \Exception("首页权限为必选项",100007);
        }

        $db = \Config\Database::connect();
        $query = $db->table("admin_module_menu")->whereIn("menu_id",$request['pid'])->get();

        $dataList = $query->getResultArray();
        $query->freeResult();

        $priv_datas = [];
        foreach ($dataList as $key=>$value)
        {
            $priv_datas[] = [
                'menu_id'=>$value['menu_id'],
                'role_id'=>$request['role_id'],
                'folder'=>$value['folder'],
                'controller'=>$value['controller'],
                'method'=>$value['method'],
                'created_at'=>time()
            ];
        }

        if(empty($priv_datas))
        {
            throw new \Exception("没有发现有效权限",100007);
        }

        $db->transBegin();
        try{

            $res = $db->table('admin_role_priv')->where('role_id',$request['role_id'])->delete();
            if(!$res) {
                throw new \Exception("操作失败",100007);
            }

            $res = $db->table('admin_role_priv')->insertBatch($priv_datas);
            if(!$res) {
                throw new \Exception("操作失败",100007);
            }

            $db->transCommit();

        }catch (\Exception $e){
            $db->transRollback();
            throw new \Exception($e->getMessage(),100007);
        }

        return true;
    }

    /**
     * @title 用户列表
     * @param $request
     * @return array
     */
    public function getAdminList($request)
    {
        $admin_model = new AdminModel();
        $query = $admin_model->setTable("admin");
        if(isset($request['keyword']) && !empty($request['keyword']))
        {
            $query = $query->like('a_name','%'.$request['keyword'].'%')->orLike('real_name','%'.$request['keyword'].'%');
        }
        if(isset($request['per_page']))
        {
            $query1= $query->paginate($request['per_page']);
            $per_page = $request['per_page'];
        }else{
            $query1= $query->paginate(20);
            $per_page = 20;
        }

        $roles = $admin_model->getAllRoles(0);

        $query2 = $query->get();
        $query2_num = count($query2->getResultArray());

        $data = [
            'lists'=>$query1,
            'count'=>$query2_num,
            'per_page'=>$per_page,
            'roles'=>$roles,
            'pager'=>$admin_model->pager,
            'keyword'=>$request['keyword']
        ];

        return $data;
    }

    /**
     * @title 获取所有有效角色
     * @return array
     */
    public function getRolesForAdd()
    {
        $admin_model = new AdminModel();
        $roles = $admin_model->getAllRoles(1);
        return $roles;
    }
}