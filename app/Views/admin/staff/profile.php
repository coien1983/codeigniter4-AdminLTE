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
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">管理员信息</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <tr>
                                <th>管理序号:</th>
                                <td><?php echo $admin['a_serial'];?></td>
                            </tr>
                            <tr>
                                <th>登录名:</th>
                                <td><?php echo $admin['a_name']; ?></td>
                            </tr>
                            <tr>
                                <th>真实姓名:</th>
                                <td><?php echo $admin['real_name']; ?></td>
                            </tr>
                            <tr>
                                <th>联系手机:</th>
                                <td><?php echo $admin['a_mobile']?></td>
                            </tr>
                            <tr>
                                <th>管理组:</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>创建时间:</th>
                                <td><?php echo date('Y-m-d H:i:s', $admin['created_at']); ?></td>
                            </tr>

                            <tr>
                                <th>状态:</th>
                                <td>
                                    <?php if($admin['is_lock'] == 1): ?>
                                        <span class="label label-default">锁定中</span>
                                    <?php else:?>
                                        <span class="label label-success">正常</span>
                                    <?php endif?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php echo $this->include("admin/public/footer")?>
