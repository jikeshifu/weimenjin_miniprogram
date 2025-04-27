<?php /*a:2:{s:63:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/lock_log/index.html";i:1731647734;s:66:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/common/_container.html";i:1731647734;}*/ ?>
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
				<h5>日志管理</h5>
				<button style="float:right; margin-top:-10px;" title="刷新页面" type="button" class="btn btn-default btn-outline" onclick="window.location.reload()" id="">
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
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">手机号</button>
									</div>
									<input type="text" class="form-control" id="mobile" placeholder="手机号" />
								</div>
							</div>
							<div class="col-sm-3">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">开门时间开始</button>
									</div>
									<input type="text" autocomplete="off" placeholder="开始时间" class="form-control" id="create_time_start">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">开门时间结束</button>
									</div>
									<input type="text" autocomplete="off" placeholder="结束时间" class="form-control" id="create_time_end">
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
						<?php if(in_array('/admin/LockLog/view',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="view" class="btn btn-info button-margin" onclick="CodeGoods.view()">
						<i class="fa fa-plus"></i>&nbsp;查看数据
						</button>
						<?php endif; if(in_array('/admin/LockLog/dumpData',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="dumpData" class="btn btn-warning button-margin" onclick="CodeGoods.dumpData()">
						<i class="fa fa-download"></i>&nbsp;导出
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
	function openImg(url) {
		// 打开大图弹框
		var img = new Image();
		img.src = url;
		var width = img.width > 800 ? 800 : img.width;
		var height = img.height > 600 ? 600 : img.height;

		// 弹出图片框
		layer.open({
			type: 1,
			title: false,
			closeBtn: 0,
			area: [width + 'px', height + 'px'],
			skin: 'layui-layer-nobg',
			shadeClose: true,
			content: '<img src="' + url + '" style="width:100%; height:auto;" />'
		});
	};
	CodeGoods.initColumn = function () {
 		return [
 			{field: 'selectItem', checkbox: true},
 			{title: '编号', field: 'locklog_id', visible: true, align: 'center', valign: 'middle',sortable: true},
			{title: '锁名称', field: 'lock_name', visible: true, align: 'center', valign: 'middle', sortable: true, formatter: CodeGoods.lockNameFormatter},
			{title: '头像', field: 'headimgurl', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.headimgurlFormatter},
 			{title: '呢称', field: 'nickname', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '姓名', field: 'realname', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '备注', field: 'remark', visible: true, align: 'center', valign: 'middle',sortable: true},
			{title: '终端类型', field: 'member_type', visible: true, align: 'center', valign: 'middle', sortable: true, formatter: CodeGoods.memberTypeFormatter},
			{title: '手机号', field: 'mobile', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '状态', field: 'status', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.statusFormatter},
 			{title: '类型', field: 'type', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.typeFormatter},
 			{title: '备注', field: 'remark', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '开门时间', field: 'create_time', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.create_timeFormatter},
 			{title: '操作', field: '', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.buttonFormatter'},
 		];
 	};

	CodeGoods.buttonFormatter = function(value,row,index) {
		if(row.locklog_id){
			var str= '';
			<?php if(in_array('/admin/LockLog/delete',session('admin.nodes')) || session('admin.role') == 1): ?>
			str += '<button type="button" class="btn btn-danger btn-xs" title="删除"  onclick="CodeGoods.delete('+row.locklog_id+')"><i class="fa fa-trash"></i>&nbsp;删除</button>&nbsp;';
			<?php endif; ?>
			return str;
		}
	};
	CodeGoods.lockNameFormatter = function(value, row, index) {
		if (!value) {
			return '';
		}
		// 限制锁名称显示8个字符，多余的用省略号
		var displayName = value.length > 8 ? value.substr(0, 8) + '...' : value;
		// 鼠标悬停时显示完整的锁名称
		return '<span title="' + value + '">' + displayName + '</span>';
	};

		CodeGoods.headimgurlFormatter = function(value, row, index) {
		if (row.type == '11' && row.cpurl) { // 如果类型是刷脸开门，并且有cpurl字段
			return "<a href=\"javascript:void(0)\" onclick=\"openImg('"+row.cpurl+"')\"><img height='30' src="+row.cpurl+"></a>";
		} else if (value) {
			return "<a href=\"javascript:void(0)\" onclick=\"openImg('"+value+"')\"><img height='30' src="+value+"></a>";
		}
	};

	CodeGoods.statusFormatter = function(value,row,index) {
		if(value !== null){
			var value = value.toString();
			switch(value){
				case '1':
					return '<span class="label label-primary">成功</span>';
				break;
				case '0':
					return '<span class="label label-danger">失败</span>';
				break;
			}
		}
	};
	CodeGoods.memberTypeFormatter = function(value, row, index) {
		if (value !== null) {
			switch (value.toString()) {
				case '1':
					return '<span class="label label-primary">微信</span>';
				case '2':
					return '<span class="label label-info">支付宝</span>';
				case '3':
					return '<span class="label label-success">抖音</span>';
				default:
					return '<span class="label label-default">未知</span>';
			}
		}
	};
		CodeGoods.typeFormatter = function(value,row,index) {
		if(value !== null){
			var value = value.toString();
			switch(value){
				case '1':
					return '<span class="label label-primary">扫码开门</span>';
				break;
				case '2':
					return '<span class="label label-info">点击开门</span>';
				break;
				case '3':
					return '<span class="label label-success">后台开门</span>';
				break;
				case '4':
					return '<span class="label label-success">刷卡开门</span>';
				break;
				case '5':
					return '<span class="label label-success">点击开电</span>';
				break;
				case '6':
					return '<span class="label label-success">点击关电</span>';
					break;
				case '7':
					return '<span class="label label-success">指纹开门</span>';
					break;
				case '8':
					return '<span class="label label-success">蓝牙开门</span>';
					break;
				case '9':
					return '<span class="label label-success">播放喇叭</span>';
					break;
				case '10':
					return '<span class="label label-success">生成钥匙</span>';
					break;
				case '11':
					return '<span class="label label-success">刷脸开门</span>';
					break;
				case '12':
					return '<span class="label label-success">密码开门</span>';
					break;
				case '13':
					return '<span class="label label-success">点击开</span>';
					break;
				case '14':
					return '<span class="label label-success">点击关</span>';
					break;
				case '15':
					return '<span class="label label-success">点击停</span>';
					break;
			}
		}
	};

	CodeGoods.create_timeFormatter = function(value,row,index) {
		if(value){
			return formatDateTime(value,'Y-m-d H:i:s');
		}
	};

	CodeGoods.formParams = function() {
		var queryData = {};
		queryData['user_id'] = $("#user_id").val();
		queryData['lock_name'] = $("#lock_name").val();
		queryData['mobile'] = $("#mobile").val();
		queryData['create_time_start'] = $("#create_time_start").val();
		queryData['create_time_end'] = $("#create_time_end").val();
		return queryData;
	};

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

	CodeGoods.delete = function (value) {
		if(value){
			Feng.confirm("是否删除选中项？", function () {
				var ajax = new $ax(Feng.ctxPath + "/LockLog/delete", function (data) {
					if ('00' === data.status) {
						Feng.success(data.msg);
						CodeGoods.table.refresh();
					} else {
						Feng.error(data.msg);
					}
				});
				ajax.set('locklog_ids', value);
				ajax.start();
			});
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.locklog_id;
				});
				idx = idx.substr(1);
				Feng.confirm("是否删除选中项？", function () {
					var ajax = new $ax(Feng.ctxPath + "/LockLog/delete", function (data) {
						if ('00' === data.status) {
							Feng.success(data.msg);
							CodeGoods.table.refresh();
						} else {
							Feng.error(data.msg);
						}
					});
					ajax.set('locklog_ids', idx);
					ajax.start();
				});
			}
		}
	};


	CodeGoods.view = function (value) {
		if(value){
			var index = layer.open({type: 2,title: '查看数据',area: ['800px', '450px'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockLog/view?locklog_id='+value});
			if(!IsPC()){layer.full(index)}
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.locklog_id;
				});
				idx = idx.substr(1);
				var index = layer.open({type: 2,title: '查看数据',area: ['800px', '450px'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockLog/view?locklog_id='+idx});
				this.layerIndex = index;
				if(!IsPC()){layer.full(index)}
			}
		}
	};


	CodeGoods.dumpData = function (value) {
		var select_id = '';
		if (this.check()){
			$.each(CodeGoods.seItem, function() {
				select_id += ',' + this.locklog_id;
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
			window.location.href = Feng.ctxPath + '/LockLog/dumpData?action_id=812&' + Feng.parseParam(queryData) + '&' +Feng.parseParam(idx) + '&locklog_id=' + select_id;
			setTimeout(function() {
				layer.close(index)
			}, 1000);
		});
	};


	CodeGoods.add = function (value) {
		var url = location.search;
		var index = layer.open({type: 2,title: '添加',area: ['800px', '550px'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockLog/add'+url});
		this.layerIndex = index;
		if(!IsPC()){layer.full(index)}
	};


	CodeGoods.search = function() {
		CodeGoods.table.refresh({query : CodeGoods.formParams()});
	};

	$(function() {
		var defaultColunms = CodeGoods.initColumn();
		var url = location.search;
		var table = new BSTable(CodeGoods.id, Feng.ctxPath+"/LockLog/index"+url,defaultColunms,20);
		table.setPaginationType("server");
		table.setQueryParams(CodeGoods.formParams());
		CodeGoods.table = table.init();
	});

	laydate.render({elem: '#create_time_start',type: 'datetime'});
	laydate.render({elem: '#create_time_end',type: 'datetime'});
</script>

</div>
<script src="__PUBLIC__/static/js/content.js?v=1.0.0"></script>

</body>
</html>
