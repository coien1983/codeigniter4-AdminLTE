<?php echo $this->include("admin/public/header"); ?>
<?php echo $this->include("admin/public/main_header"); ?>
<?php echo $this->include("admin/public/main_sidebar"); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>编辑新闻</h1>
        <!--        --><?php //echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <br>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- 表单头部 -->
                    <div class="box-header with-border">
                        <div class="btn-group">
                            <a class="btn flat btn-sm btn-default BackButton">
                                <i class="fa fa-arrow-left"></i>
                                返回
                            </a>
                        </div>
                    </div>
                    <form id="dataForm" class="form-horizontal dataForm" action="" method="post"
                          enctype="multipart/form-data">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="nickname" class="col-sm-2 control-label">新闻标题</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="title" name="title" value="<?php echo $news['title'] ?>"
                                           class="form-control" required placeholder="请输入新闻标题">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">新闻描述</label>
                                <div class="col-sm-10 col-md-4">
                                    <textarea name="desc" id="desc" cols="70" rows="10"
                                              placeholder="请填写新闻描述"><?php echo $news['desc'] ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="c_image" class="col-sm-2 control-label">封面图</label>
                                <div class="col-sm-10 col-md-4">
                                    <input id="c_image" name="c_image" placeholder="请上传封面图" data-initial-preview="<?php echo $news["c_image"]?>"
                                           type="file" class="form-control field-image">
                                    <input type="hidden" id="real_image" value="<?php echo $news['c_image'] ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="c_image" class="col-sm-2 control-label">新闻内容</label>
                                <div class="col-sm-10 col-md-8">
                                    <div id="div3">
                                        <p>欢迎使用 wangEditor 富文本编辑器</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--表单底部-->
                        <div class="box-footer">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10 col-md-4">
                                <input type="hidden" name="a_id" value="0">
                                <div class="btn-group">
                                    <input type="hidden" name="id" value="<?php echo $news['id'] ?>" id="id">
                                    <button type="submit" id="editNews" class="btn flat btn-info dataFormSubmit">
                                        保存
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="reset" class="btn flat btn-default dataFormReset">
                                        重置
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>

</div>
<?php echo $this->include("admin/public/footer") ?>
<link href="/assets/plugins/wangEditor/wangEditor.css" rel="stylesheet" type="text/css"/>
<script src="/assets/plugins/wangEditor/wangEditor.js" type="text/javascript"></script>
<script>

    // var initialPreview = [];
    // var initialPreviewConfig = [];

    /**
     * 初始化文件预览-多图上传使用
     */
    // function initFile() {
    //     for (var i = 0; i < previewListEdit.length; i++) {
    //         initialPreview.push(previewListEdit[i].url);
    //         var config = {
    //             caption: previewListEdit[i].fileName,
    //             filename: previewListEdit[i].fileName,
    //             downloadUrl: previewListEdit[i].url,
    //             key: previewListEdit[i].key
    //         }
    //         initialPreviewConfig.push(config);
    //     }
    // }


    $("#c_image").fileinput({
        theme: 'fas',
        uploadUrl: '/admin/utils/imgUpload', // you must set a valid URL here else you will get an error
        allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg', 'svg'],
        overwriteInitial: false,
        maxFileSize: 1000,
        maxFilesNum: 1,
        showPreview: true,
        initialPreviewAsData: true,
        initialPreview: [
            "<?php echo $news["c_image"]?>"
        ],
        initialPreviewConfig: [
            {
                key:1,
                downloadUrl:'<?php echo $news["c_image"]?>'
            }
        ],
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        },
    }).on("fileuploaded", function (e, data) {
        var res = data.response;
        if (res.status) {

            //异步上传，返回来的值添加到隐藏的input里面提交上去一起处理
            $("#real_image").val(res.data);
            showMessage("success", "操作成功", "成功");
            //上传后路径
            // alert(res.path);
        } else {
            showMessage("error", res.message, "失败");
        }
    }).on("fileerror", function (event, data, msg) {
        layer.msg(data.msg);
    });

    var E = window.wangEditor

    var editor2 = new E('#div3');
    editor2.customConfig.uploadImgServer = '/admin/utils/imgUpload'
    editor2.customConfig.uploadFileName = "c_image";
    editor2.customConfig.uploadImgHooks = {
        customInsert: function (insertImg, result, editor) {
            console.log(JSON.stringify(result))
            if (data.status) {
                insertImg(result.data)
            } else {
                showMessage("error", res.message, "失败");
            }
        },

        // customInsert: function (insertImg, result, editor) {
        //     console.log(result)
        // }
    };
    // editor2.customConfig.uploadImgParams = {
    //     a: 123,
    //     b: 'vvv'
    // }
    // editor2.customConfig.uploadImgParamsWithUrl = true
    editor2.create()
    editor2.txt.html("<?php echo $news['content']?>")

    $(document).on("click", "#editNews", function (e) {
        e.preventDefault();
        //新闻标题
        var title = $("#title").val()
        if (title == "") {
            showMessage("error", "请填写新闻标题", "失败");
            return
        }
        //新闻描述
        var desc = $("#desc").val()
        if (desc == "") {
            showMessage("error", "请填写新闻描述", "失败");
            return
        }
        //新闻封面
        var c_image = $("#real_image").val()
        if (c_image == "") {
            showMessage("error", "请上传新闻封面", "失败");
            return
        }
        //新闻内容
        var content = editor2.txt.html()
        if (content == "") {
            showMessage("error", "请填写新闻内容", "失败");
            return
        }
        var id = $("#id").val()

        $.ajax({
            url: "/admin/credit/editNews",
            type: "POST",
            data: {title: title, desc: desc, c_image: c_image, content: content, id: id},
            dataType: "JSON",
            success: function (data) {

                if (data.status) {
                    showMessage("success", "操作成功", "成功");

                    GoUrl("/admin/credit/news", 1);
                } else {
                    showMessage("error", data.message, "失败");

                    return false;
                }

            }, error: function (e) {
                showMessage("error", "操作失败", "失败");
                return false;
            }
        })

    })
</script>
