var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
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
	this.set('lockauth_id').set('lockauth_id').set('lock_id').set('member_id').set('realname').set('auth_member_id').set('auth_sharelimit').set('auth_starttime').set('auth_endtime').set('remark').set('create_time').set('auth_openlimit').set('auth_opentimes').set('user_id');
};


CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var auth_shareability = $("input[name = 'auth_shareability']:checked").val();
	 var auth_isadmin = $("input[name = 'auth_isadmin']:checked").val();
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/LockAuth/add", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('auth_shareability',auth_shareability);
	 ajax.set('auth_isadmin',auth_isadmin);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var auth_shareability = $("input[name = 'auth_shareability']:checked").val();
	 var auth_isadmin = $("input[name = 'auth_isadmin']:checked").val();
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/LockAuth/update", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('auth_shareability',auth_shareability);
	 ajax.set('auth_isadmin',auth_isadmin);
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


