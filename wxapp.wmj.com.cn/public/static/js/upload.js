/*
picker 按钮ID
thumb input输入框ID
num 上传图片的数量
multiple false 单图上传 true多图上传
srcs  初始化已经上传的多图
filetype   image 图片上传 file 文件上传
*/

function uploader(picker,thumb,filetype,multiple,srcs,uploadUrl){

	var uploader,
	UploaderList = {
		init: function () {
			this.queue = $('<ul class="filelist"></ul>').prependTo($('.'+thumb));
			if(srcs){
				var album = eval('(' + srcs + ')');
				var length;
				for(var i in album) {
					length++;
					UploaderList.createList({
						name: '',
						dir: album[i],
						dom: null
					});
				}
				this.fileCounts = length;
			}
		},
		queue: null,
		files: [], // 上传文件操作数据数组
		// 设置第一张图片为封面
		
		createList: function (data) {
			
			if(multiple == true){
				this.files.push(data);
				var index = this.files.length - 1;
				var classname = getFileName(this.files[index].dir);
				var li_html = '<li style="margin:5px 5px 5px 0" class='+classname+'>' + 
						'<p><img style="margin-bottom:3px" width="100" height="100" src="' + this.files[index].dir +'"/></p>' + 
						'<button type="button" id="update" class="btn btn-danger btn-xs btn-block" onclick=delfile(\''+this.files[index].dir+'\') ><i class="fa fa-trash"></i></button>' + 
						'</li>',
					$li = $(li_html),
					$wrap = $li.find('p.imgWrap'),
					$del = $li.find('p.cancel');
				this.files[index].dom = $li
				$li.prependTo( this.queue );
				
			}else{
				$("#"+thumb).val(data.dir);
			}
			
		}
	};

	UploaderList.init();
	
	var label,title,extensions,mimeType;
	if(filetype == 'image'){
		if(multiple == true){
			title = 'images';
			extensions = 'gif,jpg,jpeg,bmp,png';
			mimeType = 'image/*';
		}else{
			label = '图片上传';
			title = 'images';
			extensions = 'gif,jpg,jpeg,bmp,png';
			mimeType = 'image/*';
		}
		
	}else if(filetype == 'file'){
		label = '文件上传';
		title = 'files';
		extensions = '*';
		mimeType = '*';
	};

	// 初始化Web Uploader
	uploader = WebUploader.create({
		// 选完文件后，是否自动上传。
		auto: true,
		runtimeOrder: 'html5',

		// 文件接收服务端。
		server: uploadUrl,
		compress: false,//不启用压缩
		resize: false,//尺寸不改变
		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: {
			id: '#'+picker,
			multiple: multiple, // 多文件上传
			label: label, // 按钮文字
		},

		accept: {
			title: title,
			extensions: extensions,
			mimeTypes: mimeType
		},
		duplicate :true
	});
	
	uploader.onUploadProgress = function (file, percentage) {
        var $li = $('.'+thumb+'_process'),
            $percent = $li.find('.progress .progress-bar');
        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo($li).find('.progress-bar');
      	 }
        $li.find('p.state').text('上传中');
        $percent.css('width', percentage * 100 + '%');
    };
	
	// 上传成功后触发
	uploader.onUploadSuccess = function( file, response ) {
		if(response.code == '1') {
			UploaderList.createList({
				name: file.name,
				dir: response.data,
				dom: null,
				fileId: file.id,
			});
			if(multiple == true){
				$("#"+thumb).val(response.data + "|" + $("#"+thumb).val());	//输出文件地址
				
			}
			$('.'+thumb+'_process').find('.progress').fadeOut();
		} else {
			alert("图片" + file.name + "上传失败！");
		}
		return true;
	};
	
	

	// 上传失败后触发
	uploader.onUploadError = function( file, reason ) {
		alert('上传失败！');
		return false;
	};

	uploader.onError = function( code ) {
		var tx = '';
		if(code === 'F_EXCEED_SIZE') {
			tx = '请上传文件小于1M的图片';
		} else if(code === 'Q_EXCEED_SIZE_LIMIT') {
			tx = '添加的图片总大小超过10M';
		} else if(code === 'Q_TYPE_DENIED') {
			tx = '请上传gif,jpg,jpeg,bmp,png格式图片';
		} else if(code === 'Q_EXCEED_NUM_LIMIT') {
			tx = '最多添加10张图片';
		} else if(code === 'F_DUPLICATE') {
			tx = '请选择不同的图片';
		} else {
			tx = code;
		}
		alert( '错误: ' + tx );
	};
}

function delfile(src)
{
   var classname = getFileName(src);
   $("."+classname).remove();
  
}

function getFileName(o) {
    var pos = o.lastIndexOf('/');
    return o.substring(pos + 1).split('.')[0];
}

function setUploadButton(pick){
	$("#"+pick).find(".webuploader-pick").css({
		'width':'100px',
		'height':'125px',
		'background':'url("/static/img/upload.png")',
		'margin-top':'5px',
		'margin-right':'5px',
		'border':'1px solid #ddd',
	});

	$("#"+pick).find('div').eq(1).css({
		'width':'100px',
		'height':'125px'
	});
}


