<?php
namespace App\Controllers\admin;
use App\Service\UtilsService;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 * 辅助接口
 * Class UtilsController
 * @package App\Controllers\admin
 */
class UtilsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @title 图片上传
     */
    public function imgUpload()
    {
        $file = $this->request->getFile("c_image");

        try {

            $utils_service = new UtilsService();
            $url = $utils_service->imgUpload($file);

            jsonMessage(true,"操作成功",$url);

        }catch (\Exception $e){
            jsonMessage(false,$e->getMessage());
        }
    }
}