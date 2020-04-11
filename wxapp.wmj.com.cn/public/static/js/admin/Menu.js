var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		title: {
			validators: {
				notEmpty: {
					message: '菜单标题不能为空'
	 			}
	 		}
	 	},
		controller_name: {
			validators: {
				regexp: {
					regexp: /^[0-9a-zA-Z/]+$/,
					message: '大小写字母组合'
	 			},
	 		}
	 	},
		table_name: {
			validators: {
				regexp: {
					regexp: /^[a-zA-Z_0-9]+$/,
					message: '大小写字母组合'
	 			},
	 		}
	 	},
		pk_id: {
			validators: {
				regexp: {
					regexp: /^[a-zA-Z_]+$/,
					message: '大小写字母组合'
	 			},
	 		}
	 	}
		
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
	this.set('menu_id').set('title').set('controller_name').set('table_name').set('pk_id').set('sortid').set('pid').set('url').set('menu_icon').set('tab_menu').set('app_id');
};


CodeInfoDlg.icon = function () {
		var index = layer.open({type: 2,title: '设置图标',area: ['800px', '500px'],fix: false, maxmin: true,content: Feng.ctxPath + '/Base/icon/field/menu_icon'});
		this.layerIndex = index;
}


CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 
	 var is_create = $("input[name = 'is_create']:checked").val();
	 var is_url = $("input[name = 'is_url']:checked").val();
	 var table_status = $("input[name = 'table_status']:checked").val();
	 var status = $("input[name = 'status']:checked").val();
	 var is_submit = $("input[name = 'is_submit']:checked").val();
	 
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/Menu/add", function (data) {
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
	 ajax.set('is_create',is_create);
	 ajax.set('is_url',is_url);
	 ajax.set('table_status',table_status);
	 ajax.set('status',status);
	 ajax.set('is_submit',is_submit);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 
	 var is_create = $("input[name = 'is_create']:checked").val();
	 var is_url = $("input[name = 'is_url']:checked").val();
	 var table_status = $("input[name = 'table_status']:checked").val();
	 var status = $("input[name = 'status']:checked").val();
	 var is_submit = $("input[name = 'is_submit']:checked").val();
	 
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/Menu/update", function (data) {
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
	 ajax.set('is_create',is_create);
	 ajax.set('is_url',is_url);
	 ajax.set('table_status',table_status);
	 ajax.set('status',status);
	 ajax.set('is_submit',is_submit);
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


