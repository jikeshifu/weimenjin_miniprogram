var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		lock_name: {
			validators: {
				notEmpty: {
					message: '锁名称不能为空'
	 			},
	 		}
	 	},
		lock_sn: {
			validators: {
				notEmpty: {
					message: '序列号不能为空'
	 			},
	 		}
	 	},
		location: {
			validators: {
				notEmpty: {
					message: '位置不能为空'
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
	this.set('lock_id').set('lock_id').set('member_id').set('user_id').set('lock_name').set('lock_sn').set('lock_type').set('location').set('lock_qrcode').set('create_time').set('successimg').set('successadimg').set('openadurl');
};


CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var mobile_check = $("input[name = 'mobile_check']:checked").val();
	 var applyauth = $("input[name = 'applyauth']:checked").val();
	 var applyauth_check = $("input[name = 'applyauth_check']:checked").val();
	 var location_check = $("input[name = 'location_check']:checked").val();
	 var status = $("input[name = 'status']:checked").val();
	 var adnum = $("input[name = 'adnum']:checked").val();
	 var hitshowminiad = $("input[name = 'hitshowminiad']:checked").val();
	 var qrshowminiad = $("input[name = 'qrshowminiad']:checked").val();
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/Lock/add", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('mobile_check',mobile_check);
	 ajax.set('applyauth',applyauth);
	 ajax.set('applyauth_check',applyauth_check);
	 ajax.set('location_check',location_check);
	 ajax.set('status',status);
	 ajax.set('adnum',adnum);
	 ajax.set('hitshowminiad',hitshowminiad);
	 ajax.set('qrshowminiad',qrshowminiad);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var mobile_check = $("input[name = 'mobile_check']:checked").val();
	 var applyauth = $("input[name = 'applyauth']:checked").val();
	 var applyauth_check = $("input[name = 'applyauth_check']:checked").val();
	 var location_check = $("input[name = 'location_check']:checked").val();
	 var status = $("input[name = 'status']:checked").val();
	 var adnum = $("input[name = 'adnum']:checked").val();
	 var hitshowminiad = $("input[name = 'hitshowminiad']:checked").val();
	 var qrshowminiad = $("input[name = 'qrshowminiad']:checked").val();
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/Lock/update", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('mobile_check',mobile_check);
	 ajax.set('applyauth',applyauth);
	 ajax.set('applyauth_check',applyauth_check);
	 ajax.set('location_check',location_check);
	 ajax.set('status',status);
	 ajax.set('adnum',adnum);
	 ajax.set('hitshowminiad',hitshowminiad);
	 ajax.set('qrshowminiad',qrshowminiad);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.opendoor = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/Lock/opendoor", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
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


