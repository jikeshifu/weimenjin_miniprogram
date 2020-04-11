var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		name: {
			validators: {
				notEmpty: {
					message: '字段名不能为空'
	 			}
	 		}
	 	},
		field: {
			validators: {
				notEmpty: {
					message: '字段不能为空'
	 			},
				regexp: {
					regexp: /^[a-z_|0-9]+$/,
					message: '只限制小写字母、数字、下划线'
	 			},
	 		}
	 	},
		type: {
			validators: {
				notEmpty: {
					message: '字段类型不能为空'
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
	this.set('id').set('menu_id').set('name').set('field').set('type').set('align').set('config').set('default_value').set('note').set('message').set('sortid').set('sql').set('rule').set('tab_menu_name').set('datatype').set('length').set('indexdata');
};



CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 
	 var list_show = $("input[name = 'list_show']:checked").val();
	 var search_show = $("input[name = 'search_show']:checked").val();
	 var search_type = $("input[name = 'search_type']:checked").val();
	 var is_post = $("input[name = 'is_post']:checked").val();
	 var is_field = $("input[name = 'is_field']:checked").val();
	 var validate = '';
     $('input[name="validate"]:checked').each(function(){ 
		validate += ',' + $(this).val();
     }); 
	 validate = validate.substr(1);
	 
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/Field/add", function (data) {
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
	 ajax.set('is_field',is_field);
	 ajax.set('list_show',list_show);
	 ajax.set('search_show',search_show);
	 ajax.set('search_type',search_type);
	 ajax.set('is_post',is_post);
	 ajax.set('validate',validate);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var list_show = $("input[name = 'list_show']:checked").val();
	 var search_show = $("input[name = 'search_show']:checked").val();
	 var search_type = $("input[name = 'search_type']:checked").val();
	 var is_post = $("input[name = 'is_post']:checked").val();
	 var is_field = $("input[name = 'is_field']:checked").val();
	  var validate = '';
     $('input[name="validate"]:checked').each(function(){ 
		validate += ',' + $(this).val();
     }); 
	 validate = validate.substr(1);
	 
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/Field/update", function (data) {
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
	 ajax.set('is_field',is_field);
	 ajax.set('list_show',list_show);
	 ajax.set('search_show',search_show);
	 ajax.set('search_type',search_type);
	 ajax.set('is_post',is_post);
	 ajax.set('validate',validate);
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


