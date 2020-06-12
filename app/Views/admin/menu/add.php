<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>添加菜单</h1>
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

                    <form id="dataForm" class="dataForm form-horizontal" action="" method="post"
                          enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="fields-group">
                                <div class="form-group">
                                    <label for="parent_id" class="col-sm-2 control-label">上级菜单</label>
                                    <div class="col-sm-10 col-md-4">
                                        <select name="parent_id" id="parent_id" class="form-control select2">
                                            <option value="0">/</option>
                                            <?php echo $data['categorys'];?>
                                        </select>
                                    </div>
                                </div>
                                <script>
                                    $('#parent_id').select2();
                                </script>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">名称</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input maxlength="50" id="menu_name" name="menu_name" value=""
                                               class="form-control" placeholder="请输入菜单名称">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="url" class="col-sm-2 control-label">url</label>
                                    <div class="col-sm-5">
                                        <select class="form-control" name="menu_url" id="menu_url">
                                            <?php echo folder_controller_method_options($aci_config,"", "", ""); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="icon" class="col-sm-2 control-label">图标</label>
                                    <div class="col-sm-10 col-md-4">
                                        <div class="input-group iconpicker-container">
                                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                            <input maxlength="30" id="icon" name="icon"
                                                   value="" class="form-control "
                                                   placeholder="请输入图标class">
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $('#icon').iconpicker({placement: 'bottomLeft'});
                                </script>

                                <div class="form-group">
                                    <label for="sort_id" class="col-sm-2 control-label">排序</label>
                                    <div class="col-sm-10 col-md-4">
                                        <div class="input-group">
                                            <input max="9999" min="1" type="number" id="sort_id" name="list_order"
                                                   value="1000"
                                                   class="form-control input-number field-number" placeholder="默认1000">
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $('#sort_id')
                                        .bootstrapNumber({
                                            upClass: 'success',
                                            downClass: 'primary',
                                            center: true
                                        });
                                </script>

                                <div class="form-group">
                                    <label for="is_show" class="col-sm-2 control-label">是否显示</label>
                                    <div class="col-sm-10 col-md-4">
                                        <input class="input-switch" id="is_show" value="1" checked type="checkbox"/>
                                        <input class="switch" id="is_display" name="is_show" value="1"
                                               placeholder="" hidden/>
                                    </div>
                                </div>
                                <script>
                                    $('#is_show').bootstrapSwitch({
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
                        </div>
                        <!--表单底部-->
                        <div class="box-footer">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10 col-md-4">
                                <div class="btn-group">
                                    <button type="submit" class="btn flat btn-info dataFormSubmit" id="editModuleMenu">
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
    $('#editModuleMenu').on('click',function(e){
        e.preventDefault();

        var parent_id = $('#parent_id').find("option:selected").val();

        var menu_name = $('#menu_name').val();

        var menu_url = $('#menu_url').find("option:selected").val();

        var is_display = $("#is_display").val();

        var css_icon = $("#icon").val();

        var sort_id = $("#sort_id").val();

        if(menu_name == ""){
            showMessage("error", "请填写菜单名称","失败");
            return false;
        }

        if(css_icon == "")
        {
            showMessage("error", "请选择图标","失败");
            return false;
        }

        $.ajax({
            url:"/admin/menu/add/0",
            type:"POST",
            data:{
                css_icon:css_icon,
                parent_id:parent_id,
                menu_name:menu_name,
                menu_url:menu_url,
                is_display:is_display,
                sort_id:sort_id,
                menu_id:0,
            },
            dataType:"JSON",
            success:function(data){

                if(data.status){
                    showMessage("success","栏目添加成功","成功");

                    GoUrl("/admin/menu/index",1);
                }else{
                    showMessage("error",data.message,"失败");
                    return false;
                }

            },error:function(e){
                showMessage("error", "菜单添加失败","失败");
                return false;
            }
        })

    });
</script>