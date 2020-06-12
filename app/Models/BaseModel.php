<?php
namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class BaseModel extends Model
{
    private $dbConnect;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->dbConnect = \Config\Database::connect();
    }

    /**
     * @title 添加数据，确保存在自增主键
     * @param $table
     * @param $data
     * @return int
     */
    public function addDataForAutoInc($table,$data)
    {
        $this->dbConnect->table($table)->insert($data);
        return $this->dbConnect->insertID();
    }

    /**
     * @title 不存在主键的时候，使用当前方法
     * @param $table
     * @param $data
     * @return \CodeIgniter\Database\BaseResult|\CodeIgniter\Database\Query|false
     */
    public function addDataForResult($table,$data)
    {
        return $this->dbConnect->table($table)->insert($data);
    }

    /**
     * @title 更新数据
     * @param $table
     * @param $data
     * @param $where
     * @return int|mixed
     */
    public function resetDataByWhere($table,$data,$where)
    {
        $this->dbConnect->table($table)->where($where)->update($data);

        return $this->dbConnect->affectedRows();
    }

    /**
     * @title 删除数据
     * @param $table
     * @param $where
     * @return int|mixed
     */
    public function deleteByWhere($table,$where)
    {
        $this->dbConnect->table($table)->where($where)->delete();
        return $this->dbConnect->affectedRows();
    }

    /**
     * @title 获取单条数据
     * @param $table
     * @param $where
     * @return mixed
     */
    public function findByWhere($table,$where)
    {
        $query = $this->dbConnect->table($table)->where($where)->get();
        $data = $query->getRowArray();
        $query->freeResult();
        return $data;
    }

    /**
     * @title 获取所有记录
     * @param $table
     * @param $where
     * @return array
     */
    public function findAllByWhere($table,$where)
    {
        $query = $this->dbConnect->table($table)->where($where)->get();
        $data = $query->getResultArray();
        $query->freeResult();
        return $data;
    }

    /**
     * @title 批量数据插入
     * @param $table
     * @param $data
     * @return int
     */
    public function insertBatchData($table,$data)
    {
        return $this->dbConnect->table($table)->insertBatch($data);
    }

}
