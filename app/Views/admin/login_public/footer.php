</div>

<script src="/assets/jquery/jquery.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/plugins/icheck/js/icheck.min.js"></script>
<script src="/assets/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<script>
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

    $(function(){
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });


    });

</script>
</body>
</html>