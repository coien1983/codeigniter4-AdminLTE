<?php  namespace Config;
/*
 * 如果要增加新的方法和模块，就必须要在这里添加方法和控制器
 * */

use CodeIgniter\Config\BaseConfig;

class Attachment extends BaseConfig
{
    public $thumb_path = "/attachment/thumbnail/";
    public $path = ROOTPATH."/public/upload/attachment/";//上传目录配置（相对于根目录）
    public $url = "/upload/attachment/";//url（相对于web目录）
    public $validate = [
        //默认不超过50mb
        'size' => 52428800,
        //常用后缀
        'ext'  => 'bmp,ico,psd,jpg,jpeg,png,gif,doc,docx,xls,xlsx,pdf,zip,rar,7z,tz,mp3,mp4,mov,swf,flv,avi,mpg,ogg,wav,flac,ape',
    ];
}

/* End of file aci.php */
/* Location: ./application/config/aci.php */
