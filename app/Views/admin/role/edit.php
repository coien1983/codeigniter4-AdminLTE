
<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>编辑角色</h1>
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
                                <label for="name" class="col-sm-2 control-label">名称</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="name" name="name" value="<?php echo $role['role_name']?>"
                                           class="form-control" placeholder="请输入名称">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">简介</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="desc" name="desc"
                                           value="<?php echo $role['desc']?>" class="form-control" placeholder="请输入简介">
                                </div>
                            </div>
                        </div>

                        <!--表单底部-->
                        <div class="box-footer">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10 col-md-4">
                                <div class="btn-group">
                                    <input type="hidden" name="role_id" id="role_id" value="<?php echo $role['role_id']?>">
                                    <button type="submit" id="editRole" class="btn flat btn-info dataFormSubmit">
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
    $(document).on("click","#editRole",function(){

        $("#editRole").attr("disabled","disabled");

        var role_name = $('#name').val();
        var desc = $('#desc').val();

        if(role_name == ""){
            showMessage("error","角色名称不能为空","错误");
            $("#editRole").removeAttr("disabled");
            return false;
        }

        if(desc == ""){
            showMessage("error","角色描述不能为空","错误");
            $("#editRole").removeAttr("disabled");
            return false;
        }

        var status = 0;
        var role_id = $("#role_id").val()

        $.ajax({
            url:"/admin/role/edit/0",
            type:"POST",
            data:{role_name:role_name,desc:desc,status:status,role_id:role_id},
            dataType:"JSON",
            success:function(data){

                if(data.status){
                    showMessage("success","角色编辑成功","成功");

                    GoUrl("/admin/role/index",1);
                }else{
                    showMessage("error",data.message,"失败");
                    $("#editRole").removeAttr("disabled");
                    return false;
                }

            },error:function(e){
                showMessage("error", "角色编辑失败","失败");
                $("#editRole").removeAttr("disabled");
                return false;
            }
        })

    });
</script>
