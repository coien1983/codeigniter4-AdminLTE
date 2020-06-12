<?php
namespace App\Controllers\admin;

use App\Libraries\Breadcrumbs;
use App\Models\AdminModel;
use App\Models\AttachmentModel;
use App\Service\AdminService;
use App\Service\AttachmentService;


class SettingController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs->unshift(2,"设置中心","/admin/setting/index");
    }

    /**
     * @title 设置中心
     * @return string
     */
    public function index()
    {
        $breadcrumb = $this->breadcrumbs->show();

        try{
            $this->data['breadcrumb'] = $breadcrumb;
            $admin_service = new AdminService();
            $data = $admin_service->adminSetting();
            $this->data['data_config'] = $data;
            return view("admin/setting/index",$this->data);

        }catch (\Exception $e){
            showmessage($e->getMessage());
        }
    }

    //更新设置
    public function update()
    {
        $param = $this->request->getPost();

        try{

            $id = $param['id'];

            $admin_model = new AdminModel();

            $where = [
                'id'=>$id
            ];

            $config = $admin_model->findByWhere('admin_setting',$where);

            $config['content'] = json_decode($config['content'],true);

            $content_data = [];
            foreach ($config['content'] as $key => $value) {

                switch ($value['type']) {
                    case 'image' :
                    case 'file':

                        //处理图片上传
                        if (!empty($_FILES[$value['field']]['name'])) {
                            $attachment = new AttachmentService();
                            $fileObj = $this->request->getFile($value['field']);

                            if(!$fileObj->isValid())
                            {
                                throw new \Exception($fileObj->getErrorString()."(".$fileObj->getError().")",100007);
                            }

                            $url       = $attachment->upload($value['field'],$fileObj);
                            $value['content'] = $param[$value['field']] = $url;
                        }
                        break;

                    case 'multi_file':
                    case 'multi_image':

                        if (!empty($_FILES[$value['field']]['name'])) {
                            $attachment = new AttachmentService();
                            $fileObj = $this->request->getFiles();
                            $urls       = $attachment->uploadMulti($fileObj);
                            $value['content'] = $param[$value['field']] = json_encode($urls);
                        }
                        break;

                    default:
                        $value['content'] = $param[$value['field']];
                        break;
                }

                $content_data[] = $value;
            }

            $config['content'] = json_encode($content_data);

            $attachment_model = new AttachmentModel();
            $where = [
                'id'=>$id
            ];

            $res = $attachment_model->resetDataByWhere('admin_setting',$config,$where);
            if(!$res)
            {
                throw new \Exception("操作失败",100007);
            }

            showmessage("操作成功",base_url("admin/setting/index"));

        }catch (\Exception $e){
            showmessage($e->getMessage());
        }
    }
}