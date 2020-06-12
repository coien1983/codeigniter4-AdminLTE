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
            showmessage($e->getMessage(),base_url("admin/manage/logout"));
        }
    }

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

                $admin_service->addRole($request);

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
     * @title 个人资料
     * @return string
     */
    public function profile()
    {

        $admin_service =  new AdminService();

        try{
            $this->breadcrumbs->unshift(3,"个人资料","/admin/staff/profile");

            $breadcrumb = $this->breadcrumbs->show();
            $admin = $admin_service->getStaffInfo();

            $this->data['breadcrumb'] = $breadcrumb;
            $this->data['admin'] = $admin;

            return view("admin/staff/profile",$this->data);

        }catch (\Exception $e){
            showmessage($e->getMessage(),base_url("admin/manage/logout"));
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