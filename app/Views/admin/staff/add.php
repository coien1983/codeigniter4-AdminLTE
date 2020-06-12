<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>添加用户</h1>
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
                                <label for="role" class="col-sm-2 control-label">角色</label>
                                <div class="col-sm-10 col-md-4">
                                    <select name="role_id" id="role" class="form-control">
                                        <?php foreach ($roles as $key=>$value):?>
                                        <option value="<?php echo $key?>"><?php echo $value?></option>
                                        <?php endforeach;?>
                                    </select>

                                </div>
                            </div>
                            <script>
                                $('#role').select2();
                            </script>

                            <div class="form-group">
                                <label for="nickname" class="col-sm-2 control-label">昵称</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="real_name" name="real_name" value=""
                                           class="form-control" placeholder="请输入昵称">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">账号</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="a_name" autocomplete="off" name="a_name"
                                           value="" class="form-control" placeholder="请输入账号">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="255" id="a_password" autocomplete="off" type="password" name="a_password"
                                           value="" class="form-control" placeholder="请输入密码">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">启用状态</label>
                                <div class="col-sm-10 col-md-4">
                                    <input class="input-switch" id="status" value="1" checked type="checkbox"/>
                                    <input class="switch field-switch" id="is_lock" name="status" value=""
                                           hidden/>
                                </div>
                            </div>

                            <script>
                                $('#status').bootstrapSwitch({
                                    onText: "是",
                                    offText: "否",
                                    onColor: "success",
                                    offColor: "danger",
                                    onSwitchChange: function (event, state) {
                                        $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
                                    }
                                });
                            </script>
                        </div>

                        <!--表单底部-->
                        <div class="box-footer">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10 col-md-4">
                                <div class="btn-group">
                                    <button type="submit" id="addStaff" class="btn flat btn-info dataFormSubmit">
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
<?php echo $this->include("admin/public/footer")?>
<script>
    $(document).on("click","#addStaff",function (e) {

    })
</script>
