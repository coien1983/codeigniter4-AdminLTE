<header class="main-header">
    <a href="" class="logo">
        <span class="logo-mini"><b>A</b>LTE</span>
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages -->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">你有有 0 条未读信息</li>
                        <li>
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="/upload/avatar/m_002.png" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>Support Team<small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li><!-- end message -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#"></a></li>
                    </ul>
                </li>

                <!-- User Account -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/upload/avatar/m_001.png" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo session("real_name"); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="/upload/avatar/m_001.png" class="img-circle" alt="User Image">
                            <p><?php echo session("real_name");?><small>2020-06-18</small></p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/admin/staff/profile" class="btn btn-default btn-flat">个人信息</a>
                            </div>
                            <div class="pull-right">
                                <a href="/admin/staff/logout" class="btn btn-default btn-flat">退出登录</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
