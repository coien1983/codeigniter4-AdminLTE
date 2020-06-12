<?php echo $this->include("admin/login_public/header");?>

<div class="login-logo">
    <a href="#"><b>CI4</b>LTE</a>
</div>

<div class="login-box-body">
    <form method="post" action="/admin/login">
        <div class="form-group has-feedback">
            <input type="text" name="a_name" required class="form-control" placeholder="登录名" value="">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="a_password" required class="form-control" placeholder="登录密码" >
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" id="remember" name="remember">记住我
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <input type="submit" class="btn btn-primary btn-block btn-flat" value="登录">
            </div>
        </div>
    </form>
</div>

<?php echo $this->include("admin/login_public/footer")?>
<script>

    $(document).ready(function () {
        $("input[type='submit']").on("click",function (e) {
            e.preventDefault();
            // showMessage("success","轮播修改成功","成功");
            $.ajax({
                "url":"/admin/manage/login",
                "type":"POST",
                "data":$("form").serialize(),
                "dataType":"JSON",
                "success":function (res) {
                    if(res.status){
                        showMessage("success","登录成功","成功");
                        GoUrl("/admin/index/index",1);
                    }else{
                        showMessage("error",res.message,"失败");
                    }
                }
            })
        })


    })
</script>