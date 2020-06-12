<?php

namespace App\Service;

use App\Models\AttachmentModel;
use CodeIgniter\Debug\Toolbar\Collectors\Files;
use CodeIgniter\Files\File;

class AttachmentService extends BaseService
{
    protected $name = 'attachment';
    protected $autoWriteTimestamp = true;

    /**
     * 定义文件类型
     * @var array
     */
    protected $fileType = [
        '图片' => ['jpg', 'bmp', 'png', 'jpeg', 'gif', 'svg'],
        '文档' => ['txt', 'doc', 'docx', 'xls', 'xlsx', 'pdf'],
        '压缩文件' => ['rar', 'zip', '7z', 'tar'],
        '音视' => ['mp3', 'ogg', 'flac', 'wma', 'ape'],
        '视频' => ['mp4', 'wmv', 'avi', 'rmvb', 'mov', 'mpg']
    ];

    /**
     * 定义文件缩略图
     * @var array
     */
    protected $fileThumb = [
        'picture' => ['jpg', 'bmp', 'png', 'jpeg', 'gif', 'svg'],
        'txt.svg' => ['txt', 'pdf'],
        'pdf.svg' => ['pdf'],
        'word.svg' => ['doc', 'docx'],
        'excel.svg' => ['xls', 'xlsx'],
        'archives.svg' => ['rar', 'zip', '7z', 'tar'],
        'audio.svg' => ['mp3', 'ogg', 'flac', 'wma', 'ape'],
        'video.svg' => ['mp4', 'wmv', 'avi', 'rmvb', 'mov', 'mpg']
    ];

    public $thumb_path = "";
    public $url = "";
    public $path = "";
    public $validate = [];

    public function __construct()
    {
        parent::__construct();
        //加载url辅助方法
        $attachment = config("Attachment");
        $this->thumb_path = $attachment->thumb_path;
        $this->url = $attachment->url;
        $this->path = $attachment->path;
        $this->validate = $attachment->validate;

        $this->fileThumb = [
            'picture' => ['jpg', 'bmp', 'png', 'jpeg', 'gif', 'svg'],
            $this->thumb_path . 'txt.svg' => ['txt', 'pdf'],
            $this->thumb_path . 'pdf.svg' => ['pdf'],
            $this->thumb_path . 'word.svg' => ['doc', 'docx'],
            $this->thumb_path . 'excel.svg' => ['xls', 'xlsx'],
            $this->thumb_path . 'archives.svg' => ['rar', 'zip', '7z', 'tar'],
            $this->thumb_path . 'audio.svg' => ['mp3', 'ogg', 'flac', 'wma', 'ape'],
            $this->thumb_path . 'video.svg' => ['mp4', 'wmv', 'avi', 'rmvb', 'mov', 'mpg']
        ];
    }

