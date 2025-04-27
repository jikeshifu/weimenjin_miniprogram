<?php /*a:1:{s:66:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/login/indexQrCode.html";i:1745560349;}*/ ?>
﻿<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo config('xhadmin.site_title'); ?></title>
    <link rel="shortcut icon" href="__PUBLIC__/static/favicon.ico">
    <!-- Bootstrap core CSS     -->
    <link href="__PUBLIC__/static/login_new/static/css/bootstrap.min.css" rel="stylesheet"/>
    <!--  Material Dashboard CSS    -->
    <link href="__PUBLIC__/static/login_new/static/css/material-dashboard.css" rel="stylesheet"/>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="__PUBLIC__/static/login_new/static/css/demo.css" rel="stylesheet"/>
    <!--     Fonts and icons     -->
    <link href="__PUBLIC__/static/login_new/static/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css"
          href="__PUBLIC__/static/login_new/static/css/e26f8e48f3f747dfa9fb3972355ed854.css">
    <!-- 	    <link href="__PUBLIC__/static/login_new/static/css/3a636a6d66e7464c94ec79220689e90e.css" rel="stylesheet"> -->

    <!-- 	<link href="__PUBLIC__/static/login_new/static/css/common.css" rel="stylesheet"> -->
    <script type="text/javascript">
        if (navigator.appName == 'Microsoft Internet Explorer') {
            if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
            }
        }

    </script>

    <script src="__PUBLIC__/static/js/jquery.min.js?v=2.1.4"></script>
    <script src="__PUBLIC__/static/js/plugins/layer/layer.min.js"></script>
    <script src="__PUBLIC__/static/js/common/ajax-object.js"></script>
    <script src="__PUBLIC__/static/js/common/Feng.js"></script>

    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/jquery-3.2.1.js"></script>


    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/material.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/perfect-scrollbar.jquery.min.js"></script>

    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/material-dashboard.js"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/demo.js"></script>


    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/util.js"></script>
    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/common.min.js"></script>

    <script type="text/javascript" src="__PUBLIC__/static/login_new/static/js/require.js"></script>

    <script src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery.qrcode.min.js"></script>

    <style>
        body .layer-ext-myskin .layui-layer-content {
            overflow: visible;
        }
    </style>
</head>
<body class="off-canvas-sidebar">
<nav class="navbar navbar-primary navbar-transparent navbar-absolute">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                <span class="sr-only"><?php echo config('xhadmin.site_title'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:volid(0);"><?php echo config('xhadmin.site_title'); ?></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">

<!--                <li class="">-->
<!--                    <a href="javascript:void(0)"-->
<!--                       onclick="openImg('https://<?php echo $_SERVER['HTTP_HOST']; ?>/qrdata/qrcode/adduser.png')">-->
<!--                        <i class="material-icons">person_add</i> 注册-->
<!--                    </a>-->
<!--                </li>-->
                <!--<li class="">
                    <a href="<?php echo url('supplier/Login/'); ?>">
                        <i class="material-icons">fingerprint</i> 伙伴登录
                    </a>
                </li>-->

            </ul>
        </div>

    </div>
</nav>
<div class="wrapper wrapper-full-page">
    <div class="full-page login-page" filter-color="black"
         data-image="__PUBLIC__/static/login_new/static/picture/login.jpeg">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">

                        <div class="card card-login card-hidden">
                            <div class="card-header text-center" data-background-color="rose">
                                <h4 class="card-title"><?php echo config('xhadmin.site_title'); ?></h4>
                                <div class="social-line">
                                </div>
                            </div>
                            <p class="category text-center">
                                <a href="/admin/Login/index">账号密码登录</a>
                            </p>
                            <div id="myQrcode" style="margin-top:30px;text-align: center">
                            </div>
                            <p class="category text-center">
                                直接用微信扫码即可注册并登录
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">

                <p class="copyright text-center">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                    <a href="javascript:volid(0);"> <?php echo config('xhadmin.site_title'); ?> </a>
                    <a href="https://beian.miit.gov.cn/"><?php echo config('xhadmin.copyright'); ?></a>
                </p>
            </div>
        </footer>
    </div>
</div>
</body>
</body>

<script type="text/javascript">
    var currentDomain = window.location.hostname; // 获取当前站点的域名
    var qrCodeText = "https://" + currentDomain + "/qrCodeLogin?key=<?php echo $cs; ?>"; // 动态构建域名
    $('#myQrcode').qrcode({text: qrCodeText});

    $().ready(function () {
        demo.checkFullPageBackgroundImage();

        setTimeout(function () {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)


        let aa = setInterval(function () {
            $.post("/admin/Login/indexQrCode",
                {
                    data: "<?php echo $cs; ?>",

                },
                function (data, status) {
                    console.log("data", data)

                    if (data.code == 0) {


                        clearInterval(aa);
                        window.location.replace("/admin");
                    }

                });
        }, 3000)
    });


</script>

<script type="text/javascript">
    document.onkeydown = function (e) {
        var ev = document.all ? window.event : e;
        if (ev.keyCode == 13) {
            login();
        }
    };

    $('#username').focus();

    function login() {
        var username = $("#username").val();
        var password = $("#password").val();
        var verify = $("#averfiy").val();

        if (!username || !password) {
            Feng.info("请输入用户名或者密码！");
            return false;
        }

        if (!verify) {
            Feng.info("请输入验证码！");
            return false;
        }

        var ajax = new $ax("<?php echo url('admin/Login/index'); ?>", function (data) {
            if (1 === data.code) {
                Feng.success(data.msg);
                $("#submit").val('正在登陆');
                window.location.href = data.url;
            } else {
                $("#img").attr('src', "<?php echo url('admin/Login/Verify'); ?>?=" + Math.random());
                Feng.error(data.msg);
            }

        });
        ajax.set('username', username);
        ajax.set('password', password);
        ajax.set('verify', verify);
        ajax.start();
    }

    openImg = function (value) {
        var img = "<img src=" + value + " height=\"450px\" style=\"max-width:500px\">";
        layer.open({
            type: 1,
            shade: false,
            title: false, //不显示标题
            area: ['auto', 'auto'],
            //area: '500px',
            area: [img.width + 'px', img.height + 'px'],
            content: img, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            cancel: function () {
                //layer.msg('图片查看结束！', { time: 5000, icon: 6 });
            }
        });
    }

    function reset() {
        $("#username").val('');
        $("#password").val('')
        $("#averfiy").val('')
    }

</script>
</html>
