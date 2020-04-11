var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		class_name: {
			validators: {
				notEmpty: {
					message: '栏目名称不能为空'
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
	this.set('class_id').set('pid').set('class_name').set('list_tpl').set('detail_tpl').set('pic').set('subtitle').set('filepath').set('filename').set('keyword').set('description').set('jumpurl').set('sortid').set('module_id').set('upload_config_id');
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
	 var ajax = new $ax(Feng.ctxPath + "/Cms.Catagory/add", function (data) {
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
	 var ajax = new $ax(Feng.ctxPath + "/Cms.Catagory/update", function (data) {
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
	 ajax.set('type',type);
	 ajax.set('status',status);
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


