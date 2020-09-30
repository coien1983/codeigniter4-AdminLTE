<?php

namespace App\Service;

use CodeIgniter\HTTP\Files\UploadedFile;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class UtilsService extends BaseService
{
    /**
     * 文件上传
     * @param UploadedFile $file
     * @return mixed
     * @throws \Exception
     */
    public function imgUpload(UploadedFile $file)
    {

        $ext = $file->getClientExtension();
        $extUp = strtoupper($ext);
        if(!in_array($extUp,["JPG","GIF","PNG","JPEG","SVG"]))
        {
            throw new \Exception("文件格式有误",100007);
        }

        $name = $file->getName();

        if ($file->isValid() && ! $file->hasMoved())
        {
            $file->move(WRITEPATH.'uploads');
        }

        $qiniu = config("Qiniu");
        $accessKey = $qiniu->accessKey;
        $secretKey = $qiniu->secretKey;
        $auth = new Auth($accessKey, $secretKey);
        $bucket = $qiniu->bucket;
        $domain_url = $qiniu->domainUrl;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        $qiniu_fileName = index_id().".".$ext;
        $upload_filepath = WRITEPATH.'uploads'.DIRECTORY_SEPARATOR.$name;

        list($ret, $err) = $uploadMgr->putFile($token, $qiniu_fileName, $upload_filepath);

        //删除文件
        unlink($upload_filepath);

        if($err !== null) {
            throw new \Exception("图片上传失败",100007);
        }

        return $domain_url ."/".$qiniu_fileName;

    }
}