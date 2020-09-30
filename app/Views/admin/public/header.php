<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>管理后台</title>
    <?php if ($mobile === FALSE): ?>
        <!--[if IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <?php else: ?>
        <meta name="HandheldFriendly" content="true">
    <?php endif; ?>
    <?php if ($mobile == TRUE && $mobile_ie == TRUE): ?>
        <meta http-equiv="cleartype" content="on">
    <?php endif; ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="google" content="notranslate">
    <meta name="robots" content="noindex, nofollow">
    <?php if ($mobile == TRUE && $ios == TRUE): ?>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="管理后台">
    <?php endif; ?>
    <?php if ($mobile == TRUE && $android == TRUE): ?>
        <meta name="mobile-web-app-capable" content="yes">
    <?php endif; ?>
    <link rel="icon" href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAqElEQVRYR+2WYQ6AIAiF8W7cq7oXd6v5I2eYAw2nbfivYq+vtwcUgB1EPPNbRBR4Tby2qivErYRvaEnPAdyB5AAi7gCwvSUeAA4iis/TkcKl1csBHu3HQXg7KgBUegVA7UW9AJKeA6znQKULoDcDkt46bahdHtZ1Por/54B2xmuz0uwA3wFfd0Y3gDTjhzvgANMdkGb8yAyY/ro1d4H2y7R1DuAOTHfgAn2CtjCe07uwAAAAAElFTkSuQmCC">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,700italic">
    <!--    css加载-->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/font-awesome//all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/adminlte/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/adminlte/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="/assets/plugins/animsition/animsition.min.css">
    <link rel="stylesheet" href="/assets/plugins/colorpickersliders/colorpickersliders.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/domprojects/css/dp.min.css">
    <link rel="stylesheet" href="/assets/plugins/iconpicker/css/iconpicker.min.css">
    <link rel="stylesheet" href="/assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css">
    <link href="/assets/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/layer/theme/default/layer.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/plugins/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>

    <link href="/assets/plugins/fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <!--    js加载，有一些预加载的数据需要js组件，只能放在头部-->
    <script src="/assets/jquery/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/slimscroll/slimscroll.min.js"></script>
    <?php if ($mobile == TRUE): ?>
        <script src="/assets/plugins/fastclick/fastclick.min.js"></script>
    <?php endif; ?>
    <script src="/assets/plugins/pwstrength/pwstrength.min.js"></script>
    <script src="/assets/plugins/tinycolor/tinycolor.min.js"></script>
    <script src="/assets/plugins/colorpickersliders/colorpickersliders.min.js"></script>
    <script src="/assets/adminlte/js/adminlte.min.js"></script>
    <script src="/assets/domprojects/js/dp.min.js"></script>
    <script src="/assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="/assets/plugins/iconpicker/js/iconpicker.min.js"></script>
    <script src="/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="/assets/plugins/bootstrap-number/bootstrap-number.min.js"></script>
    <script src="/assets/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/layer/layer.js" type="text/javascript"></script>
    <script src="/assets/plugins/fileinput/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/fileinput/js/fileinput.min.js" type="text/javascript"></script>
    <script src="/assets/plugins/fileinput/js/locales/zh.min.js" type="text/javascript"></script>

    <script src="/assets/plugins/fileinput/themes/fas/theme.js" type="text/javascript"></script>
    <script src="/assets/plugins/fileinput/themes/explorer-fas/theme.js" type="text/javascript"></script>

    <script src="/assets/plugins/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>


    <?php if ($mobile === FALSE): ?>
        <!--[if lt IE 9]>
        <script src="/assets/html5shiv/html5shiv.min.js"></script>
        <script src="/assets/plugins/respond/respond.min.js"></script>
        <![endif]-->
    <?php endif; ?>

    <style>
        .toast-center-center {
            top: 30%;
            left: 50%;
            margin-top: -30px;
            margin-left: -150px;
        }
    </style>

</head>
<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">