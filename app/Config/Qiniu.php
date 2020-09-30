<?php
namespace Config;
use CodeIgniter\Config\BaseConfig;

/**
 * 七牛配置中心
 * Class Qiniu
 * @package Config
 */
class Qiniu extends BaseConfig
{
    public $accessKey = "";
    public $secretKey = "";
    public $bucket = "";
    public $domainUrl = "";
}