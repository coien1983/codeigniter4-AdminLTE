<?php
namespace App\Controllers\admin;

use App\Libraries\Breadcrumbs;
use App\Service\AdminService;
use App\Service\CreditService;
use App\Service\TicketService;
use CodeIgniter\Controller;

/**
 *
 * Class CreditController
 * @package App\Controllers\admin
 */
class CreditController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->unshift(2,"新闻中心","/admin/credit/news");
    }

    /**
     * @title 新闻列表
     * @return string
     */
    public function news()
    {
        try{

            $this->breadcrumbs->unshift(3,"新闻中心","/admin/credit/news");
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