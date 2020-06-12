<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>version</b> Development
    </div>
    <strong>Copyright &copy; 2014-<?php echo date('Y'); ?> <a href="http://almsaeedstudio.com" target="_blank">Almsaeed Studio</a> &amp; <a href="https://domprojects.com" target="_blank">domProjects</a>.</strong> All rights reserved.
</footer>
</div>


<script>
//    侧栏菜单相关操作
    sidebar_menu();
    function sidebar_menu() {

        var li_id = "";
        var add_class = "active";
        if ($(".sidebar-menu").html()) {
            var pathname = window.location.pathname;
            console.log(pathname)
            if (pathname) {
                var pathArray = pathname.split("/");

                if (pathArray.length == 3)
                    li_id = "J_" + pathArray[1] + "_" + pathArray[2];
                if (pathArray.length == 4 || pathArray.length == 5)
                    li_id = "J_" + pathArray[2] + "_" + pathArray[3];
                // 判断 如果最后一段为数字 则寻找pathArray[1]_index为当前结点
                if (!isNaN(pathArray[4])) {
                    li_id = "J_" + pathArray[2] + "_" + pathArray[3];
                }

            }

            if ($("#" + li_id).length > 0) {
                $("#" + li_id).addClass("active");
                $("#" + li_id).parent().parent().addClass(add_class)
            }
        }
    }

    /* 返回按钮 */
    $('body').on('click', '.BackButton', function (event) {
        event.preventDefault();
        history.back(1);
    });

    toastr.options = {
        "closeButton" : true,
        "debug" : false,
        "positionClass" : "toast-center-center",
        "onclick" : null,
        "showDuration" : "1000",
        "hideDuration" : "1000",
        "timeOut" : "3000",
        "extendedTimeOut" : "1000",
        "showEasing" : "swing",
        "hideEasing" : "linear",
        "showMethod" : "fadeIn",
        "hideMethod" : "fadeOut"
    };

    function showMessage(type,message,title){
        toastr[type](message, title);
    }

    function GoUrl(url,mins)
    {
        setTimeout(function(){window.location.href=url;},mins*1000);
    }

    $('body').on('click', '.ReloadButton', function (event) {
        event.preventDefault();
        window.location.reload()
    });

    /* 清除搜索表单 */
    function clearSearchForm() {
        let url_all = window.location.href;
        let arr = url_all.split('?');
        let url = arr[0];
        window.location.href = url
    }

    //菜单搜索
    $('#sidebar-form').on('submit', function (e) {
        e.preventDefault();
    });

    $('.sidebar-menu li.active').data('lte.pushmenu.active', true);

    $('#search-input').on('keyup', function () {
    var term = $('#search-input').val().trim();

    if (term.length === 0) {
        $('.sidebar-menu li').each(function () {
            $(this).show(0);
            $(this).removeClass('active');
            if ($(this).data('lte.pushmenu.active')) {
                $(this).addClass('active');
            }
        });
        return;
    }

    $('.sidebar-menu li').each(function () {
        if ($(this).text().toLowerCase().indexOf(term.toLowerCase()) === -1) {
            $(this).hide(0);
            $(this).removeClass('pushmenu-search-found', false);

            if ($(this).is('.treeview')) {
                $(this).removeClass('active');
            }
        } else {
            $(this).show(0);
            $(this).addClass('pushmenu-search-found');

            if ($(this).is('.treeview')) {
                $(this).addClass('active');
            }

            var parent = $(this).parents('li').first();
            if (parent.is('.treeview')) {
                parent.show(0);
            }
        }

        if ($(this).is('.header')) {
            $(this).show();
        }
    });

    $('.sidebar-menu li.pushmenu-search-found.treeview').each(function () {
        $(this).find('.pushmenu-search-found').show(0);
    });
});
</script>
</body>
</html>