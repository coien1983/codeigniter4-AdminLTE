
<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>角色管理</h1>
        <!--        --><?php //echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <br>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <form class="form-inline searchForm" id="searchForm" action="/admin/role/index" method="GET">

                            <div class="form-group">
                                <input value="<?php echo $data['keyword']?>"
                                       name="keyword" id="keyword" class="form-control input-sm" placeholder="名称/简介">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i> 查询
                                </button>
                            </div>
                            <div class="form-group">
                                <button onclick="clearSearchForm()" class="btn btn-sm btn-default" type="button"><i
                                        class="fa  fa-eraser"></i> 清空查询
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!--数据列表顶部-->
                    <div class="box-header">
                        <div>
                            <a title="添加" data-toggle="tooltip" class="btn btn-primary btn-sm " href="/admin/role/add">
                                <i class="fa fa-plus"></i> 添加
                            </a>
                            <a class="btn btn-success btn-sm ReloadButton" data-toggle="tooltip" title="刷新"
                               data-id="checked" data-url="/admin/role/index">
                                <i class="fa fa-refresh"></i> 刷新
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered datatable" width="100%">
                            <thead>
                            <tr>
                                <th>
                                    <input id="dataCheckAll" type="checkbox" onclick="checkAll(this)" class="checkbox"
                                           placeholder="全选/取消">
                                </th>
                                <th>ID</th>
                                <th>名称</th>
                                <th>简介</th>
                                <th>是否启用</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data['lists'] as $key=>$value):?>
                                <tr>
                                    <td>
                                        <input type="checkbox" onclick="checkThis(this)" name="data-checkbox"
                                               data-id="<?php echo $value['role_id']?>" class="checkbox data-list-check" value="<?php echo $value['role_id']?>"
                                               placeholder="选择/取消">
                                    </td>
                                    <td><?php echo $value['role_id']?></td>
                                    <td><?php echo $value['role_name']?></td>
                                    <td><?php echo $value['desc']?></td>
                                    <td>
                                        <?php if($value['status']==1) echo "是";else echo "否"; ?>
                                    </td>
                                    <td class="td-do">
                                        <?php if($value['role_id'] != 1):?>
                                            <a href="/admin/role/access/<?php echo $value['role_id']?>"
                                               class="btn btn-warning btn-xs" data-toggle="tooltip" title="授权">
                                                <i class="fa fa-key"></i>
                                            </a>

                                            <a href="/admin/role/edit/<?php echo $value['role_id']?>"
                                               class="btn btn-primary btn-xs" title="修改" data-toggle="tooltip">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-danger btn-xs deleteRole" title="删除" data-id="<?php echo $value['role_id']?>" >
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <?php if($value['status'] == 1):?>
                                                <a class="btn btn-warning btn-xs roleStatus" title="禁用" data-id="<?php echo $value['role_id']?>" data-status="<?php echo $value['status']?>">
                                                    <i class="fa fa-circle"></i>
                                                </a>
                                            <?php else:?>
                                                <a class="btn btn-success btn-xs roleStatus" title="启用" data-id="<?php echo $value['role_id']?>" data-status="<?php echo $value['status']?>" >
                                                    <i class="fa fa-circle"></i>
                                                </a>
                                            <?php endif;?>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- 数据列表底部 -->
                    <div class="box-footer">
                        <?php echo $data["pager"]->links()?>
                        <label class="control-label pull-right" style="margin-right: 10px; font-weight: 100;">
                            <small>共<?php echo $data['count'];?>条记录</small>&nbsp;
                            <small>每页显示</small>
                            <select class="input-sm" onchange="changePerPage(this)">
                                <option value="10" <?php if($data['per_page'] == 10) echo "selected"?> >10</option>
                                <option value="20" <?php if($data['per_page'] == 20) echo "selected"?>>20</option>
                                <option value="30" <?php if($data['per_page'] == 30) echo "selected"?>>30</option>
                                <option value="50" <?php if($data['per_page'] == 50) echo "selected"?>>50</option>
                                <option value="100" <?php if($data['per_page'] == 100) echo "selected"?>>100</option>
                            </select>
                            &nbsp;
                            <small>条记录</small>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php echo $this->include("admin/public/footer")?>
<script>
    var keywords = "<?php echo $data['keyword']?>"
    //改变每页数量
    function changePerPage(obj) {
        var per_page = obj.value;
        window.location.href = "/admin/role/index?keyword="+keywords+"&per_page="+per_page
    }
</script>
<script>
    $(document).on("click",".deleteRole",function (e) {
        var role_id = $(this).attr("data-id");
        layer.confirm("确定要删除当前角色?删除后关联用户，权限都将被全部清理！请慎重", {title: "提示", closeBtn: 1, icon: 3}, function () {
            $.ajax({
                url:"/admin/role/delete",
                type:"POST",
                data:{role_id:role_id},
                dataType:"JSON",
                success:function(data){

                    if(data.status){
                        showMessage("success","操作成功","成功");

                        GoUrl("/admin/role/index",1);
                    }else{
                        showMessage("error",data.message,"失败");

                        return false;
                    }

                },error:function(e){
                    showMessage("error", "操作失败","失败");
                    return false;
                }
            })
        });
    })

    //角色状态
    $(document).on("click",".roleStatus",function (e) {
        var role_id = $(this).attr("data-id");
        var status = $(this).attr("data-status");
        var message = "确定要启用当前角色?关联用户将全部受到影响。";
        if(status == 1){
            message = "确定要禁用当前角色?关联用户将全部受到影响。"
        }
        layer.confirm(message, {title: "提示", closeBtn: 1, icon: 3}, function () {
            $.ajax({
                url:"/admin/role/roleStatus",
                type:"POST",
                data:{role_id:role_id},
                dataType:"JSON",
                success:function(data){

                    if(data.status){
                        showMessage("success","操作成功","成功");

                        GoUrl("/admin/role/index",1);
                    }else{
                        showMessage("error",data.message,"失败");

                        return false;
                    }

                },error:function(e){
                    showMessage("error", "操作失败","失败");
                    return false;
                }
            })
        });
    })


</script>
