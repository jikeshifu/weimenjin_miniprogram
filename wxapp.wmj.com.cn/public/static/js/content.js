var $parentNode = window.parent.document;

function $childNode(name) {
    return window.frames[name]
}

// tooltips
$('.tooltip-demo').tooltip({
    selector: "[data-toggle=tooltip]",
    container: "body"
});

// 使用animation.css修改Bootstrap Modal
$('.modal').appendTo("body");

$("[data-toggle=popover]").popover();

//折叠ibox
$('.collapse-link').click(function () {
    var ibox = $(this).closest('div.ibox');
    var button = $(this).find('i');
    var content = ibox.find('div.ibox-content');
    content.slideToggle(200);
    button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
    ibox.toggleClass('').toggleClass('border-bottom');
    setTimeout(function () {
        ibox.resize();
        ibox.find('[id^=map-]').resize();
    }, 50);
});

//关闭ibox
$('.close-link').click(function () {
    var content = $(this).closest('div.ibox');
    content.remove();
});

//判断当前页面是否在iframe中

//animation.css
function animationHover(element, animation) {
    element = $(element);
    element.hover(
        function () {
            element.addClass('animated ' + animation);
        },
        function () {
            //动画完成之前移除class
            window.setTimeout(function () {
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

//拖动面板
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable({
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8,
        })
        .disableSelection();
};

function formatDateTime(timeStamp,type) { 
	var date = new Date();
	date.setTime(timeStamp * 1000);
	var y = date.getFullYear();
	var m = date.getMonth() + 1;
	m = m < 10 ? ('0' + m) : m;
	var d = date.getDate();
	d = d < 10 ? ('0' + d) : d;
	var h = date.getHours();
	h = h < 10 ? ('0' + h) : h;
	var minute = date.getMinutes();
	 var second = date.getSeconds();
	minute = minute < 10 ? ('0' + minute) : minute;
	second = second < 10 ? ('0' + second) : second;
	
	switch(type){
		case 'Y-m-d H:i:s':
			return y + '-' + m + '-' + d+' '+h+':'+minute+':'+second;
		break;
		
		case 'Y-m-d':
			return y + '-' + m + '-' + d;
		break;
		
		case 'Y-m':
			return y + '-' + m;
		break;
		
		case 'Y':
			return y;
		break;
		
		case 'H:i:s':
			return h+':'+minute+':'+second;
		break;
	}
	
}

//显示多选框对应的数据
function getCheckBoxValue(value,field_value){
	var strs,values= new Array(); //定义一数组 
	var str = '';
	strs=value.split(","); //字符分割 
	for (i=0;i<strs.length;i++ ) 
	{ 
		if(field_value){
			values = field_value.split(',');
			for (j=0;j<values.length;j++ ){
				if(strs[i] == values[j].split('|')[1]){
					str += ',' + values[j].split('|')[0];
				}
			}
		}
	} 
	return str.substr(1);
}


function showBigPic(filepath) {
	var html = "<div id='bigPic' style='position:absolute;display:none; z-index:99999'><img src='' id='pre_view'/><br /></div>";

	$(".ibox").append(html);
    //将文件路径传给img大图
    document.getElementById('pre_view').src = filepath;
    //获取大图div是否存在
	
	
    var div = document.getElementById("bigPic");
    if (!div) {
        return;
    }
    //如果存在则展示
    document.getElementById("bigPic").style.display="block";
    //获取鼠标坐标
    var intX = window.event.clientX;
    var intY = window.event.clientY;
    //设置大图左上角起点位置
    div.style.left = intX +5+ "px";
    div.style.top = intY + 5+"px";
}

openImg = function(value){
	var img = "<img src="+value+" style=\"max-height:500px\">";	
	layer.open({  
		type: 1,  
		shade: false,  
		title: false, //不显示标题  
		area:['auto','auto'],  
		area: [img.width + 'px', img.height+'px'],  
		content: img, //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响  
		cancel: function () {  
			//layer.msg('图片查看结束！', { time: 5000, icon: 6 });  
		}  
	});
}


function IsPC() {
    var userAgentInfo = navigator.userAgent;
    var Agents = ["Android", "iPhone",
                "SymbianOS", "Windows Phone",
                "iPad", "iPod"];
    var flag = true;
    for (var v = 0; v < Agents.length; v++) {
        if (userAgentInfo.indexOf(Agents[v]) > 0) {
            flag = false;
            break;
        }
    }
    return flag;
}


//隐藏
function closeimg(){
    document.getElementById("bigPic").style.display="none";
}


