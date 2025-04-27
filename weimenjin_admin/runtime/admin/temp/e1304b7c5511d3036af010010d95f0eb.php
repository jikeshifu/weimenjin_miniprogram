<?php /*a:2:{s:57:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/lock/add.html";i:1731647734;s:66:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/common/_container.html";i:1731647734;}*/ ?>
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
<input type="hidden" name='lock_id' id='lock_id' value="<?php echo $info['lock_id']; ?>" />
	<div class="ibox-content">
		<div class="form-horizontal" id="CodeInfoForm">
			<div class="row">
				<div class="col-sm-12">
				<!-- form start -->
					<div class="form-group">
						<label class="col-sm-2 control-label">锁名称：</label>
						<div class="col-sm-9">
							<input type="text" id="lock_name" value="" name="lock_name" class="form-control" placeholder="请输入锁名称">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">序列号：</label>
						<div class="col-sm-9">
							<input type="text" id="lock_sn" value="" name="lock_sn" class="form-control" placeholder="请输入序列号">
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">需绑手机：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['mobile_check'])){ $info['mobile_check'] = 1; }; ?>
							<input name="mobile_check" value="1" type="radio" <?php if($info['mobile_check'] == '1'): ?>checked<?php endif; ?> title="是">
							<input name="mobile_check" value="0" type="radio" <?php if($info['mobile_check'] == '0'): ?>checked<?php endif; ?> title="否">
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">申请钥匙：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['applyauth'])){ $info['applyauth'] = 0; }; ?>
							<input name="applyauth" value="1" type="radio" <?php if($info['applyauth'] == '1'): ?>checked<?php endif; ?> title="开启">
							<input name="applyauth" value="0" type="radio" <?php if($info['applyauth'] == '0'): ?>checked<?php endif; ?> title="关闭">
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">审核钥匙：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['applyauth_check'])){ $info['applyauth_check'] = 0; }; ?>
							<input name="applyauth_check" value="1" type="radio" <?php if($info['applyauth_check'] == '1'): ?>checked<?php endif; ?> title="开启">
							<input name="applyauth_check" value="0" type="radio" <?php if($info['applyauth_check'] == '0'): ?>checked<?php endif; ?> title="关闭">
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">开门距离(米)：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['location_check'])){ $info['location_check'] = 0; }; ?>
							<input name="location_check" value="0" type="radio" <?php if($info['location_check'] == '0'): ?>checked<?php endif; ?> title="不限制">
							<input name="location_check" value="20" type="radio" <?php if($info['location_check'] == '20'): ?>checked<?php endif; ?> title="20米内">
							<input name="location_check" value="50" type="radio" <?php if($info['location_check'] == '50'): ?>checked<?php endif; ?> title="50米内">
							<input name="location_check" value="100" type="radio" <?php if($info['location_check'] == '100'): ?>checked<?php endif; ?> title="100米内">
							<input name="location_check" value="200" type="radio" <?php if($info['location_check'] == '200'): ?>checked<?php endif; ?> title="200米内">
							<input name="location_check" value="300" type="radio" <?php if($info['location_check'] == '300'): ?>checked<?php endif; ?> title="300米内">
							<input name="location_check" value="500" type="radio" <?php if($info['location_check'] == '500'): ?>checked<?php endif; ?> title="500米内">
							<input name="location_check" value="1000" type="radio" <?php if($info['location_check'] == '1000'): ?>checked<?php endif; ?> title="1000米内">
							<input name="location_check" value="10000" type="radio" <?php if($info['location_check'] == '10000'): ?>checked<?php endif; ?> title="10K米内">
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">启用/禁用：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['status'])){ $info['status'] = 1; }; ?>
							<input name="status" value="1" type="radio" <?php if($info['status'] == '1'): ?>checked<?php endif; ?> title="启用">
							<input name="status" value="0" type="radio" <?php if($info['status'] == '0'): ?>checked<?php endif; ?> title="禁用">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">类型：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['lock_type'])){ $info['lock_type'] = ''; }; ?>
							<select lay-ignore name="lock_type" class="form-control" id="lock_type">
								<option value="">请选择</option>
								<?php if(is_array($lockTypes) || $lockTypes instanceof \think\Collection || $lockTypes instanceof \think\Paginator): $i = 0; $__LIST__ = $lockTypes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$locktype): $mod = ($i % 2 );++$i;?>
								<option value="<?php echo $locktype['locktype_id']; ?>" <?php if($info['lock_type'] == $locktype['locktype_id']): ?>selected<?php endif; ?>><?php echo $locktype['locktype_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">位置：</label>
						<div class="col-sm-9">
							<div class="input-group" id="id_address_input">
							<textarea id="location" name="location"  class="form-control" placeholder="请输入位置"><?php echo $info['location']; ?></textarea>
								<span class="input-group-addon"><span class="glyphicon glyphicon-map-marker"></span></span>
							</div>
						</div>
					</div>
					<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.15&key=454cbf1ea9bcd28b0020211c0f5ce838"></script>
					<script src="__PUBLIC__/static/js/plugins/map/bootstrap.AMapPositionPicker.js"></script>
					<script type="text/javascript">
					$(function () {
						var p = $("#id_address_input").AMapPositionPicker();
					});
					</script>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">成功弹层方式：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['adnum'])){ $info['adnum'] = 2; }; ?>
							<input name="adnum" value="1" type="radio" <?php if($info['adnum'] == '1'): ?>checked<?php endif; ?> title="两图弹层">
							<input name="adnum" value="2" type="radio" <?php if($info['adnum'] == '2'): ?>checked<?php endif; ?> title="一张图带链接">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">成功提示图片：</label>
						<div class="col-sm-6">
							<input type="text" id="successimg" value="/static/img/shareimg.jpg" <?php if(config('my.img_show_status') == true): ?>onmousemove="showBigPic(this.value)" onmouseout="closeimg()"<?php endif; ?> name="successimg" class="form-control" placeholder="请输入成功提示图片">
							<span class="help-block m-b-none successimg_process"></span>
						</div>
						<div class="col-sm-2" style="position:relative; right:30px;">
							<span id="successimg_upload"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">成功广告：</label>
						<div class="col-sm-6">
							<input type="text" id="successadimg" value="" <?php if(config('my.img_show_status') == true): ?>onmousemove="showBigPic(this.value)" onmouseout="closeimg()"<?php endif; ?> name="successadimg" class="form-control" placeholder="请输入成功广告">
							<span class="help-block m-b-none successadimg_process"></span>
						</div>
						<div class="col-sm-2" style="position:relative; right:30px;">
							<span id="successadimg_upload"></span>
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">点击开门广告：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['hitshowminiad'])){ $info['hitshowminiad'] = 1; }; ?>
							<input name="hitshowminiad" value="0" type="radio" <?php if($info['hitshowminiad'] == '0'): ?>checked<?php endif; ?> title="开启">
							<input name="hitshowminiad" value="1" type="radio" <?php if($info['hitshowminiad'] == '1'): ?>checked<?php endif; ?> title="关闭">
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">开门按钮：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['openbtn'])){ $info['openbtn'] = 1; }; ?>
							<input name="openbtn" value="1" type="radio" <?php if($info['openbtn'] == '1'): ?>checked<?php endif; ?> title="开启">
							<input name="openbtn" value="0" type="radio" <?php if($info['openbtn'] == '0'): ?>checked<?php endif; ?> title="关闭">
							<span class="help-block m-b-none"> 小程序端开门按钮是否启用</span>
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">扫码开门广告：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['qrshowminiad'])){ $info['qrshowminiad'] = 1; }; ?>
							<input name="qrshowminiad" value="0" type="radio" <?php if($info['qrshowminiad'] == '0'): ?>checked<?php endif; ?> title="开启">
							<input name="qrshowminiad" value="1" type="radio" <?php if($info['qrshowminiad'] == '1'): ?>checked<?php endif; ?> title="关闭">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">开门成功外链：</label>
						<div class="col-sm-9">
							<input type="text" id="openadurl" value="https://mp.weixin.qq.com/s/UtKqS8FN73aai2PJTeHRig" name="openadurl" class="form-control" placeholder="请输入开门成功外链">
						</div>
					</div>
					<div class="form-group layui-form">
						<label class="col-sm-2 control-label">开门通知：</label>
						<div class="col-sm-9">
							<?php if(!isset($info['opsucnt'])){ $info['opsucnt'] = 0; }; ?>
							<input name="opsucnt" value="1" type="radio" <?php if($info['opsucnt'] == '1'): ?>checked<?php endif; ?> title="开启">
							<input name="opsucnt" value="0" type="radio" <?php if($info['opsucnt'] == '0'): ?>checked<?php endif; ?> title="关闭">
							<span class="help-block m-b-none">需要关注公众号,在公众号服务菜单点击订阅通知后才有效</span>
						</div>
					</div>
				<!-- form end -->
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<div class="row btn-group-m-t">
				<div class="col-sm-9 col-sm-offset-1">
					<button type="button" class="btn btn-primary" onclick="CodeInfoDlg.add()" id="ensure">
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
<script src="__PUBLIC__/static/js/admin/Lock.js?t=<?php echo rand(1000,9999)?>" charset="utf-8"></script>
<script src="__PUBLIC__/static/js/upload.js" charset="utf-8"></script>
<script src="__PUBLIC__/static/js/plugins/layui/layui.js?t=1498856285724" charset="utf-8"></script>
<script src='__PUBLIC__/static/js/plugins/paixu/jquery-migrate-1.1.1.js'></script>
<script src='__PUBLIC__/static/js/plugins/paixu/jquery.dragsort-0.5.1.min.js'></script>
<script>
layui.config({dir: '__PUBLIC__/static/js/plugins/layui/'});
	layui.use(['form'], function () {
	window.form = layui.form();
});
uploader('successimg_upload','successimg','image',false,'','<?php echo url("admin/Upload/uploadImages"); ?>');
uploader('successadimg_upload','successadimg','image',false,'','<?php echo url("admin/Upload/uploadImages"); ?>');
laydate.render({elem: '#create_time',type: 'datetime',trigger:'click'});
</script>



</div>
<script src="__PUBLIC__/static/js/content.js?v=1.0.0"></script>

</body>
</html>
