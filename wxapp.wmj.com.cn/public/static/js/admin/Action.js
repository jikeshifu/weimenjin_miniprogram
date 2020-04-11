var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		name: {
			validators: {
				notEmpty: {
					message: '操作名不能为空'
	 			}
	 		}
	 	},
		action_name: {
			validators: {
				notEmpty: {
					message: '方法不能为空'
	 			},
				regexp: {
					regexp: /^[a-zA-Z_]+$/,
					message: '大小写字母组合'
	 			},
	 		}
	 	},
		type: {
			validators: {
				notEmpty: {
					message: '方法类型不能为空'
	 			}
	 		}
	 	},
		pagesize: {
			validators: {
				regexp: {
					regexp: /^[0-9]*$/,
					message: '请输入整数'
	 			}
	 		}
	 	},
		
	 }
}


CodeInfoDlg.clearData = function () {
	 this.CodeInfoData = {};
};


CodeInfoDlg.set = function (key, val) {
	 this.CodeInfoData[key] = (typeof value == "undefined") ? $("#" + key).val() : value;
	 return this;
};


CodeInfoDlg.get = function (key) {
	 return $("#" + key).val();
};


CodeInfoDlg.close = function () {
	 var index = parent.layer.getFrameIndex(window.name);
	 parent.layer.close(index);
};


CodeInfoDlg.collectData = function () {
	this.set('id').set('menu_id').set('name').set('action_name').set('type').set('block_name').set('remark').set('sortid').set('lable_color').set('bs_icon').set('relate_table').set('relate_field').set('list_field').set('orderby').set('sql_query').set('default_orderby').set('pagesize').set('jump').set('tree_config').set('cache_time').set('request_type').set('do_condition');
};

CodeInfoDlg.icon = function () {
		var index = layer.open({type: 2,title: '设置图标',area: ['800px', '500px'],fix: false, maxmin: true,content: Feng.ctxPath + '/Base/icon/field/bs_icon'});
		this.layerIndex = index;
}


CodeInfoDlg.config = function () {
		var index = layer.open({type: 2,title: '操作配置说明',area: ['100%', '500px'],fix: false, maxmin: true,content: Feng.ctxPath + '/Action/config'});
		this.layerIndex = index;
}



CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }

	 var is_controller_create = $("input[name = 'is_controller_create']:checked").val();
	 var is_service_create = $("input[name = 'is_service_create']:checked").val();
	 var is_view_create = $("input[name = 'is_view_create']:checked").val();
	 var is_view = $("input[name = 'is_view']:checked").val();
	 var log_status = $("input[name = 'log_status']:checked").val();
	 var api_auth = $("input[name = 'api_auth']:checked").val();
	 var sms_auth = $("input[name = 'sms_auth']:checked").val();
	 var captcha_auth = $("input[name = 'captcha_auth']:checked").val();
	 var button_status = $("input[name = 'button_status']:checked").val();
	 var fields = '';
     $('input[name="fields"]:checked').each(function(){ 
		fields += ',' + $(this).val();
     }); 
	 fields = fields.substr(1);
	 
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/Action/add", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(tip + "成功" );
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 }, function (data) {
	 	Feng.error("操作失败!" + data.responseJSON.message + "!");
	 });
	 ajax.set('is_controller_create',is_controller_create);
	 ajax.set('is_service_create',is_service_create);
	 ajax.set('is_view_create',is_view_create);
	 ajax.set('is_view',is_view);
	 ajax.set('log_status',log_status);
	 ajax.set('api_auth',api_auth);
	 ajax.set('sms_auth',sms_auth);
	 ajax.set('captcha_auth',captcha_auth);
	 ajax.set('button_status',button_status);
	 ajax.set('fields',fields);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }

	 var is_controller_create = $("input[name = 'is_controller_create']:checked").val();
	 var is_service_create = $("input[name = 'is_service_create']:checked").val();
	 var is_view_create = $("input[name = 'is_view_create']:checked").val();
	 var is_view = $("input[name = 'is_view']:checked").val();
	 var log_status = $("input[name = 'log_status']:checked").val();
	 var api_auth = $("input[name = 'api_auth']:checked").val();
	 var sms_auth = $("input[name = 'sms_auth']:checked").val();
	 var captcha_auth = $("input[name = 'captcha_auth']:checked").val();
	 var button_status = $("input[name = 'button_status']:checked").val();
	 var fields = '';
     $('input[name="fields"]:checked').each(function(){ 
		fields += ',' + $(this).val();
     }); 
	 fields = fields.substr(1);
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/Action/update", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(tip + "成功" );
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 }, function (data) {
	 	Feng.error("操作失败!" + data.responseJSON.message + "!");
	 });

	 ajax.set('is_controller_create',is_controller_create);
	 ajax.set('is_service_create',is_service_create);
	 ajax.set('is_view_create',is_view_create);
	 ajax.set('is_view',is_view);
	 ajax.set('log_status',log_status);
	 ajax.set('api_auth',api_auth);
	 ajax.set('sms_auth',sms_auth);
	 ajax.set('captcha_auth',captcha_auth);
	 ajax.set('button_status',button_status);
	 ajax.set('fields',fields);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};

CodeInfoDlg.fast = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }

	 var actions = '';
     $('input[name="action"]:checked').each(function(){ 
		actions += ',' + $(this).val();
     }); 
	 actions = actions.substr(1);
	 
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/Action/fast", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(tip + "成功" );
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 }, function (data) {
	 	Feng.error("操作失败!" + data.responseJSON.message + "!");
	 });
	 ajax.set('actions',actions);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};




CodeInfoDlg.validate = function () {
	  $('#CodeInfoForm').data("bootstrapValidator").resetForm();
	  $('#CodeInfoForm').bootstrapValidator('validate');
	  return $("#CodeInfoForm").data('bootstrapValidator').isValid();
};


$(function () {
	   Feng.initValidator("CodeInfoForm", CodeInfoDlg.validateFields);
});


