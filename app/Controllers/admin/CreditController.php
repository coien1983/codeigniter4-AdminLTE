<?php
namespace App\Controllers\admin;

use App\Libraries\Breadcrumbs;
use App\Service\AdminService;
use App\Service\CreditService;
use App\Service\TicketService;
use CodeIgniter\Controller;

/**
 * @title 支付信用控制器
 * Class CreditController
 * @package App\Controllers\admin
 */
class CreditController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->unshift(2,"贴现数据","/admin/credit/lists");
    }

    /**
     * @title 贴现汇数据中心
     * @return string
     */
    public function lists()
    {
        $breadcrumb = $this->breadcrumbs->show();
        $credit_service =  new CreditService();

        $request = $this->request->getGet();


        try{
            $data = $credit_service->getCreditList($request);

            $this->data['breadcrumb'] = $breadcrumb;
            $this->data['data'] = $data;

            return view("admin/credit/lists",$this->data);

        }catch (\Exception $e){
            showmessage($e->getMessage());
        }
    }

    /**
     * @title 支付信用审核
     */
    public function creditStatus()
    {
        try{

            $request = $this->request->getPost();
            $user_service = new CreditService();
            $user_service->creditStatus($request);

            jsonMessage(true,"操作成功");

        }catch (\Exception $e){
            jsonMessage(false,$e->getMessage());
        }
    }

    /**
     * @title 新闻列表
     * @return string
     */
    public function news()
    {
        try{

            $this->breadcrumbs->unshift(3,"新闻资讯","/admin/credit/news");
            $breadcrumb = $this->breadcrumbs->show();
            $this->data['breadcrumb'] = $breadcrumb;

            $credit_service =  new CreditService();
            $request = $this->request->getGet();

            $data = $credit_service->creditNews($request);

            $this->data['data'] = $data;

            return view("admin/credit/news",$this->data);

        }catch (\Exception $e){
            showmessage($e->getMessage());
        }
    }

    /**
     * @title 添加新闻
     * @return string
     */
    public function addNews()
    {
        if ($this->request->isAJAX()) {

            $config_arr = config("Validation");
            $rules = $config_arr->rules['addNews']['rules'];
            $errors = $config_arr->rules['addNews']['errors'];

            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }

            $request = $this->request->getPost();

            try{
                $credit_service = new CreditService();

                $credit_service->addNews($request);

                jsonMessage(true,"操作成功");

            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        } else {

            try{
                $this->breadcrumbs->unshift(3,"添加新闻","/admin/credit/addNews");
                $breadcrumb = $this->breadcrumbs->show();
                $this->data['breadcrumb'] = $breadcrumb;

                return view("admin/credit/addNews",$this->data);

            }catch (\Exception $e){

                showmessage($e->getMessage());
            }
        }
    }

    /**
     * @title 编辑新闻
     * @return string
     */
    public function editNews()
    {
        $credit_service = new CreditService();

        if ($this->request->isAJAX()) {

            $config_arr = config("Validation");
            $rules = $config_arr->rules['addNews']['rules'];
            $errors = $config_arr->rules['addNews']['errors'];

            if(!$this->validate($rules,$errors)){

                //过滤的消息获取一下
                $err = $this->validator->getErrors();
                $err = array_values($err);

                jsonMessage(false,$err[0]);
            }

            $request = $this->request->getPost();

            try{

                $credit_service->editNews($request);

                jsonMessage(true,"操作成功");

            }catch (\Exception $e){
                jsonMessage(false,$e->getMessage());
            }

        } else {

            try{
                $this->breadcrumbs->unshift(3,"编辑新闻","/admin/credit/editNews");
                $breadcrumb = $this->breadcrumbs->show();
                $this->data['breadcrumb'] = $breadcrumb;

                $news = $credit_service->getNewsById($this->request->getGet());
                $this->data["news"] = $news;

                return view("admin/credit/editNews",$this->data);

            }catch (\Exception $e){

                showmessage($e->getMessage());
            }
        }
    }

    /**
     * @title 删除新闻
     */
    public function deleteNews()
    {
        try{

            $request = $this->request->getPost();
            $user_service = new CreditService();
            $user_service->deleteNews($request);

            jsonMessage(true,"操作成功");

        }catch (\Exception $e){
            jsonMessage(false,$e->getMessage());
        }
    }
}