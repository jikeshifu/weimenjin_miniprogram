var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		password: {
			validators: {
				notEmpty: {
					message: '新密码不能为空'
	 			},
				regexp: {
					regexp: /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/,
					message: '6-21字母和数字组合'
	 			},
	 		}
	 	},
		repassword: {
			validators: {
				notEmpty: {
					message: '确认密码不能为空'
	 			},
				identical: {
					field: 'password',
					message: '两次密码输入不一致'
                }
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
	this.set('password');
};

CodeInfoDlg.addAuth = function () {
    
    var tip = '设置';
	var str = '';
	$("input[name='authorize']").each(function(){  
		if($(this).is(":checked"))  
		{  
			str += "," + $(this).val();  
		}  
	});  
	str = str.substr(1);
    var ajax = new $ax(Feng.ctxPath + "/Base/auth", function (data) {
    	if (1 === parseInt(data.code)) {
			Feng.success(tip + "成功！" );
	        CodeInfoDlg.close();
		} else {
			Feng.error(tip + "失败！" + data.msg + "！");
		}
    }, function (data) {
        Feng.error("修改失败!" + data.responseJSON.message + "!");
    });
    ajax.set('purviewval',str);
	ajax.set('id',$("#id").val());
    ajax.start();
    
};

CodeInfoDlg.updatePassword = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }

	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/Base/password", function (data) {
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
	 ajax.set('password',password);
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


