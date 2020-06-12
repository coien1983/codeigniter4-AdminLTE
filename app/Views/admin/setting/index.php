
<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>设置中心</h1>
        <!--        --><?php //echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <br>
    <section class="content">
        <div class="row" style="display: none;">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="btn-group">
                            <a class="btn flat btn-sm btn-default BackButton">
                                <i class="fa fa-arrow-left"></i>
                                返回
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <?php foreach ($data_config as $key=>$item):?>
                        <li <?php if($key== 0) :?>class="active"<?php endif;?>><a href="#tab_<?php echo $key?>" data-toggle="tab"><?php echo $item['name']?></a></li>
                        <?php endforeach;?>
                    </ul>
                    <div class="tab-content">
                        <?php foreach ($data_config as $key=>$item):?>
                        <div class="tab-pane <?php if($key==0) echo "active";?>" id="tab_<?php echo $key?>">

                            <form class="form-horizontal dataForm" action="/admin/setting/update" method="post"
                                  enctype="multipart/form-data">
                                <div class="box-body">
                                    <input name="id" value="<?php echo $item['id']?>" type="hidden" >
                                    <?php foreach ($item['content'] as $kk=>$data):?>
                                    <?php echo $data['form']?>
                                    <?php endforeach;?>
                                </div>

                                <!--表单底部-->
                                <div class="box-footer">
                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-10 col-md-4">
                                        <div class="btn-group">
                                            <button type="submit" class="btn flat btn-info dataFormSubmit">
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
                        <?php endforeach;?>

                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?php echo $this->include("admin/public/footer")?>
<script>

</script>
