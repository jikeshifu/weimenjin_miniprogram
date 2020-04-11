var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		name: {
			validators: {
				notEmpty: {
					message: '真实姓名不能为空'
	 			},
	 		}
	 	},
		user: {
			validators: {
				notEmpty: {
					message: '用户名不能为空'
	 			},
	 		}
	 	},
		pwd: {
			validators: {
				notEmpty: {
					message: '密码不能为空'
	 			},
				regexp: {
					regexp: /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/,
					message: '6-21位数字字母组合'
	 			},
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
	this.set('user_id').set('user_id').set('name').set('user').set('pwd').set('group_id').set('group_name').set('note').set('member_id').set('create_time');
};


CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var type = $("input[name = 'type']:checked").val();
	 var status = $("input[name = 'status']:checked").val();
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/User/add", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('type',type);
	 ajax.set('status',status);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var type = $("input[name = 'type']:checked").val();
	 var status = $("input[name = 'status']:checked").val();
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/User/update", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('type',type);
	 ajax.set('status',status);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.updatePassword = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var tip = '操作';
	 var ajax = new $ax(Feng.ctxPath + "/User/updatePassword", function (data) {
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


