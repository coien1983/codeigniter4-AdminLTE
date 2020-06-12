<?php
namespace App\Controllers\admin;

use App\Libraries\Breadcrumbs;
use App\Libraries\Tree;
use App\Service\AdminService;
use CodeIgniter\Controller;

/**
 * @title 员工信息
 * Class StaffController
 * @package App\Controllers\admin
 */
class RoleController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->unshift(2,"角色管理","/admin/staff/index");
    }

    /**
     * @title 用户中心
     * @return string
     */
    public function index()
    {
        $breadcrumb = $this->breadcrumbs->show();
        $admin_service =  new AdminService();

        $request = $this->request->getGet();

        try{
            $data = $admin_service->getRoleList($request);

            $this->data['breadcrumb'] = $breadcrumb;
            $this->data['data'] = $data;

            return view("admin/role/index",$this->data);

        }catch (\Exception $e){
            showmessage($e->getMessage(),base_url("admin/manage/logout"));
        }

    }

    /**
     * @title 添加角色
     * @return string
     */
    public function add()
    {
        if ($this->request->isAJAX()) {

            $config_arr = config("Validation");
            $rules = $config_arr->rules['addRole']['rules'];
            $errors = $config_arr->rules['addRole']['errors'];

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
                $this->breadcrumbs->unshift(3,"添加角色","/admin/role/add");
                $breadcrumb = $this->breadcrumbs->show();
                $this->data['breadcrumb'] = $breadcrumb;

                return view("admin/role/add",$this->data);

            }catch (\Exception $e){

                showmessage($e->getMessage());
            }
        }
    }

    /**
     * @title 编辑角色
     * @return string
     */
    public function edit()
    {
        $admin_service = new AdminService();

        if ($this->request->isAJAX()) {

            $config_arr = config("Validation");
            $rules = $config_arr->rules['addRole']['rules'];
            $errors = $config_arr->rules['addRole']['errors'];

            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }

            $request = $this->request->getPost();

            try{

                $admin_service->editRole($request);

                jsonMessage(true,"操作成功");
            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        } else {

            $role_id = $this->request->uri->getSegment(4);
            try{

                $this->breadcrumbs->unshift(3,"编辑角色","/admin/role/edit");
                $breadcrumb = $this->breadcrumbs->show();
                $this->data['breadcrumb'] = $breadcrumb;

                $role = $admin_service->getRoleById($role_id);
                $this->data['role'] = $role;

                return view("admin/role/edit",$this->data);

            }catch (\Exception $e){

                showmessage($e->getMessage());
            }
        }
    }

    /**
     * @title 删除角色
     */
    public function delete()
    {
        if ($this->request->isAJAX()) {

            $role_id = $this->request->getPost("role_id");

            try{

                $admin_service = new AdminService();
                $admin_service->deleteRole($role_id);
                $this->reload_all_cache();

                jsonMessage(true,"操作成功");
            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        }
    }

    /**
     * @title 角色状态
     */
    public function roleStatus()
    {
        if($this->request->isAJAX())
        {
            $role_id = $this->request->getPost("role_id");

            try{

                $admin_service = new AdminService();
                $admin_service->roleStatus($role_id);

                jsonMessage(true,"操作成功");
            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }
        }
    }

    /**
     * @title 角色授权
     * @return string
     */
    public function access()
    {
        $admin_service = new AdminService();

        if($this->request->isAJAX()){

            $config_arr = config("Validation");
            $rules = $config_arr->rules['setAccess']['rules'];
            $errors = $config_arr->rules['setAccess']['errors'];

            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }

            $request = $this->request->getPost();

            try{

                $admin_service->setAccess($request);

                $this->reload_all_cache();

                jsonMessage(true,"操作成功");
            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        }else {

            $role_id = $this->request->uri->getSegment(4);

            try{
                $this->breadcrumbs->unshift(3,"角色授权","/admin/role/access");

                $breadcrumb = $this->breadcrumbs->show();
                $this->data['breadcrumb'] = $breadcrumb;

                $data_info = $admin_service->getRolePrivForAccess($role_id);
                $this->data['data'] = $data_info;

                return view("admin/role/access",$this->data);

            }catch (\Exception $e){
                showmessage($e->getMessage());
            }

        }
    }

}