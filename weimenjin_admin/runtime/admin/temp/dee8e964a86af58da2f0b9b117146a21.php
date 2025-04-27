<?php /*a:2:{s:59:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/user/index.html";i:1731647734;s:66:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/common/_container.html";i:1731647734;}*/ ?>
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
				<h5>用户管理</h5>
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
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">用户名</button>
									</div>
									<input type="text" class="form-control" id="user" placeholder="用户名" />
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">所属分组</button>
									</div>
									<select class="form-control chosen" id="group_id">
										<option value="">请选择</option>
										<?php if(is_array($groupList) || $groupList instanceof \think\Collection || $groupList instanceof \think\Paginator): $i = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?>
										<option value="<?php echo $group['group_id']; ?>"><?php echo $group['name']; ?></option>
										<?php endforeach; endif; else: echo "" ;endif; ?>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">类别</button>
									</div>
									<select class="form-control" id="type">
										<option value="">请选择</option>
										<option value="1">超级管理员</option>
										<option value="2">普通管理员</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">状态</button>
									</div>
									<select class="form-control" id="status">
										<option value="">请选择</option>
										<option value="1">正常</option>
										<option value="0">禁用</option>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="input-group">
									<div class="input-group-btn">
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">会员ID</button>
									</div>
									<input type="text" class="form-control" id="member_id" placeholder="会员ID" />
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
						<?php if(in_array('/admin/User/add',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="add" class="btn btn-primary button-margin" onclick="CodeGoods.add()">
						<i class="fa fa-plus"></i>&nbsp;添加
						</button>
						<?php endif; if(in_array('/admin/User/update',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="update" class="btn btn-success button-margin" onclick="CodeGoods.update()">
						<i class="fa fa-edit"></i>&nbsp;修改
						</button>
						<?php endif; if(in_array('/admin/User/updatePassword',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="updatePassword" class="btn btn-warning button-margin" onclick="CodeGoods.updatePassword()">
						<i class="fa fa-pencil"></i>&nbsp;修改密码
						</button>
						<?php endif; if(in_array('/admin/User/delete',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="delete" class="btn btn-danger button-margin" onclick="CodeGoods.delete()">
						<i class="fa fa-trash"></i>&nbsp;删除
						</button>
						<?php endif; if(in_array('/admin/User/start',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="start" class="btn btn-success button-margin" onclick="CodeGoods.start()">
						<i class="fa fa-pencil"></i>&nbsp;启用
						</button>
						<?php endif; if(in_array('/admin/User/forbidden',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="forbidden" class="btn btn-success button-margin" onclick="CodeGoods.forbidden()">
						<i class="fa fa-pencil"></i>&nbsp;禁用
						</button>
						<?php endif; if(in_array('/admin/User/view',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="view" class="btn btn-info button-margin" onclick="CodeGoods.view()">
						<i class="fa fa-plus"></i>&nbsp;查看数据
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
<link href='__PUBLIC__/static/js/plugins/chosen/chosen.min.css' rel='stylesheet'/>
<script src='__PUBLIC__/static/js/plugins/chosen/chosen.jquery.js'></script>
<script>$(function(){$('.chosen').chosen({})})</script>
<script>
	var CodeGoods = {id: "CodeGoodsTable",seItem: null,table: null,layerIndex: -1};

	CodeGoods.initColumn = function () {
 		return [
 			{field: 'selectItem', checkbox: true},
 			{title: '编号', field: 'user_id', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '真实姓名', field: 'name', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '用户名', field: 'user', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '所属分组', field: 'group_name', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '类别', field: 'type', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.typeFormatter},
 			{title: '备注', field: 'note', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '状态', field: 'status', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.statusFormatter},
 			{title: '会员ID', field: 'member_id', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '创建时间', field: 'create_time', visible: true, align: 'center', valign: 'middle',sortable: true,formatter:CodeGoods.create_timeFormatter},
 			{title: '操作', field: '', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.buttonFormatter'},
 		];
 	};

	CodeGoods.buttonFormatter = function(value,row,index) {
		if(row.user_id){
			var str= '';
			<?php if(in_array('/admin/User/update',session('admin.nodes')) || session('admin.role') == 1): ?>
			str += '<button type="button" class="btn btn-success btn-xs" title="修改"  onclick="CodeGoods.update('+row.user_id+')"><i class="fa fa-edit"></i>&nbsp;修改</button>&nbsp;';
			<?php endif; if(in_array('/admin/User/delete',session('admin.nodes')) || session('admin.role') == 1): ?>
			str += '<button type="button" class="btn btn-danger btn-xs" title="删除"  onclick="CodeGoods.delete('+row.user_id+')"><i class="fa fa-trash"></i>&nbsp;删除</button>&nbsp;';
			<?php endif; ?>
			return str;
		}
	}

	CodeGoods.typeFormatter = function(value,row,index) {
		if(value !== null){
			var value = value.toString();
			switch(value){
				case '1':
					return '<span class="label label-success">超级管理员</span>';
				break;
				case '2':
					return '<span class="label label-warning">普通管理员</span>';
				break;
			}
		}
	}

	CodeGoods.statusFormatter = function(value,row,index) {
		if(value !== null){
			var value = value.toString();
			switch(value){
				case '1':
					return '<span class="label label-primary">正常</span>';
				break;
				case '0':
					return '<span class="label label-danger">禁用</span>';
				break;
			}
		}
	}

	CodeGoods.create_timeFormatter = function(value,row,index) {
		if(value){
			return formatDateTime(value,'Y-m-d H:i:s');	
		}
	}

	CodeGoods.formParams = function() {
		var queryData = {};
		queryData['user'] = $("#user").val();
		queryData['group_id'] = $("#group_id").val();
		queryData['type'] = $("#type").val();
		queryData['status'] = $("#status").val();
		queryData['member_id'] = $("#member_id").val();
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
		var index = layer.open({type: 2,title: '添加账户',area: ['800px', '600px'],fix: false, maxmin: true,content: Feng.ctxPath + '/User/add'+url});
		this.layerIndex = index;
		if(!IsPC()){layer.full(index)}
	}


	CodeGoods.update = function (value) {
		if(value){
			var index = layer.open({type: 2,title: '修改账户',area: ['800px', '600px'],fix: false, maxmin: true,content: Feng.ctxPath + '/User/update?user_id='+value});
			if(!IsPC()){layer.full(index)}
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.user_id;
				});
				idx = idx.substr(1);
				if(idx.indexOf(",") !== -1){
					Feng.info("请选择单条数据！");
					return false;
				}
				var index = layer.open({type: 2,title: '修改账户',area: ['800px', '600px'],fix: false, maxmin: true,content: Feng.ctxPath + '/User/update?user_id='+idx});
				this.layerIndex = index;
				if(!IsPC()){layer.full(index)}
			}
		}
	}


	CodeGoods.updatePassword = function (value) {
		if(value){
			var index = layer.open({type: 2,title: '修改密码',area: ['600px', '300px'],fix: false, maxmin: true,content: Feng.ctxPath + '/User/updatePassword?user_id='+value});
			this.layerIndex = index;
			if(!IsPC()){layer.full(index)}
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.user_id;
				});
				idx = idx.substr(1);
				if(idx.indexOf(",") !== -1){
					Feng.info("请选择单条数据！");
					return false;
				}
				var index = layer.open({type: 2,title: '修改密码',area: ['600px', '300px'],fix: false, maxmin: true,content: Feng.ctxPath + '/User/updatePassword?user_id='+idx});
				this.layerIndex = index;
				if(!IsPC()){layer.full(index)}
			}
		}
	}


	CodeGoods.delete = function (value) {
		if(value){
			Feng.confirm("是否删除选中项？", function () {
				var ajax = new $ax(Feng.ctxPath + "/User/delete", function (data) {
					if ('00' === data.status) {
						Feng.success(data.msg);
						CodeGoods.table.refresh();
					} else {
						Feng.error(data.msg);
					}
				});
				ajax.set('user_ids', value);
				ajax.start();
			});
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.user_id;
				});
				idx = idx.substr(1);
				Feng.confirm("是否删除选中项？", function () {
					var ajax = new $ax(Feng.ctxPath + "/User/delete", function (data) {
						if ('00' === data.status) {
							Feng.success(data.msg);
							CodeGoods.table.refresh();
						} else {
							Feng.error(data.msg);
						}
					});
					ajax.set('user_ids', idx);
					ajax.start();
				});
			}
		}
	}


	CodeGoods.start = function (value) {
		if(value){
			Feng.confirm("是否启用选中项？", function () {
				var ajax = new $ax(Feng.ctxPath + "/User/start", function (data) {
					if ('00' === data.status) {
						Feng.success(data.msg);
						CodeGoods.table.refresh();
					} else {
						Feng.error(data.msg);
					}
				});
				ajax.set('user_ids', value);
				ajax.start();
			});
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.user_id;
				});
				idx = idx.substr(1);
				Feng.confirm("是否启用选中项？", function () {
					var ajax = new $ax(Feng.ctxPath + "/User/start", function (data) {
						if ('00' === data.status) {
							Feng.success(data.msg);
							CodeGoods.table.refresh();
						} else {
							Feng.error(data.msg);
						}
					});
					ajax.set('user_ids', idx);
					ajax.set('statusData', value);
					ajax.start();
				});
			}
		}
	}


	CodeGoods.forbidden = function (value) {
		if(value){
			Feng.confirm("是否禁用选中项？", function () {
				var ajax = new $ax(Feng.ctxPath + "/User/forbidden", function (data) {
					if ('00' === data.status) {
						Feng.success(data.msg);
						CodeGoods.table.refresh();
					} else {
						Feng.error(data.msg);
					}
				});
				ajax.set('user_ids', value);
				ajax.start();
			});
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.user_id;
				});
				idx = idx.substr(1);
				Feng.confirm("是否禁用选中项？", function () {
					var ajax = new $ax(Feng.ctxPath + "/User/forbidden", function (data) {
						if ('00' === data.status) {
							Feng.success(data.msg);
							CodeGoods.table.refresh();
						} else {
							Feng.error(data.msg);
						}
					});
					ajax.set('user_ids', idx);
					ajax.set('statusData', value);
					ajax.start();
				});
			}
		}
	}


	CodeGoods.view = function (value) {
		if(value){
			var index = layer.open({type: 2,title: '查看数据',area: ['800px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + '/User/view?user_id='+value});
			if(!IsPC()){layer.full(index)}
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.user_id;
				});
				idx = idx.substr(1);
				var index = layer.open({type: 2,title: '查看数据',area: ['800px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + '/User/view?user_id='+idx});
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
		var table = new BSTable(CodeGoods.id, Feng.ctxPath+"/User/index"+url,defaultColunms,20);
		table.setPaginationType("server");
		table.setQueryParams(CodeGoods.formParams());
		CodeGoods.table = table.init();
	});
</script>

</div>
<script src="__PUBLIC__/static/js/content.js?v=1.0.0"></script>

</body>
</html>
