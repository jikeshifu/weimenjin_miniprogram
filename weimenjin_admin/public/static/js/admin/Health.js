var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		name: {
			validators: {
				notEmpty: {
					message: '姓名不能为空'
	 			},
	 		}
	 	},
		mobile: {
			validators: {
				regexp: {
					regexp: /^1[1-9]\d{9}$/,
					message: '手机号不正确'
	 			},
	 		}
	 	},
		first_address: {
			validators: {
				notEmpty: {
					message: '家庭地址不能为空'
	 			},
	 		}
	 	},
		position: {
			validators: {
				notEmpty: {
					message: '当前位置不能为空'
	 			},
	 		}
	 	},
		register_type: {
			validators: {
				regexp: {
					regexp: /^[0-9]*$/,
					message: '登记类型错误'
	 			},
	 		}
	 	},
		health: {
			validators: {
				notEmpty: {
					message: '健康状况不能为空'
	 			},
				regexp: {
					regexp: /^[0-9]*$/,
					message: ''
	 			},
	 		}
	 	},
		create_time: {
			validators: {
				notEmpty: {
					message: '登记时间不能为空'
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
	this.set('health_id').set('name').set('mobile').set('first_address').set('second_address').set('position').set('job').set('manyou').set('txz').set('create_time').set('lat').set('lng').set('user_id').set('openid').set('regpoint_id').set('regpointname');
};


CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var yiqu = $("input[name = 'yiqu']:checked").val();
	 var register_type = $("input[name = 'register_type']:checked").val();
	 var health = $("input[name = 'health']:checked").val();
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/Health/add", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('yiqu',yiqu);
	 ajax.set('register_type',register_type);
	 ajax.set('health',health);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};


CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var yiqu = $("input[name = 'yiqu']:checked").val();
	 var register_type = $("input[name = 'register_type']:checked").val();
	 var health = $("input[name = 'health']:checked").val();
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/Health/update", function (data) {
	 	if ('00' === data.status) {
	 		Feng.success(data.msg);
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 })
	 ajax.set('yiqu',yiqu);
	 ajax.set('register_type',register_type);
	 ajax.set('health',health);
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


