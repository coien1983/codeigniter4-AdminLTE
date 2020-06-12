<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>编辑用户</h1>
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
                                        <option value="<?php echo $key?>" <?php if($admin['role_id'] == $key) echo "selected";?>><?php echo $value?></option>
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
                                    <input maxlength="50" id="real_name" name="real_name" value="<?php echo $admin['real_name']?>"
                                           class="form-control" required placeholder="请输入昵称">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">账号</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="a_name" autocomplete="off" name="a_name"
                                           value="<?php echo $admin['a_name']?>" class="form-control" required placeholder="请输入账号">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="255" id="a_password" autocomplete="off" type="password" name="a_password"
                                           value="" class="form-control" required placeholder="请填写登录密码,若不修改请留空">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">确认密码</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="255" id="password" autocomplete="off" type="password" name="password"
                                           value="" class="form-control" required placeholder="请输入确认密码">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">启用状态</label>
                                <div class="col-sm-10 col-md-4">
                                    <input class="input-switch" id="status" value="1" checked type="checkbox"/>
                                    <input class="switch field-switch" id="is_lock" name="status" value="1"
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
                                <input type="hidden" name="a_id" value="<?php echo $admin['a_id']?>">
                                <div class="btn-group">
                                    <button type="submit" id="editStaff" class="btn flat btn-info dataFormSubmit">
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
    $(document).on("click","#editStaff",function (e) {
        e.preventDefault();
        $("#editStaff").attr("disabled","disabled");
        var real_name = $("#real_name").val();
        var a_name = $("#a_name").val();
        var a_password = $("#a_password").val();
        var password = $("#password").val();

        if(real_name == "")
        {
            showMessage("error","用户昵称不能为空","错误");
            $("#editStaff").removeAttr("disabled");
            return false;
        }

        if(a_name == "")
        {
            showMessage("error","登录账号不能为空","错误");
            $("#editStaff").removeAttr("disabled");
            return false;
        }

        if(a_password != "" && a_password != password)
        {
            showMessage("error","确认密码请保持一致","错误");
            $("#editStaff").removeAttr("disabled");
            return false;
        }

        $.ajax({
            url:"/admin/staff/edit/0",
            type:"POST",
            data:$("form").serialize(),
            dataType:"JSON",
            success:function(data){

                if(data.status){
                    showMessage("success","用户编辑成功","成功");

                    GoUrl("/admin/staff/index",1);
                }else{
                    showMessage("error",data.message,"失败");
                    $("#editStaff").removeAttr("disabled");
                    return false;
                }

            },error:function(e){
                showMessage("error", "用户编辑失败","失败");
                $("#editStaff").removeAttr("disabled");
                return false;
            }
        })


    })
</script>
