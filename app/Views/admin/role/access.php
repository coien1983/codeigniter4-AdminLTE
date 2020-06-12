
<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<link href="/admin/css/access.css" rel="stylesheet" type="text/css"/>
<div class="content-wrapper">
    <section class="content-header">
        <h1>角色授权</h1>
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

                    <div class="box-header with-border">
                        <h3 class="box-title">【<?php echo $data['role']['role_name']?>】-授权</h3>
                        <label class="checkbox" for="check_all">
                            <input class="checkbox-inline" type="checkbox" name="check_all" id="check_all">全选
                        </label>
                    </div>
                    <div class="box-body" id="all_check">
                        <form id="dataForm" class="form-horizontal dataForm" action="" method="post"
                              enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="table_full">
                                    <table width="100%" cellspacing="0">
                                        <tbody>
                                        <?php echo $data['table_html']?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--表单底部-->
                            <div class="box-footer">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-10 col-md-4">
                                    <input type="hidden" name="role_id" value="<?php echo $data['role']['role_id']?>">
                                    <div class="btn-group">
                                        <button type="submit" class="btn flat btn-info" id="accessSubmit">
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
        </div>
    </section>
</div>
<?php echo $this->include("admin/public/footer")?>
<script>
    $("#check_all").click(function () {
        if (this.checked) {
            $("#all_check").find(":checkbox").prop("checked", true);
        } else {
            $("#all_check").find(":checkbox").prop("checked", false);
        }
    });

    function checkNode(obj) {
        var level_bottom;
        var chk = $("input[type='checkbox']");
        var count = chk.length;
        var num = chk.index(obj);
        var level_top = level_bottom = chk.eq(num).attr('level');

        for (var i = num; i >= 0; i--) {
            var le = chk.eq(i).attr('level');
            if (eval(le) < eval(level_top)) {
                chk.eq(i).prop("checked", true);
                level_top = level_top - 1;
            }
        }

        for (var j = num + 1; j < count; j++) {
            le = chk.eq(j).attr('level');
            if (chk.eq(num).prop("checked")) {
                if (eval(le) > eval(level_bottom)) {

                    chk.eq(j).prop("checked", true);
                } else if (eval(le) == eval(level_bottom)) {
                    break;
                }
            } else {
                if (eval(le) > eval(level_bottom)) {
                    chk.eq(j).prop("checked", false);
                } else if (eval(le) == eval(level_bottom)) {
                    break;
                }
            }
        }

        var all_length = $("input[name='url[]']").length;
        var checked_length = $("input[name='url[]']:checked").length;

        console.log('所有数量'+all_length);
        console.log('选中数量'+checked_length);

        if (all_length === checked_length) {
            $("#check_all").prop("checked", true);
        } else {
            $("#check_all").prop("checked", false);
        }
    }

    $(document).on("click","#accessSubmit",function (e) {
        e.preventDefault();
        $("#addRole").attr("disabled","disabled");
        $.ajax({
            url:"/admin/role/access/0",
            type:"POST",
            data:$("form").serialize(),
            dataType:"JSON",
            success:function(data){

                if(data.status){
                    showMessage("success","角色授权成功","成功");

                    GoUrl("/admin/role/index",1);
                }else{
                    showMessage("error",data.message,"失败");
                    $("#accessSubmit").removeAttr("disabled");
                    return false;
                }

            },error:function(e){
                showMessage("error", "角色授权失败","失败");
                $("#accessSubmit").removeAttr("disabled");
                return false;
            }
        })
    })
</script>
