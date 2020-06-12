<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>菜单管理</h1>
        <!--        --><?php //echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <br>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div>
                            <a title="添加" data-toggle="tooltip" class="btn btn-primary btn-sm " href="/admin/menu/add/0">
                                <i class="fa fa-plus"></i> 添加
                            </a>
                            <a class="btn btn-success btn-sm ReloadButton" data-toggle="tooltip" title="刷新"
                               data-id="checked" data-url="/admin/menu/index">
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
                                <th>菜单名称</th>
                                <th>url</th>
                                <th>父级ID</th>
                                <th>图标</th>
                                <th>排序</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $table_html;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php echo $this->include("admin/public/footer")?>
