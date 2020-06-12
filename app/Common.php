<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */


/**
 * @title 查询字符是否存在于某字符串
 *
 * @param $haystack 字符串
 * @param $needle 要查找的字符
 * @return bool
 */
function str_exists($haystack, $needle)
{
    return !(strpos($haystack, $needle) === FALSE);
}

/**
 * @title 展示错误消息
 * @param $msg
 * @param string $url_forward
 * @param int $ms
 * @param string $dialog
 * @param string $returnjs
 */
function showmessage($msg, $url_forward = '', $ms = 1000, $dialog = '', $returnjs = '')
{

    if ($url_forward == '') $url_forward = $_SERVER['HTTP_REFERER'];

    $datainfo = array("msg" => $msg, "url_forward" => $url_forward, "ms" => $ms, "returnjs" => $returnjs, "dialog" => $dialog);
//    echo view('admin/public/head');
    echo view('admin/public/message', $datainfo);
//    echo view('admin/public/foot');
    exit;
}

/**
 * @title json格式数据
 * @param bool $status
 * @param string $message
 * @param array $data
 */
function jsonMessage($status = true, $message = "", $data = [])
{
    $data = [
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];

    echo json_encode($data);
    exit;
}

/**
 * @title 判断终端是安卓还是ios
 * @return int
 */
function checkIOS()
{
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
        return true;
    } else {
        return false;
    }

//    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
//
//    }
}

/**
 * @title 判断终端是手机还是还是移动设备
 * @return bool
 */
function checkMobileOrPc()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile', 'MicroMessenger');
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/**
 * @title 判断终端是否ie
 * @return false|int
 */
function isIE()
{
    $isIE = strpos($_SERVER['HTTP_USER_AGENT'], "Triden");
    return $isIE;
}

/**
 * @title 权限接口构造
 * @param $current_role_priv_arr
 * @param $role_id
 * @param $module_name
 * @param $controller
 * @param $method
 * @param $args
 * @param $attr
 * @param $html
 * @param bool $is_return
 * @return string
 */
function aci_ui_a($current_role_priv_arr, $role_id, $module_name, $controller, $method, $args, $attr, $html, $is_return = false)
{
    if ($current_role_priv_arr) {
        $found = false;
        if ($role_id == 1) $found = true;
        if (!$found)
            foreach ($current_role_priv_arr as $k => $v) {
                if ($v['method'] == $method && $v['controller'] == $controller && $v['folder'] == $module_name) {
                    $found = true;
                    break;
                }
            }

        if ($found) {
            $url = trim($controller) != "" ? "href=\"" . base_url(sprintf("%s/%s/%s/%s", trim($module_name, "/"), $controller, $method, $args)) . "\"" : "#";
            if (str_exists($method, "delete"))//如果是删除
            {
                $url = base_url(sprintf("%s/%s/%s/%s", trim($module_name, "/"), $controller, $method, $args));

                if (!$is_return)
                    echo sprintf("<a href=\"javascript:if(confirm('确定要删除吗'))window.location.href='%s';\" %s>%s</a>", $url, $attr, $html);
                else
                    return sprintf("<a href=\"javascript:if(confirm('确定要删除吗'))window.location.href='%s';\" %s>%s</a>", $url, $attr, $html);
            } else {
                if (!$is_return)
                    echo sprintf("<a %s %s>%s</a>", $url, $attr, $html);
                else
                    return sprintf("<a %s %s>%s</a>", $url, $attr, $html);
            }
        }
    } else {
        if (!$is_return)
            echo "";
        else
            return "";
    }
}

/**
 * @title 快捷菜单
 * @param string $folder
 * @param string $controller
 * @param string $method
 * @return string
 */
function folder_controller_method_options($aci_config, $folder = '', $controller = '', $method = '')
{
    $_html = "";
    foreach ($aci_config as $k => $v) {
        $_html .= "<optgroup label=\"" . $v['moduleCaption'] . "\">\n";
        foreach ($v['moduleDetails'] as $mvc) {
            if ($folder == $mvc['folder'] && $controller == $mvc['controller'] && $method == $mvc['method'])
                $_html .= "<option value=\"{$mvc['folder']},{$mvc['controller']},{$mvc['method']}\" selected=\"selected\">{$mvc['folder']} > {$mvc['controller']} > {$mvc['method']}</option>\n";
            else
                $_html .= "<option value=\"{$mvc['folder']},{$mvc['controller']},{$mvc['method']}\" >{$mvc['folder']} > {$mvc['controller']} > {$mvc['method']}</option>\n";
        }
        $_html .= "</optgroup>\n";
    }
    return $_html;
}

/**
 * @title 验证一级菜单
 * @param $menu_id
 * @return int
 */
function getDepth($menu_id)
{
    $cache = \Config\Services::cache();
    $cache_module_menu_all = $cache->get('cache_module_menu_all');
    $cache_module_menu_all = json_decode($cache_module_menu_all,true);

    if (isset($cache_module_menu_all[$menu_id])) {
        $arr = $cache_module_menu_all[$menu_id];

        $arr_parentid = explode(",", $arr['arr_parentid']);
        return count($arr_parentid);
    }

    return 0;
}