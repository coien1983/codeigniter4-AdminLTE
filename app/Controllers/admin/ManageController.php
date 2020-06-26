<?php

namespace App\Controllers\admin;

use App\Service\AdminService;
use CodeIgniter\Controller;

class ManageController extends Controller
{
    public function __construct()
    {
        helper('cookie');
    }

    /**
     * @title 用户登录
     * @return string
     */
    public function login()
    {
        if($this->request->isAJAX())
        {
            $config_arr = config("Validation");
            $rules = $config_arr->rules['login']['rules'];
            $errors = $config_arr->rules['login']['errors'];
            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }
            $param["a_name"] = $this->request->getPost("a_name") ?  trim($this->request->getPost("a_name")):"";
            $param["password"] = $this->request->getPost("a_password") ? trim($this->request->getPost("a_password")):"";
            $param["remember"] = $this->request->getPost("remember") ? 1 : 0;

            try{

                $admin_service = new AdminService();
                $admin_service->adminLogin($param);

                jsonMessage(true,"登录成功");

            }catch (\Exception $e){

                jsonMessage(false,$e->getMessage());
            }

        }else{

            if(session("a_id"))
            {
                header("Location:".base_url("admin/staff/profile"));
            }else if(get_cookie("a_serial")){

                try{
                    $admin_service = new AdminService();
                    $a_serial = get_cookie("a_serial");
                    $admin_service->reloadAdmin($a_serial);

                    header("Location:".base_url("admin/staff/profile"));

                }catch (\Exception $e){
                    showmessage($e->getMessage(),base_url("admin/manage/login"));
                }

            }else{
                return view("admin/manage/login");
            }
        }

    }
}
