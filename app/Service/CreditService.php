<?php
namespace App\Service;


use App\Models\CreditModel;
use App\Models\TicketModel;
use mysql_xdevapi\Exception;

class CreditService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @title 新闻资讯
     * @param $request
     * @return array
     */
    public function creditNews($request)
    {
        $credit_model = new CreditModel();
        $query = $credit_model->setTable("credit_news");

        $query->select("*");
        $query = $query->orderBy('id desc');
        if(isset($request['per_page']))
        {
            $query1= $query->paginate($request['per_page']);
            $per_page = $request['per_page'];
        }else{
            $query1= $query->paginate(20);
            $per_page = 20;
        }

        $query2 = $credit_model->setTable("credit_news");

        $query2 = $query2->select("id")->get();

        $query2_num = count($query2->getResultArray());

        $data = [
            'lists'=>$query1,
            'count'=>$query2_num,
            'per_page'=>$per_page,
            'pager'=>$credit_model->pager,
        ];


        return $data;
    }

    /**
     * @title 添加新闻
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function addNews($request)
    {
        $credit_model = new CreditModel();

        $data = [
            'title'=>$request['title'],
            'c_image'=>$request['c_image'],
            'desc'=>$request['desc'],
            'content'=>$request['content'],
            'created_at'=>time(),
            'updated_at'=>time()
        ];

        $res = $credit_model->addDataForAutoInc('credit_news',$data);

        if(!$res)
        {
            throw new \Exception("操作失败",100007);
        }

        return true;
    }

    /**
     * @title 编辑新闻
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function editNews($request)
    {
        $credit_model = new CreditModel();

        $where = ['id'=>$request['id']];
        $news = $credit_model->findByWhere('credit_news',$where);
        if (empty($news))
        {
            throw new \Exception("新闻不存在",100007);
        }

        $data = [
            'title'=>$request['title'],
            'c_image'=>$request['c_image'],
            'desc'=>$request['desc'],
            'content'=>$request['content'],
            'updated_at'=>time()
        ];

        $res = $credit_model->resetDataByWhere('credit_news',$data,$where);

        if(!$res)
        {
            throw new \Exception("操作失败",100007);
        }

        return true;
    }

    /**
     * @title 删除新闻
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function deleteNews($request)
    {
        if(!isset($request['id']))
        {
            throw new \Exception("参数有误",100007);
        }
        $credit_model = new CreditModel();
        $where = ['id'=>$request['id']];
        $news = $credit_model->findByWhere('credit_news',$where);
        if (empty($news))
        {
            throw new \Exception("新闻不存在",100007);
        }

        $res = $credit_model->deleteByWhere('credit_news',$where);

        if(!$res)
        {
            throw new \Exception("操作失败",100007);
        }

        return true;
    }

    /**
     * @title 根据新闻id获取新闻
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function getNewsById($request)
    {
        $credit_model = new CreditModel();
        $where = ['id'=>$request['id']];
        $news = $credit_model->findByWhere('credit_news',$where);
        if (empty($news))
        {
            throw new \Exception("新闻不存在",100007);
        }

        return $news;
    }
}