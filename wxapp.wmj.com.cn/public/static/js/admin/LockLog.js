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
	this.set('locklog_id').set('locklog_id').set('member_id').set('user_id').set('lock_id').set('lock_name').set('headimgurl').set('nickname').set('mobile').set('remark').set('create_time');
};


CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var status = $("input[name = 'status']:checked").val();
	 var type = $("input[name = 'type']:checked").val();
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/LockLog/add", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('status',status);
	 ajax.set('type',type);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var status = $("input[name = 'status']:checked").val();
	 var type = $("input[name = 'type']:checked").val();
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/LockLog/update", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('status',status);
	 ajax.set('type',type);
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