    /**
     * @title 获取文件大小
     * @param $value
     * @return string
     */
    public function getSizeAttr($value)
    {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $value >= 1024 && $i < 4; $i++) {
            $value /= 1024;
        }
        return round($value, 2) . $units[$i];
    }

    /**
     * @title 获取文件类型
     * @param $value
     * @param $data
     * @return int|string
     */
    public function getFileTypeAttr($value, $data)
    {
        $type = '其他';
        $extension = $data['extension'];
        foreach ($this->fileType as $name => $array) {
            if (in_array($extension, $array)) {
                $type = $name;
                break;
            }
        }
        return $type;
    }


    /**
     * @title 获取文件预览
     * @param $value
     * @param $data
     * @return int|string
     */
    public function getThumbnailAttr($value, $data)
    {
        $thumbnail = $this->thumb_path . 'unknown.svg';
        $extension = $data['extension'];
        foreach ($this->fileThumb as $name => $array) {
            if (in_array($extension, $array)) {
                $thumbnail = $name === 'picture' ? $data['url'] : $name;
                break;
            }
        }
        return $thumbnail;
    }

    /**
     * @title 获取当前的域名地址
     * @param $value
     * @param $data
     * @return string
     */
    public function getFileUrlAttr($value, $data)
    {
        $uri = current_url(true);

        $url_pre = $uri->getScheme() . '://' . $uri->getHost();
        return $url_pre . $data['url'];
    }

    /**
     * @title 单文件上传
     * @param $name
     * @param File $fileObj
     * @param int $a_id
     * @param int $user_id
     * @return bool|string|string[]
     * @throws \Exception
     */
    public function upload($name, File $fileObj, $a_id = 0, $user_id = 0)
    {
        if (!$_FILES[$name]['name']) {
            throw new \Exception("请选择文件", 100007);
        }

        $file = $fileObj;
        if ($file) {
            $day_time = date('Ymd');
            $file_path = $this->path . $day_time . "/";
            $file_url = $this->url . $day_time . "/";

            $ext = $file->getClientExtension();
            $mineType = $file->getMimeType();
            $size = $file->getSize();

            $fileName = unique_ID() . "." . $ext;

            $this->validateFile($size, $ext);

            $info = $file->move($file_path, $fileName);

            if ($info) {
                $url = str_replace("\\", '/', $file_url . $fileName);
                $file_info = [
                    'a_id' => $a_id,
                    'user_id' => $user_id,
                    'save_name' => $fileName,
                    'save_path' => str_replace("\\", '/', $file_path),
                    'extension' => $ext,
                    'mime' => $mineType,
                    'size' => $size,
                    'url' => $url,
                    'created_at' => time()
                ];
                $attachment_model = new AttachmentModel();

                $res = $attachment_model->addDataForAutoInc('attachment', $file_info);
                if (!$res) {
                    throw new \Exception("操作失败", 100007);
                }
                return $url;
            }

        } else {
            throw new \Exception("无法获取有效文件", 100007);
        }
        return false;
    }


    /**
     * @title 多文件上传
     * @param $name
     * @param Files $files
     * @param int $a_id
     * @param int $user_id
     * @return array
     * @throws \Exception
     */
    public function uploadMulti($files, $a_id = 0, $user_id = 0)
    {
        $urls = [];

        if ($files) {
            $day_time = date('Ymd');
            $file_path = $this->path . $day_time . "/";
            $file_url = $this->url . $day_time . "/";

            foreach ($files as $file) {

                $ext = $file->getClientExtension();
                $mineType = $file->getMimeType();
                $size = $file->getSize();

                $fileName = unique_ID() . "." . $ext;

                $this->validateFile($size, $ext);

                $info = $file->move($file_path, $fileName);

                if ($info) {
                    $url = str_replace("\\", '/', $file_url . $fileName);
                    $file_info = [
                        'a_id' => $a_id,
                        'user_id' => $user_id,
                        'save_name' => $fileName,
                        'save_path' => str_replace("\\", '/', $file_path),
                        'extension' => $ext,
                        'mime' => $mineType,
                        'size' => $size,
                        'url' => $url,
                        'created_at' => time()
                    ];
                    $attachment_model = new AttachmentModel();

                    $res = $attachment_model->addDataForAutoInc('attachment', $file_info);
                    if (!$res) {
                        throw new \Exception("操作失败", 100007);
                    }
                    $urls[] = $url;
                }
            }
            if (count($urls) > 0) {

                return $urls;

            } else {

                throw new \Exception("上传失败", 100007);
            }

        } else {

            throw new \Exception("无法获取有效文件", 100007);
        }
    }

    /**
     * @title 验证文件
     * @param $size
     * @param $ext
     * @return bool
     * @throws \Exception
     */
    public function validateFile($size, $ext)
    {
        if ($size > $this->validate['size']) {
            throw new \Exception("文件大小超出上传限制", 100007);
        }

        $ext_arr = explode(",", $this->validate['ext']);

        if (!empty($ext_arr)) {
            if (!in_array($ext, $ext_arr)) {
                throw new \Exception("非法上传文件", 100007);
            }
        }

        return true;
    }
}