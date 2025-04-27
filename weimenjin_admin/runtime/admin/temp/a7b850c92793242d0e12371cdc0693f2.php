<?php /*a:2:{s:64:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/lock_type/index.html";i:1731647734;s:66:"/www/wwwroot/demo.wmj.com.cn/app/admin/view/common/_container.html";i:1731647734;}*/ ?>
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
				<h5>门锁类型</h5>
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
										<button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">名称</button>
									</div>
									<input type="text" class="form-control" id="locktype_name" placeholder="名称" />
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
						<?php if(in_array('/admin/LockType/add',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="add" class="btn btn-primary button-margin" onclick="CodeGoods.add()">
						<i class="fa fa-plus"></i>&nbsp;添加
						</button>
						<?php endif; if(in_array('/admin/LockType/update',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="update" class="btn btn-success button-margin" onclick="CodeGoods.update()">
						<i class="fa fa-pencil"></i>&nbsp;修改
						</button>
						<?php endif; if(in_array('/admin/LockType/delete',session('admin.nodes')) || session('admin.role') == 1): ?>
						<button type="button" id="delete" class="btn btn-danger button-margin" onclick="CodeGoods.delete()">
						<i class="fa fa-trash"></i>&nbsp;删除
						</button>
						<?php endif; if(in_array('/admin/LockType/view',session('admin.nodes')) || session('admin.role') == 1): ?>
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
<script>
	var CodeGoods = {id: "CodeGoodsTable",seItem: null,table: null,layerIndex: -1};

	CodeGoods.initColumn = function () {
 		return [
 			{field: 'selectItem', checkbox: true},
 			{title: '编号', field: 'locktype_id', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '名称', field: 'locktype_name', visible: true, align: 'center', valign: 'middle',sortable: true},
 			{title: '操作', field: '', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.buttonFormatter'},
 		];
 	};

	CodeGoods.buttonFormatter = function(value,row,index) {
		if(row.locktype_id){
			var str= '';
			<?php if(in_array('/admin/LockType/update',session('admin.nodes')) || session('admin.role') == 1): ?>
			str += '<button type="button" class="btn btn-success btn-xs" title="修改"  onclick="CodeGoods.update('+row.locktype_id+')"><i class="fa fa-pencil"></i>&nbsp;修改</button>&nbsp;';
			<?php endif; if(in_array('/admin/LockType/delete',session('admin.nodes')) || session('admin.role') == 1): ?>
			str += '<button type="button" class="btn btn-danger btn-xs" title="删除"  onclick="CodeGoods.delete('+row.locktype_id+')"><i class="fa fa-trash"></i>&nbsp;删除</button>&nbsp;';
			<?php endif; ?>
			return str;
		}
	}

	CodeGoods.formParams = function() {
		var queryData = {};
		queryData['locktype_name'] = $("#locktype_name").val();
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
		var index = layer.open({type: 2,title: '添加',area: ['600px', '350px'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockType/add'+url});
		this.layerIndex = index;
		if(!IsPC()){layer.full(index)}
	}


	CodeGoods.update = function (value) {
		if(value){
			var index = layer.open({type: 2,title: '修改',area: ['600px', '350px'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockType/update?locktype_id='+value});
			if(!IsPC()){layer.full(index)}
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.locktype_id;
				});
				idx = idx.substr(1);
				if(idx.indexOf(",") !== -1){
					Feng.info("请选择单条数据！");
					return false;
				}
				var index = layer.open({type: 2,title: '修改',area: ['600px', '350px'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockType/update?locktype_id='+idx});
				this.layerIndex = index;
				if(!IsPC()){layer.full(index)}
			}
		}
	}


	CodeGoods.delete = function (value) {
		if(value){
			Feng.confirm("是否删除选中项？", function () {
				var ajax = new $ax(Feng.ctxPath + "/LockType/delete", function (data) {
					if ('00' === data.status) {
						Feng.success(data.msg);
						CodeGoods.table.refresh();
					} else {
						Feng.error(data.msg);
					}
				});
				ajax.set('locktype_ids', value);
				ajax.start();
			});
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.locktype_id;
				});
				idx = idx.substr(1);
				Feng.confirm("是否删除选中项？", function () {
					var ajax = new $ax(Feng.ctxPath + "/LockType/delete", function (data) {
						if ('00' === data.status) {
							Feng.success(data.msg);
							CodeGoods.table.refresh();
						} else {
							Feng.error(data.msg);
						}
					});
					ajax.set('locktype_ids', idx);
					ajax.start();
				});
			}
		}
	}


	CodeGoods.view = function (value) {
		if(value){
			var index = layer.open({type: 2,title: '查看数据',area: ['600px', '350px'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockType/view?locktype_id='+value});
			if(!IsPC()){layer.full(index)}
		}else{
			if (this.check()) {
				var idx = '';
				$.each(CodeGoods.seItem, function() {
					idx += ',' + this.locktype_id;
				});
				idx = idx.substr(1);
				var index = layer.open({type: 2,title: '查看数据',area: ['600px', '350px'],fix: false, maxmin: true,content: Feng.ctxPath + '/LockType/view?locktype_id='+idx});
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
		var table = new BSTable(CodeGoods.id, Feng.ctxPath+"/LockType/index"+url,defaultColunms,20);
		table.setPaginationType("server");
		table.setQueryParams(CodeGoods.formParams());
		CodeGoods.table = table.init();
	});
</script>

</div>
<script src="__PUBLIC__/static/js/content.js?v=1.0.0"></script>

</body>
</html>
