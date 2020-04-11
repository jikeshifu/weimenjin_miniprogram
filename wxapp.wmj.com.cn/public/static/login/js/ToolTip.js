// ******************************默认设置定义******************************
var iXuEr_TipsPop = null;
var iXuEr_TipsTitle = "图片预览"; // 提示框标题文字  js注释标题
var iXuEr_TipsoffsetX = 10; // 提示框位于鼠标左侧或者右侧的距离；3-12 合适
var iXuEr_TipsoffsetY = 15; // 提示框位于鼠标下方的距离；3-12 合适
var iXuEr_TipsPopbg = "#FFFFFF"; // 提示框背景色
var iXuEr_TipsPopfg = "infotext"; // 提示框前景色
var iXuEr_TipsAlpha = 100; // 提示框透明度，100为不透明
var iXuEr_Tipsshadowcolor = "#eeeeee"; // 提示框阴影颜色
var iXuEr_Tipsshadowdirection = 135; // 提示框阴影方向
var iXuEr_TipsTitlebg = "#989899"; // 提示框标题文字背景
var iXuEr_TipsTitlefg = "captiontext"; // 提示框标题文字颜色
var iXuEr_TipsBorderColor = "#cccccc"; // 提示框标题边框颜色
var iXuEr_TipsBorder	= 1; // 提示框标题边框宽度
var iXuEr_TipsBaseWidth = 200; // 提示框最小宽度 注意这个值最好不要小于提示框的象素宽度
var iXuEr_TipsSmallTitle = "";	// 提示框副标题文字 
var iXuEr_TipsTitleCt = " " // 标题文字和副标题文字之间的连接符

var FormObj;
var UsedForm="none";
// ==================================================================================

document.write('<div id=iXuEr_TipsLayer style="display: none;position: absolute; z-index:10001"></div>');

function iXuEr_Tips(){
	var o=event.srcElement;
	if(o.alt==null && o.title==null){return false;}
	if(o.alt!=null && o.alt!=""){o.dypop=o.alt;o.alt=""};
	//if(o.title!=null && o.title!=""){o.dypop=o.title;o.title=""};
	iXuEr_TipsPop=o.dypop;
	if(iXuEr_TipsPop!=null && iXuEr_TipsPop!="" && typeof(iXuEr_TipsPop)!="undefined"){
		iXuEr_TipsLayer.style.left=-1000;
		iXuEr_TipsLayer.style.display='';
		var Msg = iXuEr_TipsPop.replace(/\n/g,"<br>"); // 换行符
		Msg = Msg.replace(/\r/g,"<br>"); // 回车符
		if(iXuEr_TipsSmallTitle==""){iXuEr_TipsTitleCt="";}
		var attr=(document.location.toString().toLowerCase().indexOf("list.jsp")>0?"nowrap":"");
		var content = '<table style="FILTER:alpha(opacity='+iXuEr_TipsAlpha+') shadow(color='+iXuEr_Tipsshadowcolor+',direction='+iXuEr_Tipsshadowdirection+');" id=toolTipTalbe border=0><tr><td width="100%"><table border=0 cellspacing="'+iXuEr_TipsBorder+'" cellpadding="2" style="width:100%;background-color:'+iXuEr_TipsBorderColor+';">'+
		'<tr id=iXuEr_TipsPoptop><th style="width:100%; color:'+iXuEr_TipsTitlefg+'; background-color:'+iXuEr_TipsTitlebg+';" class=lg_s><b><p id=topleft align=left>↖ '+iXuEr_TipsTitle+iXuEr_TipsTitleCt+iXuEr_TipsSmallTitle+'</p><p id=topright align=right style="display:none" class=lg_s>'+iXuEr_TipsSmallTitle+iXuEr_TipsTitleCt+iXuEr_TipsTitle+' ↗</font></b></th></tr>'+
		'<tr><td '+attr+' style="width:100%; background-color:'+iXuEr_TipsPopbg+'; color:'+iXuEr_TipsPopfg+'; padding-left:10px; padding-right:10px; padding-top: 4px; padding-bottom:4px; line-height:135%;font-family: Verdana, Arial, Helvetica, sans-serif, "宋体";" class=lg_s>'+Msg+'</td></tr>'+
		'</table></td></tr></table>';
		iXuEr_TipsLayer.innerHTML = content;
		var toolTipwidth = Math.min(iXuEr_TipsLayer.clientWidth, document.body.clientWidth/2.2);
		if(toolTipwidth<iXuEr_TipsBaseWidth){toolTipwidth=iXuEr_TipsBaseWidth;}
		toolTipTalbe.style.width=toolTipwidth;
		MoveToMouseLoc();
		return true;
	}else{
		iXuEr_TipsLayer.innerHTML='';
		iXuEr_TipsLayer.style.display='none';
		return true;
	}
}

function MoveToMouseLoc(){
	if(iXuEr_TipsLayer.innerHTML==''){return true;}
	var MouseX=event.x;
	var MouseY=event.y;
	var popTopAdjust=0;
	//window.status="x:"+event.offsetX;
	//window.status+=" y:"+event.offsetY;
	var popHeight=iXuEr_TipsLayer.clientHeight;
	var popWidth=iXuEr_TipsLayer.clientWidth;
	if(MouseY+iXuEr_TipsoffsetY+popHeight>document.body.clientHeight){
		popTopAdjust=-popHeight-iXuEr_TipsoffsetY*1.5;
		iXuEr_TipsPoptop.style.display="none";
		iXuEr_TipsPopbot.style.display="";
	}else{
		popTopAdjust=0;
		iXuEr_TipsPoptop.style.display="";
		iXuEr_TipsPopbot.style.display="none";
	}
	if(MouseX+iXuEr_TipsoffsetX+popWidth>document.body.clientWidth){
		popLeftAdjust=-popWidth-iXuEr_TipsoffsetX*2;
		topleft.style.display="none";
		botleft.style.display="none";
		topright.style.display="";
		botright.style.display="";
	}else{
		popLeftAdjust=0;
		topleft.style.display="";
		botleft.style.display="";
		topright.style.display="none";
		botright.style.display="none";
	}
	iXuEr_TipsLayer.style.left=MouseX+iXuEr_TipsoffsetX+document.body.scrollLeft+popLeftAdjust;
	iXuEr_TipsLayer.style.top=MouseY+iXuEr_TipsoffsetY+document.body.scrollTop+popTopAdjust;
	return true;
}

document.onmousemove 	= iXuEr_Tips;




