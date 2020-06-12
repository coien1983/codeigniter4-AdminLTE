<?php echo $this->include("admin/public/header");?>
<?php echo $this->include("admin/public/main_header");?>
<?php echo $this->include("admin/public/main_sidebar");?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>后台首页</h1>
        <!--        --><?php //echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>
    <br>
    <section class="content">

        <div class="row">
            <div class="pad margin no-print">
                <div class="callout callout-info">
                    <h4><i class="fa fa-info"></i> 您好,管理员:</h4>
                    <?php echo $notice_content;?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fa fa-user"></i>
                </span>
                    <div class="info-box-content">
                        <span class="info-box-text">后台用户</span>
                        <span class="info-box-number"><?php echo $admin_user_count;?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-red">
                    <i class="fa fa-users"></i>
                </span>
                    <div class="info-box-content">
                        <span class="info-box-text">后台角色</span>
                        <span class="info-box-number"><?php echo $admin_role_count;?></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-green">
                    <i class="fa fa-list"></i>
                </span>
                    <div class="info-box-content">
                        <span class="info-box-text">后台菜单</span>
                        <span class="info-box-number"><?php echo $admin_menu_count;?></span>
                    </div>
                </div>
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <i class="fa fa-keyboard-o"></i>
                </span>

                    <div class="info-box-content">
                        <span class="info-box-text">操作日志</span>
                        <span class="info-box-number"><?php echo $admin_log_count;?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <section class="col-lg-7 connectedSortable" id="sortable1">

                <div class="box sortable-widget" id="user_info">
                    <div class="box-header with-border">
                        <h3 class="box-title">访问信息</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>用户系统</th>
                                <td></td>
                                <th>用户IP</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th>浏览器</th>
                                <td></td>
                                <th>所在城市</th>
                                <td></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box sortable-widget" id="system_info">
                    <div class="box-header with-border">
                        <h3 class="box-title">系统信息</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <th>服务器系统</th>
                                <td></td>
                                <th>服务器IP</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th>PHP版本</th>
                                <td></td>
                                <th>运行内存限制</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th>最大文件上传限制</th>
                                <td></td>
                                <th>单次上传数量限制</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th>最大POST限制</th>
                                <td></td>
                                <th>项目磁盘剩余容量</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th>PHP版本</th>
                                <td></td>
                                <th>后台系统版本</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th>MySql版本</th>
                                <td></td>
                                <th>PHP当前运行模式</th>
                                <td></td>
                            </tr>

                            <tr>
                                <th>PHP当前时区</th>
                                <td></td>
                                <th>PHP当前时间</th>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="col-lg-5 connectedSortable" id="composer_info">
                <div class="box sortable-widget" id="widget2">
                    <div class="box-header with-border">
                        <h3 class="box-title">依赖关系</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </section>
</div>
<?php echo $this->include("admin/public/footer")?>
