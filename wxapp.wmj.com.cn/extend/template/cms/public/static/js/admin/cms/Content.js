var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		
		class_id: {
			validators: {
				notEmpty: {
					message: '所属栏目不能为空'
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
	this.set('content_id').set('title').set('class_name').set('class_id').set('pic').set('content').set('jumpurl').set('create_time').set('keyword').set('description').set('views').set('sortid').set('author');
};


CodeInfoDlg.add = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var detail = UE.getEditor('detail').getContent();
	 var status = $("input[name = 'status']:checked").val();
	 var position = '';
	 $('input[name="position"]:checked').each(function(){ 
	 	position += ',' + $(this).val(); 
	 }); 
	  position = position.substr(1); 
	 var tip = '添加';
	 var ajax = new $ax(Feng.ctxPath + "/Cms.Content/add", function (data) {
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
	 
	 ajax.set('status',status);
	 ajax.set('position',position);
	 ajax.set('detail',detail);
	 ajax.set(this.CodeInfoData);
	 
	 var entend = new $ax(Feng.ctxPath + "/Cms.Content/getExtends", function (data) {
		var fieldList = data.fieldList;
		for(var p in fieldList){
			var type = fieldList[p]['type'];
			
			if(type == 3){
				ajax.set(fieldList[p]['field'],$("input[name = '"+fieldList[p]['field']+"']:checked").val());
			}else if(type == 4){	
				var checkData = '';
				$('input[name="'+fieldList[p]['field']+'"]:checked').each(function(){ 
					checkData += ',' + $(this).val(); 
				});
				checkData = checkData.substr(1);
				
				ajax.set(fieldList[p]['field'],checkData);
			}else if(type == 9){	
				var images = '';
				$("."+fieldList[p]['field']+" img").each(function() {
					images += '|'+$(this).attr('src');
				});
				images = images.substr(1);
				ajax.set(fieldList[p]['field'],images);
			}else if(type == 16){
				ajax.set(fieldList[p]['field'],UE.getEditor(''+fieldList[p]['field']+'').getContent());
			}else if(type == 17){
				var areaaddress = fieldList[p]['field'].split('|');
				for (var i = 0; i < areaaddress.length; i++){
					ajax.set(areaaddress[i],$("#"+areaaddress[i]).val());
				}
			}else{
				ajax.set(fieldList[p]['field'],$("#"+fieldList[p]['field']).val());
			}
		}
		
	 });
	entend.set('class_id', $("#class_id option:selected").val());
	entend.start();
	 
	ajax.start();
};




CodeInfoDlg.update = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }
	 var detail = UE.getEditor('detail').getContent();
	 var status = $("input[name = 'status']:checked").val();
	 var position = '';
	 $('input[name="position"]:checked').each(function(){ 
	 	position += ',' + $(this).val(); 
	 }); 
	  position = position.substr(1); 
	 var tip = '修改';
	 var ajax = new $ax(Feng.ctxPath + "/Cms.Content/update", function (data) {
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
	 
	 
	 ajax.set('status',status);
	 ajax.set('position',position);
	 ajax.set('detail',detail);
	 ajax.set(this.CodeInfoData);
	 
	 var entend = new $ax(Feng.ctxPath + "/Cms.Content/getExtends", function (data) {
		var fieldList = data.fieldList;
		for(var p in fieldList){
			var type = fieldList[p]['type'];
			
			if(type == 3){
				ajax.set(fieldList[p]['field'],$("input[name = '"+fieldList[p]['field']+"']:checked").val());
			}else if(type == 4){	
				var checkData = '';
				$('input[name="'+fieldList[p]['field']+'"]:checked').each(function(){ 
					checkData += ',' + $(this).val(); 
				});
				checkData = checkData.substr(1);
				
				ajax.set(fieldList[p]['field'],checkData);
			}else if(type == 9){	
				var images = '';
				$("."+fieldList[p]['field']+" img").each(function() {
					images += '|'+$(this).attr('src');
				});
				images = images.substr(1);
				ajax.set(fieldList[p]['field'],images);
			}else if(type == 16){
				ajax.set(fieldList[p]['field'],UE.getEditor(''+fieldList[p]['field']+'').getContent());
			}else if(type == 17){
				var areaaddress = fieldList[p]['field'].split('|');
				for (var i = 0; i < areaaddress.length; i++){
					ajax.set(areaaddress[i],$("#"+areaaddress[i]).val());
				}
			}else{
				ajax.set(fieldList[p]['field'],$("#"+fieldList[p]['field']).val());
			}
		}
		
	 });
	 
	entend.set('class_id', $("#class_id option:selected").val());
	entend.start();
	 
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


