<?php
namespace App\Models;

class AdminModel extends BaseModel
{
    /**
     * @title 获取菜单列表
     * @return mixed
     */
    public function getMenuList()
    {
        $db = \Config\Database::connect();
        $query = $db->table("admin_module_menu")
            ->select("*,menu_id as id")
            ->orderBy("list_order","asc")
            ->orderBy("menu_id","desc")
            ->get();

        $result = $query->getResultArray();
        $query->freeResult();

        return $result;
    }

    /**
     * @title 授权菜单
     * @return array
     */
    public function getMenuListForAccess()
    {
        $db = \Config\Database::connect();
        $query = $db->table("admin_module_menu")
            ->select("parent_id,folder,controller,method,list_order,css_icon,is_display,menu_name,menu_id")
            ->orderBy("list_order","asc")
            ->orderBy("menu_id","asc")
            ->get();

        $result = $query->getResultArray();
        $query->freeResult();

        $menus = [];
        foreach ($result as $key=>$value)
        {
            $menus[$value['menu_id']] = $value;
        }

        return $menus;
    }

    /**
     * @title 获取角色权限菜单
     * @param $role_id
     * @return array
     */
    public function getRolePriv($role_id)
    {
        $db = \Config\Database::connect();
        $query = $db->table("admin_role_priv")
            ->where('role_id',$role_id)
            ->select("menu_id")
            ->get();
        $result = $query->getResultArray();
        $query->freeResult();

        $menus = [];
        foreach ($result as $key=>$value)
        {
            $menus[] = $value['menu_id'];
        }

        return $menus;
    }

    /**
     * @return array
     */
    public function getAllRoles($status = 0)
    {
        $db = \Config\Database::connect();
        if($status == 0)
        {
            $query = $db->table("admin_role")->get();
        }else{
            $query = $db->table("admin_role")->where('status',1)->get();
        }

        $result = $query->getResultArray();
        $query->freeResult();
        $roles = [];
        foreach ($result as $key=>$value)
        {
            $roles[$value['role_id']] = $value['role_name'];
        }

        return $roles;
    }

    /**
     * @title 获取系统配置
     * @return array
     */
    public function adminSetting()
    {
        $db = \Config\Database::connect();
        $query = $db->table("admin_setting")->get();
        $data = $query->getResultArray();
        $query->freeResult();
        return $data;
    }

}