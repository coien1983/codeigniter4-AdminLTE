<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>用户管理</h1>
        <!--        --><?php //echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <br>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <form class="form-inline searchForm" id="searchForm" action="/admin/staff/index" method="GET">

                            <div class="form-group">
                                <input value="<?php echo $data['keyword']?>"
                                       name="keyword" id="keyword" class="form-control input-sm" placeholder="昵称/账号">
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
                            <a title="添加" data-toggle="tooltip" class="btn btn-primary btn-sm "  href="/admin/staff/add">
                                <i class="fa fa-plus"></i> 添加
                            </a>
                            <a class="btn btn-success btn-sm ReloadButton" data-toggle="tooltip" title="刷新" data-id="checked" data-url="/admin/staff/add">
                                <i class="fa fa-refresh"></i> 刷新
                            </a>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered datatable" width="100%">
                            <thead>
                            <tr>
                                <th>
                                    <input id="dataCheckAll" type="checkbox" onclick="checkAll(this)" class="checkbox" placeholder="全选/取消">
                                </th>
                                <th>ID</th>
                                <th>昵称</th>
                                <th>账号</th>
                                <th>角色</th>
                                <th>是否启用</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data['lists'] as $key=>$value):?>
                                <tr>
                                    <td>
                                        <input type="checkbox" onclick="checkThis(this)" name="data-checkbox"
                                               data-id="<?php echo $value['a_id']?>" class="checkbox data-list-check" value="<?php echo $value['a_id']?>"
                                               placeholder="选择/取消">
                                    </td>
                                    <td><?php echo $value['a_id']?></td>
                                    <td><?php echo $value['a_name']?></td>
                                    <td><?php echo $value['real_name']?></td>
                                    <td>
                                        <small class="label bg-blue"><?php echo $data['roles'][$value['role_id']]?></small>
                                    </td>
                                    <td>
                                        <?php if($value['is_lock'] == 1) echo "否";else echo "是";?>
                                    </td>
                                    <td class="td-do">
                                        <?php if($value['a_id'] != 1):?>
                                            <a href="/admin/staff/edit/<?php echo $value['a_id']?>"
                                               class="btn btn-primary btn-xs" title="修改" data-toggle="tooltip">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <a class="btn btn-danger btn-xs deleteRole" title="删除" data-id="<?php echo $value['role_id']?>" >
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <?php if($value['is_lock'] == 1):?>
                                                <a class="btn btn-warning btn-xs roleStatus" title="启用" data-id="<?php echo $value['a_id']?>" data-status="<?php echo $value['is_lock']?>">
                                                    <i class="fa fa-circle"></i>
                                                </a>
                                            <?php else:?>
                                                <a class="btn btn-success btn-xs roleStatus" title="禁用" data-id="<?php echo $value['a_id']?>" data-status="<?php echo $value['is_lock']?>" >
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
        </div>
    </section>

</div>
<?php echo $this->include("admin/public/footer")?>

<script>
    var keywords = "<?php echo $data['keyword']?>"
    //改变每页数量
    function changePerPage(obj) {
        var per_page = obj.value;
        window.location.href = "/admin/staff/index?keyword="+keywords+"&per_page="+per_page
    }
</script>
