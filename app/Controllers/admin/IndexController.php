<?php
namespace App\Controllers\admin;

class IndexController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $index_config = [
            //默认密码警告
            'password_warning'=>'1',
            //是否显示提示信息
            'show_notice'=>'1',
            //提示信息内容
            'notice_content'=>'欢迎来到使用本系统，左侧为菜单区域，右侧为功能区。',
        ];

        //默认密码修改检测
        $password_danger = 0;
//        if (1 === ((int)session('a_id')) && $index_config['password_warning'] && password_verify('super-admin', base64_decode($this->user->password))) {
//            $password_danger = 1;
//        }

        /**
         * 首页数据展示，可自行替换
         */

        $this->data['admin_user_count'] = 1;
        $this->data['admin_role_count'] = 1;
        $this->data['admin_menu_count'] = 1;
        $this->data['admin_log_count'] = 1;


        //是否首页显示提示信息
        $show_notice = $index_config['show_notice'];
        //提示内容
        $notice_content = $index_config['notice_content'];

        //系统信息
        $this->data['system_info'] = "";
        //访问信息
        $this->data['visitor_info'] = $this->request;
        //默认密码警告
        $this->data['password_danger'] = $password_danger;
        //当前用户
        $this->data['user'] = [];
        //是否显示提示消息
        $this->data['show_notice'] = $show_notice;
        //提示内容
        $this->data['notice_content'] = $notice_content;

        $this->breadcrumbs->unshift(2,"后台首页","/admin/index/index");

        $breadcrumb = $this->breadcrumbs->show();
        $this->data['breadcrumb'] = $breadcrumb;


        return view("admin/index/index",$this->data);

    }

}