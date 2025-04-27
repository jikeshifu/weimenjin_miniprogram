<?php /*a:2:{s:65:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/app_config/index.html";i:1731647734;s:66:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/common/_container.html";i:1731647734;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit"/><!-- 让360浏览器默认选择webkit内核 -->

    <!-- 全局css -->
    <!-- 全局css -->
    <link rel="shortcut icon" href="__PUBLIC__/static/favicon.ico">
    <link href="__PUBLIC__/static/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="__PUBLIC__/static/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="__PUBLIC__/static/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="__PUBLIC__/static/css/plugins/validate/bootstrapValidator.min.css" rel="stylesheet">
    <link href="__PUBLIC__/static/css/animate.css" rel="stylesheet">
    <link href="__PUBLIC__/static/css/style.css?v=4.1.0" rel="stylesheet">
     <link rel="stylesheet" href="__PUBLIC__/static/js/plugins/layui/css/layui.css?ver=170803"  media="all">
    
    <link href="__PUBLIC__/static/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="__PUBLIC__/static/css/plugins/webuploader/webuploader.css" rel="stylesheet">
    <link href="__PUBLIC__/static/css/plugins/ztree/zTreeStyle.css" rel="stylesheet">
    <link href="__PUBLIC__/static/css/plugins/jquery-treegrid/css/jquery.treegrid.css" rel="stylesheet"/>
    <!-- <link href="__PUBLIC__/static/css/plugins/ztree/demo.css" rel="stylesheet"> -->

    <!-- 全局js -->
    <script src="__PUBLIC__/static/js/jquery.min.js?v=2.1.4"></script>
    <script src="__PUBLIC__/static/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="__PUBLIC__/static/js/plugins/ztree/jquery.ztree.all.min.js"></script>
    <script src="__PUBLIC__/static/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="__PUBLIC__/static/js/plugins/validate/bootstrapValidator.min.js"></script>
    <script src="__PUBLIC__/static/js/plugins/validate/zh_CN.js"></script>
    <script src="__PUBLIC__/static/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
    <script src="__PUBLIC__/static/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
    <script src="__PUBLIC__/static/js/plugins/jquery-treegrid/js/jquery.treegrid.min.js"></script>
    <script src="__PUBLIC__/static/js/plugins/jquery-treegrid/js/jquery.treegrid.bootstrap3.js"></script>
    <script src="__PUBLIC__/static/js/plugins/jquery-treegrid/extension/jquery.treegrid.extension.js"></script>
    <script src="__PUBLIC__/static/js/plugins/layer/layer.min.js"></script>
    <script src="__PUBLIC__/static/js/plugins/iCheck/icheck.min.js"></script>
    <script src="__PUBLIC__/static/js/plugins/layer/laydate/laydate.js"></script>
    <script src="__PUBLIC__/static/js/plugins/layui/layui.js"></script>
    <script src="__PUBLIC__/static/js/plugins/webuploader/webuploader.min.js"></script>
    <script src="__PUBLIC__/static/js/common/ajax-object.js"></script>
    <script src="__PUBLIC__/static/js/common/bootstrap-table-object.js"></script>
    <script src="__PUBLIC__/static/js/common/tree-table-object.js"></script>
    <script src="__PUBLIC__/static/js/common/web-upload-object.js"></script>
    <script src="__PUBLIC__/static/js/common/ztree-object.js"></script>
    <script src="__PUBLIC__/static/js/common/Feng.js"></script>
	<script type="text/javascript" src="__PUBLIC__/static/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="__PUBLIC__/static/js/ueditor/ueditor.all.min.js"> </script>
	<script type="text/javascript" src="__PUBLIC__/static/js/xheditor/xheditor-1.2.2.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/static/js/xheditor/xheditor_lang/zh-cn.js"></script>
    <script type="text/javascript">
		<?php
			$domains = config('app.domain_bind');
			$app = app('http')->getName();
			if(in_array($app,$domains)){			
				$ctxPathUrl = '';
			}else{
				$ctxPathUrl = '/'.getKeyByVal(config('app.app_map'),$app);
			}
		?>
        Feng.addCtx("<?php echo $ctxPathUrl;?>");
        Feng.sessionTimeoutRegistry();
      window._AMapSecurityConfig = {
        securityJsCode: "a0b77e3e60d99556b9ced57fb1ee7503",
      }

    </script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
	
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <form id="configForm" method="post" action="<?php echo url('admin/AppConfig/save'); ?>" class="form-horizontal">
            <!-- 遍历每个配置分组 -->
            <?php if(is_array($configs) || $configs instanceof \think\Collection || $configs instanceof \think\Paginator): $module = 0; $__LIST__ = $configs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($module % 2 );++$module;?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <!-- 显示模块的中文名称 -->
                    <h3 class="panel-title"><?php echo $group['module_name']; ?></h3>
                </div>
                <div class="panel-body">
                    <!-- 遍历分组内的配置项 -->
                    <?php if(is_array($group['configs']) || $group['configs'] instanceof \think\Collection || $group['configs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $group['configs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$config): $mod = ($i % 2 );++$i;?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $config['description']; ?>：</label>
                        <div class="col-sm-10">
                            <?php switch($config['type']): case "string": if($config['name'] == 'nocheck' || strlen($config['value']) > 50): ?>
                                <textarea
                                        class="form-control"
                                        name="<?php echo $config['name']; ?>"
                                        placeholder="请输入<?php echo $config['description']; ?>"
                                        rows="5"
                                        <?php if($config['is_readonly']): ?>disabled<?php endif; ?>
                                ><?php echo $config['value']; ?></textarea>
                                <?php else: ?>
                                <input
                                        type="text"
                                        class="form-control"
                                        name="<?php echo $config['name']; ?>"
                                        value="<?php echo $config['value']; ?>"
                                        placeholder="请输入<?php echo $config['description']; ?>"
                                        <?php if($config['is_readonly']): ?>readonly<?php endif; ?>
                                >
                                <?php endif; break; case "array": if($config['name'] == 'nocheck' || strlen($config['value']) > 50): ?>
                            <textarea
                                    class="form-control"
                                    name="<?php echo $config['name']; ?>"
                                    placeholder="请输入<?php echo $config['description']; ?>"
                                    rows="5" <?php if($config['is_readonly']): ?>disabled<?php endif; ?> ><?php echo $config['value']; ?></textarea>
                            <?php else: ?>
                            <input
                                    type="text"
                                    class="form-control"
                                    name="<?php echo $config['name']; ?>"
                                    value="<?php echo $config['value']; ?>"
                                    placeholder="请输入<?php echo $config['description']; ?>" <?php if($config['is_readonly']): ?>disabled<?php endif; ?> >
                            <?php endif; break; case "integer": ?>
                            <input
                                    type="number"
                                    class="form-control"
                                    name="<?php echo $config['name']; ?>"
                                    value="<?php echo $config['value']; ?>"
                                    placeholder="请输入<?php echo $config['description']; ?>" <?php if($config['is_readonly']): ?>disabled<?php endif; ?> >
                            <?php break; case "boolean": ?>
                            <div class="radio">
                                <label>
                                    <input
                                            type="radio"
                                            name="<?php echo $config['name']; ?>"
                                            value="1"
                                            <?php if($config['value'] == 1): ?>checked<?php endif; if($config['is_readonly']): ?>disabled<?php endif; ?> > 是
                                </label>
                                <label>
                                    <input
                                            type="radio"
                                            name="<?php echo $config['name']; ?>"
                                            value="0"
                                            <?php if($config['value'] == 0): ?>checked<?php endif; if($config['is_readonly']): ?>disabled<?php endif; ?>> 否
                                </label>
                            </div>
                            <?php break; default: ?>
                            <input
                                    type="text"
                                    class="form-control"
                                    name="<?php echo $config['name']; ?>"
                                    value="<?php echo $config['value']; ?>"
                                    placeholder="请输入<?php echo $config['description']; ?>" <?php if($config['is_readonly']): ?>disabled<?php endif; ?> >
                            <?php endswitch; ?>
                            <!-- 添加说明 -->

                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="help-content">
                    <p class="help-block">
                        <?php switch($group['module']): case "wxmp": ?>
                        说明：登录<a href="https://mp.weixin.qq.com" target="_blank">https://mp.weixin.qq.com</a>管理--开发管理--获取。
                        <?php break; case "official_accounts": ?>
                        说明：登录<a href="https://mp.weixin.qq.com" target="_blank">https://mp.weixin.qq.com</a>获取。
                        <?php break; case "wmjv1": ?>
                        说明：从<a
                                href="https://www.wmj.com.cn/open/apilogin"
                                target="_blank">https://www.wmj.com.cn/open/apilogin</a>注册获取，适用于序列号前缀为WMJ16/18/19/26/62的设备。
                        <?php break; case "wmjv2": ?>
                        说明：从<a href="https://wdev.wmj.com.cn/"
                                                                target="_blank">https://wdev.wmj.com.cn/</a>注册获取,
                        适用于序列号前缀为W70、W71、W72、W76、W77、W89的设备。
                        回调地址已自动生成如下，请填写到获取appid处，用于获取设备主动上报信息。<input type="text" class="form-control" id="callbackUrl" readonly>
                        <?php break; case "alipay": ?>
                        说明：登录<a href="https://open.alipay.com/" target="_blank">https://open.alipay.com/</a>获取。
                        <?php break; case "toutiao": ?>
                        说明：登录<a href="https://developer.open-douyin.com/" target="_blank">https://developer.open-douyin.com/</a>获取。
                        <?php break; case "wmjsms": ?>
                        说明：登录<a href="https://wxapp.wmj.com.cn/" target="_blank">https://wxapp.wmj.com.cn/</a>注册获取,每条5分钱; <span style="color: #ee162d">填写上面的参数保存一次后再测试</span>。
                        <!-- 显示短信通知示例 -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">短信通知示例：</label>
                            <div class="col-sm-9">
                                <div id="smsExample">【微门禁】有异常用户扫码开门，如需关注，请及时查看情况。</div>
                            </div>
                        </div>

                        <!-- 发送测试短信功能 -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">测试手机号：</label>
                            <div class="col-sm-9">
                                <input type="text" id="testPhoneNumber" class="form-control" placeholder="请输入测试手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">测试内容：</label>
                            <div class="col-sm-9">
                                <textarea id="sms_content" class="form-control" placeholder="请输入短信内容">有异常用户扫码开门，如需关注，请及时查看情况。</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-success" id="sendTestSms">
                                    <i class="fa fa-paper-plane"></i>&nbsp;发送测试短信
                                </button>
                            </div>
                        </div>
                        <?php break; default: ?>
                        <?php endswitch; ?>
                    </p>
                    </div>
                </div>

            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>

            <!-- 提交按钮 -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> 保存配置
                    </button>
                    <button type="button" class="btn btn-danger" id="cancelBtn">
                        <i class="fa fa-times"></i> 取消
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JS 部分 -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var currentUrl = window.location.origin;
        var callbackPath = "/api/device.Callback/lock";
        var fullCallbackUrl = currentUrl + callbackPath;
        // 设置回调地址到输入框中
        document.getElementById("callbackUrl").value = fullCallbackUrl;
    });
    $(document).ready(function () {
        // 初始化Layui（如果需要）
        layui.use(['layer', 'form'], function () {
            var layer = layui.layer;
            var form = layui.form;
        });

        $('#configForm').on('submit', function (e) {
            e.preventDefault(); // 阻止默认提交行为

            let formData = $(this).serializeArray();
            let data = {};

            // 转换表单数据为对象形式
            $.each(formData, function (_, field) {
                if (field.name === 'nocheck') {
                    try {
                        // 将 textarea 的值解析为数组，如果已经是数组则无需多次编码
                        data[field.name] = JSON.parse(field.value);
                    } catch (e) {
                        // 处理解析失败的情况，按换行符拆分为数组
                        data[field.name] = field.value.split('\n').map(url => url.trim()).filter(url => url);
                    }
                } else {
                    data[field.name] = field.value;
                }
            });

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function (response) {
                    if (response.status === 'success') {
                        window.location.reload(); // 保存成功后刷新页面
                    } else {
                        alert('保存失败：' + response.message);
                    }
                },
                error: function () {
                    alert('保存失败，请稍后重试。');
                }
            });
        });

        // 处理取消按钮
        $('#cancelBtn').on('click', function () {
            if (confirm('确定要取消吗？未保存的数据将丢失。')) {
                window.location.reload(); // 重新加载页面
            }
        });
    });
    document.getElementById("sendTestSms").addEventListener("click", function () {
        const phoneNumber = document.getElementById("testPhoneNumber").value;
        const smsLabel = "【微门禁】";
        const smsContent = document.getElementById("sms_content").value;

        if (!phoneNumber || !smsLabel || !smsContent) {
            layer.alert("请输入完整信息");
            return;
        }

        // 发送测试短信的请求
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "<?php echo url('admin/Lock/sendTestSms'); ?>", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.code === 200) {
                    layer.msg("短信发送成功！ 短信ID: " + response.smsId + "，余额: " + response.balance, {
                        time: 10000 // 设置提示时间为5000毫秒（5秒）
                    });
                } else {
                    layer.msg("短信发送失败: " + response.msg, {
                        time: 10000 // 设置提示时间为5000毫秒（5秒）
                    });

                }
            }
        };
        xhr.send(`phone=${encodeURIComponent(phoneNumber)}&sms_label=${encodeURIComponent(smsLabel)}&content=${encodeURIComponent(smsContent)}`);
    });
</script>

</div>
<script src="__PUBLIC__/static/js/content.js?v=1.0.0"></script>

</body>
</html>
