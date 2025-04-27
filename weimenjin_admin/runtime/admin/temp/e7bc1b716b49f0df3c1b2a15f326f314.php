<?php /*a:2:{s:59:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/lock/index.html";i:1731647734;s:66:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/common/_container.html";i:1731647734;}*/ ?>
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
	
<div class="row">
	<div class="col-sm-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>门锁管理</h5>
				<button style="float:right; margin-top:-10px;" title="刷新页面" type="button" class="btn btn-default btn-outline" onclick="window.location.reload()" >
					<i class="fa fa-refresh"></i>
				</button>
			</div>
			<div class="ibox-content">
				<div class="row row-lg">
					<div class="col-sm-12">
						<div class="row" id="searchGroup">
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">锁名称</button>
									</div>
									<input type="text" class="form-control" id="lock_name" placeholder="锁名称" />
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">序列号</button>
									</div>
									<input type="text" class="form-control" id="lock_sn" placeholder="序列号" />
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">开门距离(米)</button>
									</div>
									<select class="form-control" id="location_check">
										<option value="">请选择</option>
										<option value="0">不限制</option>
										<option value="20">20米内</option>
										<option value="50">50米内</option>
										<option value="100">100米内</option>
										<option value="200">200米内</option>
										<option value="300">300米内</option>
										<option value="500">500米内</option>
										<option value="1000">1000米内</option>
										<option value="10000">10K米内</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">启用/禁用</button>
									</div>
									<select class="form-control" id="status">
										<option value="">请选择</option>
										<option value="1">启用</option>
										<option value="0">禁用</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">在线状态</button>
									</div>
									<select class="form-control" id="online">
										<option value="">请选择</option>
										<option value="1">在线</option>
										<option value="0">离线</option>
									</select>
								</div>
							</div>
							<!-- search end -->
							<div class="col-sm-2">
								<button type="button" class="btn btn-primary " onclick="CodeGoods.search()" id="">
									<i class="fa fa-search"></i>&nbsp;搜索
								</button>
							</div>
						</div>
						<div class="btn-group-sm" id="CodeGoodsTableToolbar" role="group">
							<?php if(in_array('/admin/Lock/add',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="add" class="btn btn-primary button-margin" onclick="CodeGoods.add()">
								<i class="fa fa-plus"></i>&nbsp;添加
							</button>
							<?php endif; if(in_array('/admin/Lock/update',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="update" class="btn btn-success button-margin" onclick="CodeGoods.update()">
								<i class="fa fa-pencil"></i>&nbsp;修改
							</button>
							<?php endif; if(in_array('/admin/Lock/delete',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="delete" class="btn btn-danger button-margin" onclick="CodeGoods.delete()">
								<i class="fa fa-trash"></i>&nbsp;删除
							</button>
							<?php endif; if(in_array('/admin/Lock/view',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="view" class="btn btn-info button-margin" onclick="CodeGoods.view()">
								<i class="fa fa-plus"></i>&nbsp;查看数据
							</button>
							<?php endif; if(in_array('/admin/Lock/dumpData',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="dumpData" class="btn btn-warning button-margin" onclick="CodeGoods.dumpData()">
								<i class="fa fa-download"></i>&nbsp;导出
							</button>
							<?php endif; if(in_array('/admin/Lock/opendoor',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="opendoor" class="btn btn-primary button-margin" onclick="CodeGoods.opendoor()">
								<i class="fa fa-edit"></i>&nbsp;开门测试
							</button>
							<?php endif; if(in_array('/admin/Lock/deviceinfo',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="deviceinfo" class="btn btn-primary button-margin" onclick="CodeGoods.deviceinfo()">
								<i class="fa fa-edit"></i>&nbsp;设备信息
							</button>
							<?php endif; if(in_array('/admin/Lock/regdoor',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="regdoor" class="btn btn-primary button-margin" onclick="CodeGoods.regdoor()">
								<i class="fa fa-edit"></i>&nbsp;重新绑定
							</button>
							<?php endif; if(in_array('/admin/Locktimes/index',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="enopentimesset" class="btn btn-primary button-margin" onclick="CodeGoods.enopentimesset()">
								<i class="fa fa-plus"></i>&nbsp;可开门时段设置
							</button>
							<?php endif; if(in_array('/admin/LockCard/index',session('admin.nodes')) || session('admin.role') == 1): ?>
							<button type="button" id="lockcardmanage" class="btn btn-primary button-margin" onclick="CodeGoods.lockcardmanage()">
								<i class="fa fa-plus"></i>&nbsp;卡管理
							</button>
							<?php endif; ?>
						</div>
						<table id="CodeGoodsTable" data-mobile-responsive="true" data-click-to-select="true">
							<thead><tr><th data-field="selectItem" data-checkbox="true"></th></tr></thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var CodeGoods = {id: "CodeGoodsTable",seItem: null,table: null,layerIndex: -1};

	CodeGoods.initColumn = function () {
		return [
			{field: 'selectItem', checkbox: true},
			{title: '编号', field: 'lock_id', visible: true, align: 'center', valign: 'middle',sortable: true},
			{title: '管理员ID', field: 'user_id', visible: true, align: 'center', valign: 'middle',sortable: true},
			{title: '锁名称', field: 'lock_name', visible: true, align: 'center', valign: 'middle',sortable: true},
			{title: '序列号', field: 'lock_sn', visible: true, align: 'center', valign: 'middle',sortable: true},
			{title: '需绑手机', field: 'mobile_check', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.mobile_checkFormatter},
			{title: '申请钥匙', field: 'applyauth', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.applyauthFormatter},
			{title: '审核钥匙', field: 'applyauth_check', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.applyauth_checkFormatter},
			{title: '开门距离(米)', field: 'location_check', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.location_checkFormatter},
			{title: '启用/禁用', field: 'status', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.statusFormatter},
			{title: '在线状态', field: 'online', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.onlineFormatter},
			{title: '二维码', field: 'lock_qrcode', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.lock_qrcodeFormatter},
			{title: '成功提示图片', field: 'successimg', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.successimgFormatter},
			{title: '开门通知', field: 'opsucnt', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.opsucntFormatter},
			{title: '操作', field: '', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.buttonFormatter'},
		];
	};

	CodeGoods.buttonFormatter = function(value,row,index) {
		if(row.lock_id){
			var str= '';
			<?php if(in_array('/admin/Lock/update',session('admin.nodes')) || session('admin.role') == 1): ?>
			str += '<button type="button" class="btn btn-success btn-xs" title="修改"  onclick="CodeGoods.update('+row.lock_id+')"><i class="fa fa-pencil"></i>&nbsp;修改</button>&nbsp;';
			<?php endif; if(in_array('/admin/Lock/delete',session('admin.nodes')) || session('admin.role') == 1): ?>
				str += '<button type="button" class="btn btn-danger btn-xs" title="删除"  onclick="CodeGoods.delete('+row.lock_id+')"><i class="fa fa-trash"></i>&nbsp;删除</button>&nbsp;';
				<?php endif; ?>
					return str;
				}
			}

			CodeGoods.mobile_checkFormatter = function(value,row,index) {
				if(value !== null){
					if(value == 1){
						return '<input class="mui-switch mui-switch-animbg mobile_check'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updatemobile_check('+row.lock_id+',0,\'mobile_check\')" checked>';
					}else{
						return '<input class="mui-switch mui-switch-animbg mobile_check'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updatemobile_check('+row.lock_id+',1,\'mobile_check\')">';
					}
				}
			}


			CodeGoods.updatemobile_check = function(pk,value,field) {
				var ajax = new $ax(Feng.ctxPath + "/Lock/updateExt", function (data) {
					if ('00' !== data.status) {
						Feng.error(data.msg);
						$("."+field+pk).prop("checked",!$("."+field+pk).prop("checked"));
					}
				});
				var val = $("."+field+pk).prop("checked") ? 1 : 0;
				ajax.set('lock_id', pk);
				ajax.set('mobile_check', val);
				ajax.start();
			}

			CodeGoods.applyauthFormatter = function(value,row,index) {
				if(value !== null){
					if(value == 1){
						return '<input class="mui-switch mui-switch-animbg applyauth'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updateapplyauth('+row.lock_id+',0,\'applyauth\')" checked>';
					}else{
						return '<input class="mui-switch mui-switch-animbg applyauth'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updateapplyauth('+row.lock_id+',1,\'applyauth\')">';
					}
				}
			}


			CodeGoods.updateapplyauth = function(pk,value,field) {
				var ajax = new $ax(Feng.ctxPath + "/Lock/updateExt", function (data) {
					if ('00' !== data.status) {
						Feng.error(data.msg);
						$("."+field+pk).prop("checked",!$("."+field+pk).prop("checked"));
					}
				});
				var val = $("."+field+pk).prop("checked") ? 1 : 0;
				ajax.set('lock_id', pk);
				ajax.set('applyauth', val);
				ajax.start();
			}

			CodeGoods.applyauth_checkFormatter = function(value,row,index) {
				if(value !== null){
					if(value == 1){
						return '<input class="mui-switch mui-switch-animbg applyauth_check'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updateapplyauth_check('+row.lock_id+',0,\'applyauth_check\')" checked>';
					}else{
						return '<input class="mui-switch mui-switch-animbg applyauth_check'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updateapplyauth_check('+row.lock_id+',1,\'applyauth_check\')">';
					}
				}
			}


			CodeGoods.updateapplyauth_check = function(pk,value,field) {
				var ajax = new $ax(Feng.ctxPath + "/Lock/updateExt", function (data) {
					if ('00' !== data.status) {
						Feng.error(data.msg);
						$("."+field+pk).prop("checked",!$("."+field+pk).prop("checked"));
					}
				});
				var val = $("."+field+pk).prop("checked") ? 1 : 0;
				ajax.set('lock_id', pk);
				ajax.set('applyauth_check', val);
				ajax.start();
			}

			CodeGoods.location_checkFormatter = function(value,row,index) {
				if(value !== null){
					var value = value.toString();
					switch(value){
						case '0':
							return '不限制';
							break;
						case '20':
							return '20米内';
							break;
						case '50':
							return '50米内';
							break;
						case '100':
							return '100米内';
							break;
						case '200':
							return '200米内';
							break;
						case '300':
							return '300米内';
							break;
						case '500':
							return '500米内';
							break;
						case '1000':
							return '1000米内';
							break;
						case '10000':
							return '10K米内';
							break;
					}
				}
			}

			CodeGoods.statusFormatter = function(value,row,index) {
				if(value !== null){
					if(value == 1){
						return '<input class="mui-switch mui-switch-animbg status'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updatestatus('+row.lock_id+',0,\'status\')" checked>';
					}else{
						return '<input class="mui-switch mui-switch-animbg status'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updatestatus('+row.lock_id+',1,\'status\')">';
					}
				}
			}


			CodeGoods.updatestatus = function(pk,value,field) {
				var ajax = new $ax(Feng.ctxPath + "/Lock/updateExt", function (data) {
					if ('00' !== data.status) {
						Feng.error(data.msg);
						$("."+field+pk).prop("checked",!$("."+field+pk).prop("checked"));
					}
				});
				var val = $("."+field+pk).prop("checked") ? 1 : 0;
				ajax.set('lock_id', pk);
				ajax.set('status', val);
				ajax.start();
			}

			CodeGoods.onlineFormatter = function(value,row,index) {
				if(value !== null){
					var value = value.toString();
					switch(value){
						case '1':
							return '<span class="label label-primary">在线</span>';
							break;
						case '0':
							return '<span class="label label-warning">离线</span>';
							break;
					}
				}
			}

			CodeGoods.lock_qrcodeFormatter = function(value,row,index) {
				if(value){
					return "<a href=\"javascript:void(0)\" onclick=\"openImg('"+value+"')\"><img height='30' src="+value+"></a>";
				}
			}

			CodeGoods.successimgFormatter = function(value,row,index) {
				if(value){
					return "<a href=\"javascript:void(0)\" onclick=\"openImg('"+value+"')\"><img height='30' src="+value+"></a>";
				}
			}

			CodeGoods.openbtnFormatter = function(value,row,index) {
				if(value !== null){
					if(value == 1){
						return '<input class="mui-switch mui-switch-animbg openbtn'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updateopenbtn('+row.lock_id+',0,\'openbtn\')" checked>';
					}else{
						return '<input class="mui-switch mui-switch-animbg openbtn'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updateopenbtn('+row.lock_id+',1,\'openbtn\')">';
					}
				}
			}


			CodeGoods.updateopenbtn = function(pk,value,field) {
				var ajax = new $ax(Feng.ctxPath + "/Lock/updateExt", function (data) {
					if ('00' !== data.status) {
						Feng.error(data.msg);
						$("."+field+pk).prop("checked",!$("."+field+pk).prop("checked"));
					}
				});
				var val = $("."+field+pk).prop("checked") ? 1 : 0;
				ajax.set('lock_id', pk);
				ajax.set('openbtn', val);
				ajax.start();
			}

			CodeGoods.opsucntFormatter = function(value,row,index) {
				if(value !== null){
					if(value == 1){
						return '<input class="mui-switch mui-switch-animbg opsucnt'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updateopsucnt('+row.lock_id+',0,\'opsucnt\')" checked>';
					}else{
						return '<input class="mui-switch mui-switch-animbg opsucnt'+row.lock_id+'" type="checkbox" onclick="CodeGoods.updateopsucnt('+row.lock_id+',1,\'opsucnt\')">';
					}
				}
			}


			CodeGoods.updateopsucnt = function(pk,value,field) {
				var ajax = new $ax(Feng.ctxPath + "/Lock/updateExt", function (data) {
					if ('00' !== data.status) {
						Feng.error(data.msg);
						$("."+field+pk).prop("checked",!$("."+field+pk).prop("checked"));
					}
				});
				var val = $("."+field+pk).prop("checked") ? 1 : 0;
				ajax.set('lock_id', pk);
				ajax.set('opsucnt', val);
				ajax.start();
			}

			CodeGoods.formParams = function() {
				var queryData = {};
				queryData['user_id'] = $("#user_id").val();
				queryData['lock_name'] = $("#lock_name").val();
				queryData['lock_sn'] = $("#lock_sn").val();
				queryData['location_check'] = $("#location_check").val();
				queryData['status'] = $("#status").val();
				queryData['online'] = $("#online").val();
				return queryData;
			}

			CodeGoods.check = function () {
				var selected = $('#' + this.id).bootstrapTable('getSelections');
				if(selected.length == 0){
					Feng.info("请先选中表格中的某一记录！");
					return false;
				}else{
					CodeGoods.seItem = selected;
					return true;
				}
			};

			CodeGoods.add = function (value) {
				var url = location.search;
				var index = layer.open({type: 2,title: '添加',area: ['800px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/add'+url});
				this.layerIndex = index;
				if(!IsPC()){layer.full(index)}
			}


			CodeGoods.update = function (value) {
				if(value){
					var index = layer.open({type: 2,title: '修改',area: ['800px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/update?lock_id='+value});
					if(!IsPC()){layer.full(index)}
				}else{
					if (this.check()) {
						var idx = '';
						$.each(CodeGoods.seItem, function() {
							idx += ',' + this.lock_id;
						});
						idx = idx.substr(1);
						if(idx.indexOf(",") !== -1){
							Feng.info("请选择单条数据！");
							return false;
						}
						var index = layer.open({type: 2,title: '修改',area: ['800px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/update?lock_id='+idx});
						this.layerIndex = index;
						if(!IsPC()){layer.full(index)}
					}
				}
			}


			CodeGoods.delete = function (value) {
				if(value){
					Feng.confirm("是否删除选中项？", function () {
						var ajax = new $ax(Feng.ctxPath + "/Lock/delete", function (data) {
							if ('00' === data.status) {
								Feng.success(data.msg);
								CodeGoods.table.refresh();
							} else {
								Feng.error(data.msg);
							}
						});
						ajax.set('lock_ids', value);
						ajax.start();
					});
				}else{
					if (this.check()) {
						var idx = '';
						$.each(CodeGoods.seItem, function() {
							idx += ',' + this.lock_id;
						});
						idx = idx.substr(1);
						Feng.confirm("是否删除选中项？", function () {
							var ajax = new $ax(Feng.ctxPath + "/Lock/delete", function (data) {
								if ('00' === data.status) {
									Feng.success(data.msg);
									CodeGoods.table.refresh();
								} else {
									Feng.error(data.msg);
								}
							});
							ajax.set('lock_ids', idx);
							ajax.start();
						});
					}
				}
			}


			CodeGoods.view = function (value) {
				if(value){
					var index = layer.open({type: 2,title: '查看数据',area: ['800px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/view?lock_id='+value});
					if(!IsPC()){layer.full(index)}
				}else{
					if (this.check()) {
						var idx = '';
						$.each(CodeGoods.seItem, function() {
							idx += ',' + this.lock_id;
						});
						idx = idx.substr(1);
						var index = layer.open({type: 2,title: '查看数据',area: ['800px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/view?lock_id='+idx});
						this.layerIndex = index;
						if(!IsPC()){layer.full(index)}
					}
				}
			}


			CodeGoods.dumpData = function (value) {
				var select_id = '';
				if (this.check()){
					$.each(CodeGoods.seItem, function() {
						select_id += ',' + this.lock_id;
					});
				}
				select_id = select_id.substr(1);
				Feng.confirm("是否确定导出记录?", function() {
					var index = layer.msg('正在导出下载，请耐心等待...', {
						time : 3600000,
						icon : 16,
						shade : 0.01
					});
					var idx =[];
					$("li input:checked").each(function(){
						idx.push($(this).attr('data-field'));
					});
					var queryData = CodeGoods.formParams();
					window.location.href = Feng.ctxPath + '/Lock/dumpData?action_id=803&' + Feng.parseParam(queryData) + '&' +Feng.parseParam(idx) + '&lock_id=' + select_id;
					setTimeout(function() {
						layer.close(index)
					}, 1000);
				});
			}


			CodeGoods.opendoor = function (value) {
				if(value){
					var index = layer.open({type: 2,title: '编辑数据',area: ['', ''],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/opendoor?lock_id='+value});
					if(!IsPC()){layer.full(index)}
				}else{
					if (this.check()) {
						var idx = '';
						$.each(CodeGoods.seItem, function() {
							idx += ',' + this.lock_id;
						});
						idx = idx.substr(1);
						if(idx.indexOf(",") !== -1){
							Feng.info("请选择单条数据！");
							return false;
						}
						var index = layer.open({type: 2,title: '编辑数据',area: ['', ''],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/opendoor?lock_id='+idx});
						this.layerIndex = index;
						if(!IsPC()){layer.full(index)}
					}
				}
			}
			CodeGoods.deviceinfo = function (value) {
				if(value){
					var index = layer.open({type: 2,title: '设备信息',area: ['400px', '600px'],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/deviceinfo?lock_id='+value});
					if(!IsPC()){layer.full(index)}
				}else{
					if (this.check()) {
						var idx = '';
						$.each(CodeGoods.seItem, function() {
							idx += ',' + this.lock_id;
						});
						idx = idx.substr(1);
						if(idx.indexOf(",") !== -1){
							Feng.info("请选择单条数据！");
							return false;
						}
						var index = layer.open({type: 2,title: '设备信息',area: ['400px', '600px'],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/deviceinfo?lock_id='+idx});
						this.layerIndex = index;
						if(!IsPC()){layer.full(index)}
					}
				}
			}
			CodeGoods.regdoor = function (value) {
				if(value){
					var index = layer.open({type: 2,title: '更新到接口',area: ['', ''],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/regdoor?lock_id='+value});
					if(!IsPC()){layer.full(index)}
				}else{
					if (this.check()) {
						var idx = '';
						$.each(CodeGoods.seItem, function() {
							idx += ',' + this.lock_id;
						});
						idx = idx.substr(1);
						if(idx.indexOf(",") !== -1){
							Feng.info("请选择单条数据！");
							return false;
						}
						var index = layer.open({type: 2,title: '更新到接口',area: ['', ''],fix: false, maxmin: true,content: Feng.ctxPath + '/Lock/regdoor?lock_id='+idx});
						this.layerIndex = index;
						if(!IsPC()){layer.full(index)}
					}
				}
			}

			CodeGoods.enopentimesset = function (value) {
				if(value){
					var queryData = {};
					queryData['lock_id'] = value;
					var index = layer.open({type: 2,title: '可开门时段管理',area: ['90%', '90%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Locktimes/index?'+Feng.parseParam(queryData)});
					this.layerIndex = index;
					if(!IsPC()){layer.full(index)}
				}else{
					if (this.check()) {
						var idx = '';
						$.each(CodeGoods.seItem, function() {
							idx += ',' + this.lock_id;
						});
						idx = idx.substr(1);
						if(idx.indexOf(",") !== -1){
							Feng.info("请选择单条数据！");
							return false;
						}
						var queryData = {};
						queryData['lock_id'] = idx;
						var index = layer.open({type: 2,title: '可开门时段管理',area: ['90%', '90%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Locktimes/index?'+Feng.parseParam(queryData)});
						this.layerIndex = index;
						if(!IsPC()){layer.full(index)}
					}
				}
			}


			CodeGoods.lockcardmanage = function (value) {
				if(value){
					var queryData = {};
					queryData['lock_id'] = value;
					var index = layer.open({type: 2,title: '卡管理',area: ['90%', '90%'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockCard/index?'+Feng.parseParam(queryData)});
					this.layerIndex = index;
					if(!IsPC()){layer.full(index)}
				}else{
					if (this.check()) {
						var idx = '';
						$.each(CodeGoods.seItem, function() {
							idx += ',' + this.lock_id;
						});
						idx = idx.substr(1);
						if(idx.indexOf(",") !== -1){
							Feng.info("请选择单条数据！");
							return false;
						}
						var queryData = {};
						queryData['lock_id'] = idx;
						var index = layer.open({type: 2,title: '卡管理',area: ['90%', '90%'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockCard/index?'+Feng.parseParam(queryData)});
						this.layerIndex = index;
						if(!IsPC()){layer.full(index)}
					}
				}
			}


			CodeGoods.search = function() {
				CodeGoods.table.refresh({query : CodeGoods.formParams()});
			};

			$(function() {
				var defaultColunms = CodeGoods.initColumn();
				var url = location.search;
				var table = new BSTable(CodeGoods.id, Feng.ctxPath+"/Lock/index"+url,defaultColunms,20);
				table.setPaginationType("server");
				table.setQueryParams(CodeGoods.formParams());
				CodeGoods.table = table.init();
			});
</script>

</div>
<script src="__PUBLIC__/static/js/content.js?v=1.0.0"></script>

</body>
</html>
