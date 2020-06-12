<?php
namespace App\Controllers\admin;

use App\Libraries\Breadcrumbs;
use App\Service\AdminService;
use CodeIgniter\Controller;

/**
 * @title 员工信息
 * Class StaffController
 * @package App\Controllers\admin
 */
class StaffController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->unshift(2,"用户管理","/admin/staff/index");
    }

    /**
     * @title 用户管理
     * @return string
     */
    public function index()
    {
        $breadcrumb = $this->breadcrumbs->show();
        $admin_service =  new AdminService();

        $request = $this->request->getGet();

        try{
            $data = $admin_service->getAdminList($request);

            $this->data['breadcrumb'] = $breadcrumb;
            $this->data['data'] = $data;

            return view("admin/staff/index",$this->data);

        }catch (\Exception $e){
            showmessage($e->getMessage());
        }
    }

    /**
     * @title 添加管理员用户
     * @return string
     */
    public function add()
    {
        if ($this->request->isAJAX()) {

            $config_arr = config("Validation");
            $rules = $config_arr->rules['addAdmin']['rules'];
            $errors = $config_arr->rules['addAdmin']['errors'];

            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }

            $request = $this->request->getPost();

            try{
                $admin_service = new AdminService();

                $admin_service->addAdmin($request);

                $this->reload_all_cache();

                jsonMessage(true,"操作成功");
            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        } else {

            try{
                $this->breadcrumbs->unshift(3,"添加用户","/admin/staff/add");
                $breadcrumb = $this->breadcrumbs->show();
                $this->data['breadcrumb'] = $breadcrumb;

                $admin_service = new AdminService();
                $this->data['roles'] = $admin_service->getRolesForAdd();

                return view("admin/staff/add",$this->data);

            }catch (\Exception $e){

                showmessage($e->getMessage());
            }
        }
    }

    /**
     * @title 编辑管理用户
     * @return string
     */
    public function edit()
    {
        if ($this->request->isAJAX()) {

            $config_arr = config("Validation");
            $rules = $config_arr->rules['addAdmin']['rules'];
            $errors = $config_arr->rules['addAdmin']['errors'];

            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }

            $request = $this->request->getPost();

            try{
                $admin_service = new AdminService();

                $admin_service->editAdmin($request);

                $this->reload_all_cache();

                jsonMessage(true,"操作成功");
            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        } else {

            $a_id = $this->request->uri->getSegment(4);
            try{
                $this->breadcrumbs->unshift(3,"编辑用户","/admin/staff/edit");
                $breadcrumb = $this->breadcrumbs->show();
                $this->data['breadcrumb'] = $breadcrumb;

                $admin_service = new AdminService();
                $this->data['roles'] = $admin_service->getRolesForAdd();
                $admin = $admin_service->getAdminById($a_id);
                $admin['status'] = $admin['is_lock'] == 1 ? 0 : 1;
                $this->data['admin'] = $admin;

                return view("admin/staff/edit",$this->data);

            }catch (\Exception $e){

                showmessage($e->getMessage());
            }
        }
    }

    /**
     * @title 更改管理用户状态
     */
    public function staffStatus()
    {
        if ($this->request->isAJAX()) {

            $a_id = $this->request->getPost("a_id");

            try{

                $admin_service = new AdminService();
                $admin_service->staffStatus($a_id);
                $this->reload_all_cache();

                jsonMessage(true,"操作成功");
            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        }
    }

    /**
     * @title 删除管理用户
     */
    public function delete()
    {
        if ($this->request->isAJAX()) {

            $a_id = $this->request->getPost("a_id");

            try{

                $admin_service = new AdminService();
                $admin_service->deleteStaff($a_id);
                $this->reload_all_cache();

                jsonMessage(true,"操作成功");
            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        }
    }

    /**
     * @title 个人资料
     * @return string
     */
    public function profile()
    {

        $admin_service =  new AdminService();

        if($this->request->isAJAX())
        {
            try{

                $request = $this->request->getPost();
                $admin_service->editProfile($request);

                jsonMessage(true,"操作成功");

            }catch (\Exception $e){
               jsonMessage(false,$e->getMessage());
            }

        }else{
            try{

                $this->breadcrumbs->unshift(3,"个人资料","/admin/staff/profile");

                $breadcrumb = $this->breadcrumbs->show();
                $admin = $admin_service->getStaffInfo();

                $this->data['breadcrumb'] = $breadcrumb;
                $this->data['admin'] = $admin;
                $this->data['roles'] = $admin_service->getRolesForAdd(0);

                return view("admin/staff/profile",$this->data);

            }catch (\Exception $e){
                showmessage($e->getMessage());
            }
        }

    }

    /**
     * @title 退出登录
     */
    public function logout()
    {
        helper("cookie");
        session_destroy();
        delete_cookie("a_serial");
        showmessage("请您重新登录",base_url("admin/manage/login"));
    }
}