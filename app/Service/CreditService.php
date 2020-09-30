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
     * @title 获取支付信用列表
     * @param $request
     * @return array
     */
    public function getCreditList($request)
    {
        $credit_model = new CreditModel();
        $query = $credit_model->setTable("user_credit");
        if(isset($request['keyword']) && $request['keyword'] != "")
        {
            $query->like('chengdui_name','%'.$request['keyword'].'%');
        }

        $status = isset($request['status']) ? $request['status'] : -1;
        if ($status != -1 )
        {
            $query->where('status',$status);
        }

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

        $query2 = $credit_model->setTable("user_credit");
        if(isset($request['keyword']) && $request['keyword'] != "")
        {
            $query2->like('chengdui_name','%'.$request['keyword'].'%');
        }

        if ($status != -1 )
        {
            $query2->where('status',$status);
        }

        $query2 = $query2->select("id")->get();

        $query2_num = count($query2->getResultArray());

        $data = [
            'lists'=>$query1,
            'count'=>$query2_num,
            'per_page'=>$per_page,
            'pager'=>$credit_model->pager,
            'status'=>$status,
            'keyword'=>$request['keyword']
        ];


        return $data;
    }

    /**
     * @title 审核支付信用
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function creditStatus($request)
    {
        if(!isset($request['id']) || !isset($request['status']))
        {
            throw new \Exception("参数有误",100007);
        }

        if(!in_array($request['status'],[1,2]))
        {
            throw new \Exception("参数有误",100007);
        }

        $credit_model = new CreditModel();
        $where = ['id'=>$request['id']];
        $credit = $credit_model->findByWhere('user_credit',$where);

        if(empty($credit))
        {
            throw new \Exception("支付信用不存在",100007);
        }

        if($credit['status'] != 0)
        {
            throw new \Exception("支付信用已被审核",100007);
        }

        if($request['status'] == 2)
        {
            //如果是审核不通过，只需要更改状态
            $data = [
                'status'=>2,
                'updated_at'=>time()
            ];

            $res = $credit_model->resetDataByWhere('user_credit',$data,$where);
            if(!$res)
            {
                throw new \Exception("操作失败",100007);
            }

            return true;
        }else{
            //如果是审核通过
            $where = ['chengdui_name'=>$credit['chengdui_name'],'status'=>1];

            $db = \Config\Database::connect();
            $query = $db->table('user_credit')->where($where)->get();
            $exits_data = $query->getRowArray();

            $is_exsits = false;
            if(empty($exits_data))
            {
                $is_exsits = false;
            }else{
                $is_exsits = true;
                //如果已经存在,就需要将这条记录写入到历史表中
                $exist_id = $exits_data['id'];
                unset($exits_data['id']);
                unset($exits_data['status']);
            }

            $db->transBegin();

            try{

                $where = [
                    'id'=>$request['id']
                ];

                $data = [
                    'status'=>1,
                    'updated_at'=>time()
                ];

                $res = $db->table('user_credit')->where($where)->update($data);
                if(!$res) {
                    throw new \Exception("操作失败",100007);
                }



                if($is_exsits)
                {

                    $res = $db->table('user_credit')->where(['id'=>$exist_id])->delete();
                    if(!$res) {
                        throw new \Exception("操作失败",100007);
                    }

                    $res = $db->table('user_credit_history')->insert($exits_data);

                    if(!$res) {
                        throw new \Exception("操作失败",100007);
                    }
                }

                $db->transCommit();

            }catch (\Exception $e) {
                $db->transRollback();
                throw new \Exception($e->getMessage(),100007);
            }

            return true;
        }

    }

    /**
     * @title 支付信用页面的新闻资讯
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