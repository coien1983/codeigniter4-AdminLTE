
<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>添加角色</h1>
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
                                    <input maxlength="50" id="name" name="name" value=""
                                           class="form-control" placeholder="请输入名称">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">简介</label>
                                <div class="col-sm-10 col-md-4">
                                    <input maxlength="50" id="desc" name="desc"
                                           value="" class="form-control" placeholder="请输入简介">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">启用状态</label>
                                <div class="col-sm-10 col-md-4">
                                    <input class="input-switch" id="status" value="1" checked type="checkbox"/>
                                    <input class="switch field-switch" id="is_status" placeholder="启用状态" name="status"
                                           value="1" hidden/>
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
                                    <button type="submit" id="addRole" class="btn flat btn-info dataFormSubmit">
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
    $(document).on("click","#addRole",function(){

        $("#addRole").attr("disabled","disabled");

        var role_name = $('#name').val();
        var desc = $('#desc').val();

        if(role_name == ""){
            showMessage("error","角色名称不能为空","错误");
            $("#addRole").removeAttr("disabled");
            return false;
        }

        if(desc == ""){
            showMessage("error","角色描述不能为空","错误");
            $("#addRole").removeAttr("disabled");
            return false;
        }

        var status = $("#is_status").val();

        $.ajax({
            url:"/admin/role/add",
            type:"POST",
            data:{role_name:role_name,desc:desc,status:status,role_id:0},
            dataType:"JSON",
            success:function(data){

                if(data.status){
                    showMessage("success","角色添加成功","成功");

                    GoUrl("/admin/role/index",1);
                }else{
                    showMessage("error",data.message,"失败");
                    $("#addRole").removeAttr("disabled");
                    return false;
                }

            },error:function(e){
                showMessage("error", "角色添加失败","失败");
                $("#addRole").removeAttr("disabled");
                return false;
            }
        })

    });
</script>
