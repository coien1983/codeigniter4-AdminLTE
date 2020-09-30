<?php

if(!function_exists("random_string")){
    /**
     * 随机字符串
     * @param string $type
     * @param int $len
     * @return false|string
     */
    function random_string($type = 'alnum', $len = 8)
    {
        $pool = "";

        switch ($type)
        {
            case 'alpha':
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alnum':
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'numeric':
                $pool = '0123456789';
                break;
            case 'nozero':
                $pool = '123456789';
                break;
        }
        return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
    }
}

if(!function_exists("index_id")){
    /**
     * @param int $short
     * @param string $key
     * @return false|string
     */
    function index_id($short = 0,$key = "")
    {
        $time = time_sn();

        $rand_string = random_string('alnum',20);

        if($short == 0)
        {
            return substr(md5($time.$rand_string.$key), 8, 16);
        }else{
            return md5($time.$rand_string.$key);
        }
    }
}


if(!function_exists("time_sn")){
    /**
     * 时间戳函数
     * @return string
     */
    function time_sn()
    {
        list($tmp1, $tmp2) = explode(' ', microtime());
        $sn = date('ymdHis', time()) . round($tmp1 * 1000);
        return $sn;
    }
}

