<?php /*a:2:{s:61:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/config/index.html";i:1731647734;s:66:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/common/_container.html";i:1731647734;}*/ ?>
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
		<div class="form-horizontal" id="CodeInfoForm">
			<div class="row">
				<div class="layui-tab layui-tab-brief" lay-filter="test">
					<ul class="layui-tab-title">
						<li class="layui-this">基本设置</li>
						<li>上传配置</li>
						<li>接口配置</li>
						<li>隐私政策</li>
						<li>服务协议</li>
					</ul>
					<div class="layui-tab-content" style="margin-top:10px;">
						<div class="layui-tab-item layui-show">
							<div class="col-sm-7">
								<!-- form start -->
								<div class="form-group">
									<label class="col-sm-2 control-label">站点名称：</label>
									<div class="col-sm-9">
										<input type="text" id="site_title" value="<?php echo $info['site_title']; ?>" name="site_title"
											   class="form-control" placeholder="请输入站点名称">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">站点LOGO：</label>
									<div class="col-sm-5">
										<input type="text" id="site_logo" value="<?php echo $info['site_logo']; ?>" <?php if(config('my.img_show_status') == true): ?>onmousemove="showBigPic(this.value)" onmouseout="closeimg()" <?php endif; ?>
										name="site_logo" class="form-control" placeholder="请输入站点LOGO">
										<span class="help-block m-b-none site_logo_process"></span>
									</div>
									<div class="col-sm-2" style="position:relative; right:30px;">
										<span id="site_logo_upload"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">关键词站点：</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" data-role="tagsinput" id="keyword"
											   value="<?php echo $info['keyword']; ?>" name="keyword">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">站点描述：</label>
									<div class="col-sm-9">
                                        <textarea id="description" name="description" class="form-control"
												  placeholder="请输入站点描述"><?php echo $info['description']; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">站点版权：</label>
									<div class="col-sm-9">
										<input type="text" id="copyright" value="<?php echo $info['copyright']; ?>" name="copyright"
											   class="form-control" placeholder="请输入站点版权">
									</div>
								</div>
								<!-- form end -->
							</div>
						</div>
						<div class="layui-tab-item">
							<div class="col-sm-7">
								<!-- form start -->
								<div class="form-group">
									<label class="col-sm-2 control-label">上传文件大小：</label>
									<div class="col-sm-9">
										<input type="text" id="file_size" value="<?php echo $info['file_size']; ?>" name="file_size"
											   class="form-control" placeholder="请输入上传文件大小">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">文件类型：</label>
									<div class="col-sm-9">
                                        <textarea id="file_type" name="file_type" class="form-control"
												  placeholder="请输入文件类型"><?php echo $info['file_type']; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">绑定域名：</label>
									<div class="col-sm-9">
										<input type="text" id="domain" value="<?php echo $info['domain']; ?>" name="domain"
											   class="form-control" placeholder="请输入绑定域名">
										<span class="help-block m-b-none">上传目录绑定域名访问，请解析域名到 /public/upload目录  前面带上http://  非必填项</span>
									</div>
								</div>
								<!-- form end -->
							</div>
						</div>
						<div class="layui-tab-item">
							<div class="col-sm-7">
								<!-- form start -->
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="control-label">V1版本硬件从<a
											href="https://www.wmj.com.cn/open/apilogin"
											target="_blank">https://www.wmj.com.cn/open/apilogin</a>注册获取,</label>
									<label class="control-label">序列号前缀为:WMJ16/18/19/26/62。</label>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">appid：</label>
									<div class="col-sm-9">
										<input type="text" id="wmjappid" value="<?php echo $info['wmjappid']; ?>" name="wmjappid"
											   class="form-control" placeholder="请输入微门禁appid">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">appsecret：</label>
									<div class="col-sm-9">
										<input type="text" id="wmjappsecret" value="<?php echo $info['wmjappsecret']; ?>"
											   name="wmjappsecret" class="form-control"
											   placeholder="请输入微门禁appsecret">
									</div>
								</div>
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="control-label">V2版本从<a href="https://wdev.wmj.com.cn/"
																			target="_blank">https://wdev.wmj.com.cn/</a>注册获取,</label>
									<label class="control-label">序列号前缀为:W70、W71、W72、W76、W77、W89,回调地址填到获取appid的位置。</label>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">appid：</label>
									<div class="col-sm-9">
										<input type="text" id="yjy_appid" value="<?php echo $info['yjy_appid']; ?>" name="yjy_appid"
											   class="form-control" placeholder="请输入微门禁appid">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">appsecret：</label>
									<div class="col-sm-9">
										<input type="text" id="yjy_appsecret" value="<?php echo $info['yjy_appsecret']; ?>"
											   name="yjy_appsecret" class="form-control"
											   placeholder="请输入微门禁appsecret">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">回调地址：</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="callbackUrl" readonly>
									</div>
								</div>
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="control-label">短信接口配置<a href="https://wxapp.wmj.com.cn/"
																				target="_blank">https://wxapp.wmj.com.cn/</a>注册获取,每条5分钱。</label>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">sms_appid：</label>
									<div class="col-sm-9">
										<input type="text" id="sms_appid" value="<?php echo $info['sms_appid']; ?>" name="sms_appid"
											   class="form-control" placeholder="请输入sms_appid">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">sms_appsecret：</label>
									<div class="col-sm-9">
										<input type="text" id="sms_appsecret" value="<?php echo $info['sms_appsecret']; ?>"
											   name="sms_appsecret" class="form-control"
											   placeholder="请输入sms_appsecret">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">短信签名：</label>
									<div class="col-sm-9">
										<input type="text" id="sms_lable" value="<?php echo $info['sms_lable']; ?>"
											   name="sms_lable" class="form-control"
											   placeholder="请输入短信签名">
									</div>
								</div>



								<!-- 显示短信通知示例 -->
								<div class="form-group">
									<label class="col-sm-2 control-label">短信通知示例：</label>
									<div class="col-sm-9">
										<div id="smsExample">【<?php echo $info['sms_lable']; ?>】有异常用户扫码开门，如需关注，请及时查看情况。</div>
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
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="control-label">演示钥匙配置</label>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">是否开启：</label>
									<div class="col-sm-9">
										<input name="autodtkey" value="1" type="radio" <?php if($info['autodtkey'] == 1): ?>checked<?php endif; ?> title="是">是
										<input name="autodtkey" value="0" type="radio" <?php if($info['autodtkey'] == 0): ?>checked<?php endif; ?> title="否">否
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">演示门锁ID：</label>
									<div class="col-sm-9">
										<input type="text" id="autodtkeylockid" value="<?php echo $info['autodtkeylockid']; ?>"
											   name="autodtkeylockid" class="form-control"
											   placeholder="请输入演示钥匙id">
									</div>
								</div>
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="control-label">临时密码加密秘钥</label>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">加密密码：</label>
									<div class="col-sm-9">
										<input type="text" id="adminpw" value="<?php echo $info['adminpw']; ?>" name="adminpw"
											   class="form-control" placeholder="请输入加密密码">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">加密密钥：</label>
									<div class="col-sm-9">
										<input type="text" id="devicecid" value="<?php echo $info['devicecid']; ?>"
											   name="devicecid" class="form-control"
											   placeholder="请输入加密秘钥">
									</div>
								</div>
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="control-label">抖音小程序配置</label>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">appid：</label>
									<div class="col-sm-9">
										<input type="text" id="dyappid" value="<?php echo $info['dyappid']; ?>" name="dyappid"
											   class="form-control" placeholder="请输入抖音小程序appid">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">appsecret：</label>
									<div class="col-sm-9">
										<input type="text" id="dyappsecret" value="<?php echo $info['dyappsecret']; ?>"
											   name="dyappsecret" class="form-control"
											   placeholder="请输入抖音小程序appsecret">
									</div>
								</div>
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="control-label">公众号发送消息配置(要注册开放平台绑定公众号和小程序，然后公众号关联小程序)</label>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">公众号appid：</label>
									<div class="col-sm-9">
										<input type="text" id="gzhappid" value="<?php echo $info['gzhappid']; ?>" name="gzhappid"
											   class="form-control" placeholder="请输入公众号appid">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">公众号appsecret：</label>
									<div class="col-sm-9">
										<input type="text" id="gzhappsecret" value="<?php echo $info['gzhappsecret']; ?>"
											   name="gzhappsecret" class="form-control"
											   placeholder="请输入公众号appsecret">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">本小程序appid：</label>
									<div class="col-sm-9">
										<input type="text" id="gzhminiappid" value="<?php echo $info['gzhminiappid']; ?>"
											   name="gzhminiappid" class="form-control"
											   placeholder="请输入公众号拉起的小程序appid">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">开门通知模板ID：</label>
									<div class="col-sm-9">
										<input type="text" id="gzhtempleteid1" value="<?php echo $info['gzhtempleteid1']; ?>"
											   name="gzhtempleteid1" class="form-control"
											   placeholder="请输入开门通知的模板消息ID">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">申请审核模板ID：</label>
									<div class="col-sm-9">
										<input type="text" id="gzhtempleteid2" value="<?php echo $info['gzhtempleteid2']; ?>"
											   name="gzhtempleteid2" class="form-control"
											   placeholder="请输入用户申请钥匙时通知管理员的模板消息ID">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">审核通过模板ID：</label>
									<div class="col-sm-9">
										<input type="text" id="gzhtempleteid3" value="<?php echo $info['gzhtempleteid3']; ?>"
											   name="gzhtempleteid3" class="form-control"
											   placeholder="请输入审核通过后通知用户的模板消息ID">
									</div>
								</div>
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="control-label">微信支付配置(比较敏感，没有退款和发红包等证书可不配置)</label>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">绑定的小程序appid：</label>
									<div class="col-sm-9">
										<input type="text" id="wxpayminiappid" value="<?php echo $info['wxpayminiappid']; ?>" name="wxpayminiappid"
											   class="form-control" placeholder="请输入绑定的小程序的appid">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">商户mchid：</label>
									<div class="col-sm-9">
										<input type="text" id="wxpaymchid" value="<?php echo $info['wxpaymchid']; ?>"
											   name="wxpaymchid" class="form-control"
											   placeholder="请输入公众号商户mchid">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">商户秘钥：</label>
									<div class="col-sm-9">
										<input type="text" id="wxpaykey" value="<?php echo $info['wxpaykey']; ?>"
											   name="wxpaykey" class="form-control"
											   placeholder="请输入商户秘钥">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">cert_path：</label>
									<div class="col-sm-9">
										<input type="text" id="wxpaycert_path" value="<?php echo $info['wxpaycert_path']; ?>"
											   name="wxpaycert_path" class="form-control"
											   placeholder="请输入cert_path绝对路径">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">key_path：</label>
									<div class="col-sm-9">
										<input type="text" id="wxpaykey_path" value="<?php echo $info['wxpaykey_path']; ?>"
											   name="wxpaykey_path" class="form-control"
											   placeholder="请输入key_path绝对路径">
									</div>
								</div>
								<!-- form end -->
							</div>
						</div>
						<div class="layui-tab-item">
							<div class="col-sm-7">
								<!-- form start -->
								<div class="form-group">
									<label class="col-sm-2 control-label">隐私政策：</label>
									<div class="col-sm-9">
										<script id="privacypolicy" type="text/plain" name="privacypolicy"
												style="width:100%;height:300px;"><?php echo $info['privacypolicy']; ?>
										</script>
										<script type="text/javascript">
											var ue = UE.getEditor('privacypolicy', {serverUrl: '<?php echo url("admin/Upload/uploadUeditor"); ?>'});
											scaleEnabled:true
										</script>
									</div>
								</div>
								<!-- form end -->
							</div>
						</div>
						<div class="layui-tab-item">
							<div class="col-sm-7">
								<!-- form start -->
								<div class="form-group">
									<label class="col-sm-2 control-label">服务协议：</label>
									<div class="col-sm-9">
										<script id="serviceagreement" type="text/plain" name="serviceagreement"
												style="width:100%;height:300px;"><?php echo $info['serviceagreement']; ?>
										</script>
										<script type="text/javascript">
											var ue = UE.getEditor('serviceagreement', {serverUrl: '<?php echo url("admin/Upload/uploadUeditor"); ?>'});
											scaleEnabled:true
										</script>
									</div>
								</div>
								<!-- form end -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<div class="row btn-group-m-t">
				<div class="col-sm-7">
					<button type="button" class="btn btn-primary" onclick="CodeInfoDlg.index()" id="ensure">
						<i class="fa fa-check"></i>&nbsp;确认提交
					</button>
					<button type="button" class="btn btn-danger" onclick="CodeInfoDlg.close()" id="cancel">
						<i class="fa fa-eraser"></i>&nbsp;取消
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="__PUBLIC__/static/js/admin/Config.js?t=<?php echo rand(1000,9999)?>" charset="utf-8"></script>
<script src="__PUBLIC__/static/js/upload.js" charset="utf-8"></script>
<script src="__PUBLIC__/static/js/plugins/layui/layui.js?t=1498856285724" charset="utf-8"></script>
<link rel='stylesheet' href='__PUBLIC__/static/js/plugins/tagsinput/tagsinput.css'>
<script type='text/javascript' src='__PUBLIC__/static/js/plugins/tagsinput/tagsinput.min.js'></script>
<script>
	layui.config({dir: '__PUBLIC__/static/js/plugins/layui/'});
	layui.use(['layer', 'form'], function () {
		window.layer = layui.layer;
		window.form = layui.form();
	});
	layui.use('element', function () {
		var element = layui.element();
		element.on('tab(test)', function (elem) {
		});
	});
	uploader('site_logo_upload', 'site_logo', 'image', false, '', '<?php echo url("admin/Upload/uploadImages"); ?>');
	document.addEventListener("DOMContentLoaded", function() {
		var currentUrl = window.location.origin;
		var callbackPath = "/api/device.Callback/lock";
		var fullCallbackUrl = currentUrl + callbackPath;
		// 设置回调地址到输入框中
		document.getElementById("callbackUrl").value = fullCallbackUrl;
	});
	document.getElementById("sms_lable").addEventListener('input', function () {
		updateSmsExample();
	});

	document.getElementById("sms_content").addEventListener('input', function () {
		updateSmsExample();
	});

	function updateSmsExample() {
		const smsLabel = document.getElementById("sms_lable").value || "微门禁提示";
		const smsContent = document.getElementById("sms_content").value || "有异常用户扫码开门，如需关注，请及时查看情况。";
		document.getElementById("smsExample").textContent = `【${smsLabel}】${smsContent}`;
	}

	document.getElementById("sendTestSms").addEventListener("click", function () {
		const phoneNumber = document.getElementById("testPhoneNumber").value;
		const smsLabel = document.getElementById("sms_lable").value;
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
