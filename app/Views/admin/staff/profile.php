<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>个人资料</h1>
        <!--        --><?php //echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <br>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="/upload/avatar/m_001.png" alt="头像">
                        <h3 class="profile-username text-center"><?php echo $admin['real_name']?></h3>
                        <p class="text-muted text-center"><?php echo $admin['real_name']?></p>
                        <p>
                            <small class="label bg-blue"><?php echo $roles[$admin['role_id']]?></small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true">个人信息</a></li>
                        <li class=""><a href="#privacy" data-toggle="tab" aria-expanded="false">修改密码</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile">
                            <form class="dataForm form-horizontal" id="dataForm1" action="" method="post">
                                <div class="form-group">
                                    <label for="nickname" class="col-sm-2 control-label">昵称</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input class="form-control" value="<?php echo $admin['real_name']?>" name="real_name"
                                               id="real_name" maxlength="30"
                                               placeholder="请输入昵称">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" class="btn btn-danger" onclick="editUserInfo(1)">保存</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane" id="privacy">
                            <form class="dataForm form-horizontal" id="dataForm2" action="" method="post">
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">当前密码</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input type="password" autocomplete='password' class="form-control" name="password" id="password"
                                               placeholder="请输入当前密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new_password" class="col-sm-2 control-label">新密码</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input type="password" class="form-control" autocomplete='off' name="new_password" id="new_password"
                                               placeholder="请输入新密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="renew_password" class="col-sm-2 control-label">确认新密码</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input type="password" class="form-control" autocomplete='off' name="renew_password" id="renew_password"
                                               placeholder="再次输入新密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="type" value="1">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" class="btn btn-danger" onclick="editUserInfo(2)">保存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php echo $this->include("admin/public/footer")?>
<script>
    function editUserInfo(type) {
        var real_name = $("#real_name").val();
        var password = $("#password").val();
        var new_password = $("#new_password").val();
        var renew_password = $("#renew_password").val();

        $.ajax({
            url:"/admin/staff/profile",
            type:"POST",
            data:{
                real_name:real_name,
                password:password,
                new_password:new_password,
                renew_password:renew_password,
                type:type
            },
            dataType:"JSON",
            success:function(data){

                if(data.status){
                    showMessage("success","编辑成功","成功");
                    GoUrl("/admin/staff/profile",1);
                }else{
                    showMessage("error",data.message,"失败");
                    return false;
                }

            },error:function(e){
                showMessage("error", "编辑失败","失败");
                return false;
            }
        })
    }
</script>
