String.prototype.replaceAll = function(s1,s2) {
    return this.replace(new RegExp(s1,"gm"),s2);
}
function ddd(){alert('ddd');}
jQuery.extend({'zoombox':(function(){
	var m = $("<div class=\"modal hide fade\" id=\"zoombox\"></div>");
	return {'show':function(type,obj,url){
			switch(type)
			{
				case 'confirm':
				var msg;
				if($(obj).attr('msg') && ($(obj).attr('msg') != ""))
				{
					msg = $(obj).attr('msg');
				}
				else
				msg = '您确定要删除吗？';
				var cnt = "<div class=\"modal-header\" style=\"height:2em;overflow:hidden;\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button><h5>操作确认</h5></div><div class=\"modal-body\"><p class=\"text-error\">"+msg+"</p></div><div class=\"modal-footer\"><button class=\"btn btn-primary\" onclick=\"javascript:submitAjax({'url':'"+url+"'});\">确定</button><button class=\"btn\" onclick=\"javascript:$.zoombox.hide();\">取消</button></div";
				break;

				case 'ajax':
				var cnt = "<div class=\"modal-header\" style=\"height:2em;overflow:hidden;\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button><h5>出现错误</h5></div><div class=\"modal-body\"><p class=\"text-error\">"+obj.message+"</p></div>";
				break;

				case 'ajaxOK':
				var cnt = "<div class=\"modal-header\" style=\"height:2em;overflow:hidden;\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button><h5>操作成功</h5></div><div class=\"modal-body\"><p class=\"text-success\">"+obj.message+"</p></div>";
				break;

				default:
				var cnt = "<div class=\"modal-header\" style=\"height:2em;overflow:hidden;\"><button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button><h5>出现错误</h5></div><div class=\"modal-body\"><p class=\"text-error\">"+$(obj).attr('message')+"</p></div>";
			}
			m.html(cnt);
			m.modal();
		},
		'hide':function(){
			m.modal('hide');
			m.remove();
		}
	};
})(),
'loginbox':(function(){
	var l = $("<div class=\"modal hide fade\" id=\"peloginbox\"></div>");
	var lcnt = "";
	return {'show':function(){
			/**
			if(Fingerprint)
			{
				var fp = new Fingerprint();
				$.getScript('index.php?core-api-finger&unreload=1&finger='+fp.get());
				fp = null;
			}
			**/
			lcnt = "<div class=\"modal-header\"><button class=\"close\" type=\"button\" data-dismiss=\"modal\">×</button><h5>用户登录</h5></div><div class=\"modal-body\"><form class=\"form-horizontal\" id=\"peloginform\" action=\"index.php?user-app-login\" style=\"padding-top:20px;\"><div class=\"control-group\"><label class=\"control-label\" for=\"inputEmail\">用户名</label><div class=\"controls\"><input name=\"args[username]\" type=\"text\" needle=\"needle\" msg=\"请输入正确格式的用户名\"/></div></div><div class=\"control-group\"><label class=\"control-label\" for=\"inputPassword\">密　码</label><div class=\"controls\"><input needle=\"needle\" msg=\"请输入正确格式的密码\" name=\"args[userpassword]\" type=\"password\" /><input type=\"hidden\" value=\"1\" name=\"userlogin\"/></div></div></form></div><div class=\"modal-footer\"><button class=\"btn btn-primary\" type=\"button\" onclick=\"javascript:$('#peloginform').submit();\">登录</button><button aria-hidden=\"true\" class=\"btn\" data-dismiss=\"modal\">取消</button></div>";
			l.html(lcnt);
			l.find("form").on('submit',formsubmit);
			l.modal({});
		},
		'hide':function(){
			l.modal('hide');
			l.remove();
		}
	};
})(),
'copyRight':'redrangon',
'removeUploadedImage': function(_this)
{
	$(_this).parents('.thumbuper').remove();
}});
function markSelectedQuestions(n,o){
	$("[name='"+n+"']").each(function(){if($('#'+o).val().indexOf(','+$(this).val()+',') >= 0)$(this).attr('checked',true);});
}
function doselectquestions(o,d,n)
{
	selectquestions(o,d,n);
	var op = $(o).attr("del");
	$('#'+op).remove();
}
function selectquestions(o,d,n){
	var d = $('#'+d);
	var n = $('#'+n);
	if(d.val() == '')d.val(',');
	if($(o).is(':checked')){
		if(d.val().indexOf(','+$(o).val()+',') < 0){
			d.val(d.val()+$(o).val()+',');
			n.html(parseInt(n.html())+parseInt($(o).attr('rel')));
		}
	}
	else{
		var t = eval('/,'+$(o).val()+',/');
		if(d.val().indexOf(','+$(o).val()+',') >= 0){
			d.val(d.val().replace(t,','));
			n.html(parseInt(n.html())-parseInt($(o).attr('rel')));
		}
	}
}
function setKnowsList(o,c,t){
	var oo = $('#'+o);
	var oc = $('#'+c);
	if(t == '+')
	{
		if(oc.val() == '' || oc.val() < 1)return false;
		var txt = oc.val()+':'+oc.find("option:selected").text();
		if(oo.val().indexOf(txt) == -1)
		{
			if(oo.val() == '')oo.val(txt);
			else oo.val(txt+'\n'+oo.val());
		}
	}
	else oo.val('');
}
function setAnswerHtml(t,o)
{
	$("."+o).hide();
	$("#"+o+"_"+t).show();
	if(parseInt(t) == 0 || parseInt(t) == 5)
	{
		$("#selectnumber").hide();
		$("#selecttext").hide();
	}
	else
	{
		$("#selectnumber").show();
		$("#selecttext").show();
	}
}
jQuery.cookie = function(key, value, options) {
    if (arguments.length > 1 && String(value) !== "[object Object]") {
        options = jQuery.extend({},
        options);
        if (value === null || value === undefined) {
            options.expires = -1;
        }
        if (typeof options.expires === 'number') {
            var days = options.expires,
            t = options.expires = new Date();
            t.setDate(t.getDate() + days);
        }
        value = String(value);
        return (document.cookie = [encodeURIComponent(key), '=', options.raw ? value: encodeURIComponent(value), options.expires ? '; expires=' + options.expires.toUTCString() : '', options.path ? '; path=' + options.path: '', options.domain ? '; domain=' + options.domain: '', options.secure ? '; secure': ''].join(''));
    }
    options = value || {};
    var result,
    decode = options.raw ?
    function(s) {
        return s;
    }: decodeURIComponent;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};
jQuery.extend({
	swfuexec : {
		"fileQueueError" : function (file, errorCode, message)
		{
			try
			{
				switch(errorCode)
				{
					default:
					var msg = '';
					switch (errorCode) {
						case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
							msg = "文件超出限制大小！";
						break;
						case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
							msg = "空文件，请重新上传！";
						break;
						case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
							msg = "不支持的文件类型！";
						break;
						default:
							msg = "未知错误！";
					}
					$('#'+this.customSettings.upload_target).attr('src','app/core/styles/images/none.gif');
					$('#'+this.customSettings.upload_msg).html(msg);
					this.cancelQueue(file);
					$.zoombox.close();
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"fileDialogComplete" : function (numFilesSelected, numFilesQueued)
		{
			try
			{
				if (numFilesQueued > 0)
				{
					this.startUpload();
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadProgress" : function (file, bytesLoaded)
		{
			try
			{
				var percent = parseInt(bytesLoaded*100/file.size);
				if(percent < 100)
				{
					$('#'+this.customSettings.upload_msg).html(percent.toString()+'%');
				}
				else
				{
					$('#'+this.customSettings.upload_msg).html('&nbsp;');
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadSuccess" : function (file, serverData)
		{
			try
			{
				var data = null;
				try{
					data = $.parseJSON(serverData);
				}
				catch(e)
				{}
				finally{
					if(data){
						var c = $("<div class=\"thumbuper pull-left\"></div>");
						c.html('<div class="thumbnail"><a href="javascript:;" onclick="javascript:$.removeUploadedImage(this);" class="second label""><em class="icon-remove"></em></a><div class="boot"><img src="'+data.thumb+'"/><input type="hidden" name="args['+this.customSettings.upload_button+'][]" value="'+data.thumb+'"/></div></div>');
						$('#'+this.customSettings.upload_range).append(c);
						$('#'+this.customSettings.upload_target).attr('src','app/core/styles/images/none.gif');
					}
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadComplete" : function (file)
		{
			try {
				if (this.getStats().files_queued > 0) {
					this.startUpload();
				}
				else
				$('#'+this.customSettings.upload_msg).html('所有图片上传完成');
			} catch (ex) {
				this.debug(ex);
			}
		},
		"uploadError" : function (file, errorCode, message)
		{
			try
			{
				switch(errorCode)
				{
					default:
					$('#'+this.customSettings.upload_msg).html('上传任务取消');
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"cancelQueue" : function (instance)
		{
			instance.stopUpload();
			var stats;
			do{
				stats = instance.getStats();
				instance.cancelUpload();
			} while (stats.files_queued !== 0);
		}
	},
	thumbexec : {
		"fileQueueError" : function (file, errorCode, message)
		{
			try{
				var msg = '';
				switch (errorCode) {
				case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
					msg = "您只能选择一个文件";
				break;
				case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
					msg = "文件超出限制大小！";
				break;
				case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
					msg = "空文件，请重新上传！";
				break;
				case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
					msg = "不支持的文件类型！";
				break;
				default:
					msg = "未知错误！";
				}
				$('#'+this.customSettings.upload_target).attr('src','app/core/styles/images/none.gif');
				$('#'+this.customSettings.upload_msg).html(msg);

			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"fileDialogStart" : function()
		{
			$('#'+this.customSettings.upload_msg).html('请选择要上传的文件，只能选择一个');
		},
		"fileDialogComplete" : function (numFilesSelected, numFilesQueued)
		{
			try
			{
				if (numFilesQueued == 1)
				{
					$('#'+this.customSettings.upload_msg).html("&nbsp;");
					$('#'+this.customSettings.upload_target).attr('src',"app/core/styles/images/loader.gif");
					this.startUpload();
				}
				else if(numFilesQueued > 1)
				{
					swfuexec.cancelQueue(this);
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadProgress" : function (file, bytesLoaded)
		{
			try
			{
				var percent = parseInt(bytesLoaded*100/file.size);
				if(percent < 100)
				{
					$('#'+this.customSettings.upload_msg).html(percent.toString()+'%');
				}
				else
				{
					$('#'+this.customSettings.upload_msg).html('&nbsp;');
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadSuccess" : function (file, serverData)
		{
			try
			{
				var data = null;
				try{
					data = $.parseJSON(serverData);
				}
				catch(e)
				{}
				finally{
					if(data){
						$('#'+this.customSettings.upload_target).attr('src',data.thumb);
						$('#'+this.customSettings.upload_value).val(data.thumb);
						$('#'+this.customSettings.upload_msg).html('&nbsp;');
					}
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadComplete" : function (file)
		{
			try
			{
				$('#'+this.customSettings.upload_msg).html('&nbsp;');
			} catch (ex) {
				this.debug(ex);
			}
		},
		"uploadError" : function (file, errorCode, message)
		{
			try
			{
				$('#'+this.customSettings.upload_msg).html(message);
			}
			catch (ex)
			{
				alert(ex);
				this.debug(ex);
			}
		}
	},
	upfile : {
		"fileQueueError" : function (file, errorCode, message)
		{
			try{
				var msg = '';
				switch (errorCode) {
				case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
					msg = "您只能选择一个文件";
				break;
				case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
					msg = "文件超出限制大小！";
				break;
				case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
					msg = "空文件，请重新上传！";
				break;
				case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
					msg = "不支持的文件类型！";
				break;
				default:
					msg = "未知错误！";
				}
				$('#'+this.customSettings.upload_target).attr('src','app/core/styles/images/none.gif');
				$('#'+this.customSettings.upload_msg).html(msg);

			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"fileDialogStart" : function()
		{
			$('#'+this.customSettings.upload_msg).html('请选择要上传的文件，只能选择一个');
		},
		"fileDialogComplete" : function (numFilesSelected, numFilesQueued)
		{
			try
			{
				if (numFilesQueued == 1)
				{
					this.startUpload();
				}
				else if(numFilesQueued > 1)
				{
					swfuexec.cancelQueue(this);
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadProgress" : function (file, bytesLoaded)
		{
			try
			{
				var percent = parseInt(bytesLoaded*100/file.size);
				if(percent < 100)
				{
					$('#'+this.customSettings.upload_msg).html(percent.toString()+'%');
				}
				else
				{
					$('#'+this.customSettings.upload_msg).html('0.00%');
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadSuccess" : function (file, serverData)
		{
			try
			{
				var data = null;
				try{
					data = $.parseJSON(serverData);
				}
				catch(e)
				{}
				finally{
					if(data){
						$('#'+this.customSettings.upload_value).val(data.thumb);
						$('#'+this.customSettings.upload_msg).html('100%');
					}
				}
			}
			catch (ex)
			{
				this.debug(ex);
			}
		},
		"uploadComplete" : function (file)
		{
			try
			{
				$('#'+this.customSettings.upload_msg).html('&nbsp;');
			} catch (ex) {
				this.debug(ex);
			}
		},
		"uploadError" : function (file, errorCode, message)
		{
			try
			{
				$('#'+this.customSettings.upload_msg).html(message);
			}
			catch (ex)
			{
				alert(ex);
				this.debug(ex);
			}
		}
	}
});

function xvars(x){
	var _this = this;
	String.prototype.replaceAll  = function(s1,s2){
		return this.replace(new RegExp(s1,"gm"),s2);
	}

	var ginkgo = function(x){
		//return core(/^[\s|\S]+$/gi,x);
		return core(/(.)*$/gi,x);
	}

	var price = function(x){
		return core(/\d+\.*\d*$/gi,x);
	}

	var datatable = function(x){
		return core(/(\w)+/gi,x);
	}

	var keyword = function(x){
		x.value = x.value.replaceAll('，',',');
		return core(/^[\s|\S]+$/gi,x);
	}

	var english = function(x){
		return core(/^[a-z]+$/gi,x);
	}

	var userid = function(x){
		return core(/^[0-9]+$/gi,x);
	}

	var exp = function(x){
		return core(eval(x.getAttribute('exp')),x);
	}

	var qq = function(x){
		return core(/^\d{5,12}$/gi,x);
	}

	var date = function(x){
		return core(/^\d{4}-\d{1,2}-\d{1,2}$/gi,x);
	}

	var datetime = function(x){
		return core(/^\d{4}-\d{1,2}-\d{1,2}\s\d+:\d+:\d+$/gi,x);
	}

	var telphone = function(x){
		return core(/^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/gi,x);
	}

	var cellphone = function(x){
		return core(/^((\(\d{3}\))|(\d{3}\-))?13[0-9]\d{8}?$|15[89]\d{8}?$/gi,x);
	}

	var url = function(x){
		return core(/^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/gi,x);
	}

	var userName = function(x){
		return core(/^[\u0391-\uFFE5|\w]{2,40}$/gi,x);
	}

	var title = function(x){
		return _this.core(/^[\u0391-\uFFE5|\w|\s|-]+$/gi,x);
	}

	var password = function(x){
		return core(/^[\s|\S]{6,}$/gi,x);
	}

	var zipcode = function(x){
		return core(/^[1-9]\d{5}$/gi,x);
	}

	var email = function(x){
		return core(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/gi,x);
	}

	var randcode = function(x){
		return core(/^\d{4}$/gi,x);
	}

	var template = function(x){
		return core(/^\w+$/gi,x);
	}

	var category = function(x){
		return core(/^,[\d|,]+$/gi,x);
	}

	var relation = function(x){
		return core(/^[\d|,|-]+$/gi,x);
	}

	var number = function(x){
		return core(/^\d+$/gi,x);
	}

	var nature = function(x){
		return core(/^[1-9]{1}[0-9]?$/gi,x);
	}
	var core = function(exp,x)
	{
		var maxsize = parseInt(x.attr('max'));
		var minsize = parseInt(x.attr('min'));
		var needle = x.attr('needle');
		if( x.attr('type')!='password' && x.val())x.val(x.val().replace(/^\s+/i,'').replace(/\s+$/i,''));
		if(x.get(0).tagName.toUpperCase() == "SELECT"){
			if(needle && x.val() == ""){
				return {result:false,message:x.attr('msg')};
			}
		}

		if(x.attr('maxvalue'))
		{
			var maxv = parseInt(x.attr('maxvalue'));
			if(parseInt(x.val()) > maxv)return {result:false,message:"最大值不能超过"+x.attr('maxvalue')};
		}

		if(x.attr('minvalue'))
		{
			var minv = parseInt(x.attr('minvalue'));
			if(parseInt(x.val()) < minv)return {result:false,message:"最小值不能低于"+x.attr('minvalue')};
		}

		if(x.attr('type')=='checkbox'){
			if(needle && !x.attr('checked')){
				return {result:false,message:x.attr('msg')};
			}
		}
		else{
			if(!needle && x.val() == '')return {result:true};
		}
		if(needle && (x.val() == '' || !x.val()))
		return {result:false,message:x.attr('msg')};
		if(x.attr('equ') && x.attr('equ')!='')
		{
			if(x.val() != $('#'+x.attr('equ')).val())
			{
				return {result:false,message:x.attr('msg')};
			}
		}
		if(maxsize > 0 && x.val().length > maxsize)return {result:false,message:x.attr('msg')};
		if(minsize > 0 && x.val().length < minsize)return {result:false,message:x.attr('msg')};
		try{
			if(x.val().match(exp))return {result:true};
			else return {result:false,message:x.attr('msg')};
		}
		catch(e){
			return false;
		}
	}

	var checkvars = function(x)
	{
		if(x.attr('ajax') == 'get' || x.attr('ajax') == 'post'){
			var d = eval("({'"+x.attr('name')+"':'"+x.val()+"'})");
			var url = x.attr('url');
			var data = $.ajax({
				'url':url,
				async: false,
				'data':d
			}).responseText;
			if(data != '1')return {result:false,message:data};
		}
		try{
			if(x.attr('datatype') && x.attr('datatype') != "")
			{
				var method = eval(x.attr('datatype'));
				return method(x);
			}
			else
			return ginkgo(x);
		}
		catch(e){
			return ginkgo(x);
		}
	}
	return checkvars(x);
}

function submitAjax(parms){
	if(!parms.query)parms.query = "";
	parms.query += "&userhash="+Math.random();
	if(parms['action-before'])eval(parms['action-before'])();
	$.ajax({"url":parms.url,
		"type":"post",
		"data":parms.query,
		"success":function(data){
			var tmp = null;
			try{
				tmp = $.parseJSON(data);
			}
			catch(e)
			{}
			finally{
				if(tmp){
					data = tmp;
					$.zoombox.hide();
					if(parseInt(data.statusCode) == 200){
						$.loginbox.hide();
						if(data.message)
						$.zoombox.show('ajaxOK',data);
						setTimeout(function(){if(data.callbackType == 'forward'){
								if(data.forwardUrl && data.forwardUrl != '')
								{
									if(data.forwardUrl == 'reload')
									window.location.reload();
									else if(data.forwardUrl == 'back')
									{
										window.history.back();
										window.location.reload();
									}
									else
									window.location.href = data.forwardUrl;
								}
							}
							else{
								if(data.forwardUrl && data.forwardUrl != '')
								{
									$.zoombox.hide();
									submitAjax({'url': data.forwardUrl,'target' : parms.target});
								}
								else $.zoombox.hide();
							}
						},1000);
					}else if(parseInt(data.statusCode) == 201){
						if(data.callbackType == 'forward'){
							if(data.forwardUrl && data.forwardUrl != '')
							{
								if(data.loadJs)
								{
									var tjs = data.loadJs;
									var num = tjs.length - 1;
									for(i=0;i<=num;i++)
									{
										if(i == num)
										$.getScript(tjs[i], function()
										{
											if(data.forwardUrl == 'reload')
											window.location.reload();
											else if(data.forwardUrl == 'back')
											{
												window.history.back();
												window.location.reload();
											}
											else
											window.location.href = data.forwardUrl;
										});
										else
										$.getScript(tjs[i]);
									}
								}
								else
								{
									if(data.forwardUrl == 'reload')
									window.location.reload();
									else if(data.forwardUrl == 'back')
									{
										window.history.back();
										//window.location.reload();
									}
									else
									window.location.href = data.forwardUrl;
								}
							}
						}
						else{
							if(data.forwardUrl && data.forwardUrl != '')
							{
								$.zoombox.hide();
								submitAjax({'url': data.forwardUrl,'target' : parms.target});
							}
							else window.location.reload();
						}
					}else if(parseInt(data.statusCode) == 300){
						$.loginbox.hide();
						$.zoombox.show('ajax',data);
					}else if(parseInt(data.statusCode) == 301){
						$.loginbox.show();
					}
					else{
						$.zoombox.show('ajax',data);
					}
				}
				else
				{
					if(data && data.substring(0,6) != 'error:')
					if(parms.target)
					{
						$('#'+parms.target).html(data);
						var dom = document.getElementById(parms.target);
						$(".autoloaditem",dom).each(function(){$(this).load($(this).attr('autoload')+"&current="+$(this).attr('current'));});
						$("a.ajax",dom).each(htmlajax);
						$(".uploadbutton",dom).each(flashupload);
						$('.sortable',dom).sortable();
						$("form",dom).on('submit',formsubmit);
						$("select.combox",dom).on("change",combox);
						$(":input",dom).attr("autocomplete","off");
						$(":input",dom).on("blur",inputBlur);
						$("select.autocombox",dom).on("change",autocombox);
						$(":checkbox.checkall",dom).on("change",checkAll);
						$('.datetimepicker',dom).each(initdatepicker);
						$(".selfmodal",dom).on("click",modalAjax);
						$("a.confirm",dom).each(confirmDialog);
						$(".jckeditor",dom).each(initEditor);
					}
				}
				return data.statusCode;
			}
		}
	});
}

function flashupload(){
	if($(this).attr('id') && $(this).attr('id') != '')
	{
		var exectype = $.swfuexec;
		if($(this).attr('exectype') == 'thumb')
		exectype = $.thumbexec;
		else if($(this).attr('exectype') == 'upfile')
		exectype = $.upfile;
		var swfsetting = {};
		swfsetting.flash_url = "app/core/styles/js/swfu/swfupload.swf";
		swfsetting.upload_url = "index.php?document-api-swfupload";
		if($(this).attr('filesize'))swfsetting.file_types = $(this).attr('filesize');
		else
		swfsetting.file_size_limit = "2 MB";
		if($(this).attr('uptypes'))swfsetting.file_types = $(this).attr('uptypes');
		else
		swfsetting.file_types = "*.jpg;*.gif;*.png;*.bmp";
		swfsetting.file_types_description = "上传附件";
		swfsetting.file_upload_limit =  0;
		swfsetting.file_queue_limit =  0;
		swfsetting.button_width =  "16";
		swfsetting.button_height = "16";
		swfsetting.button_text_left_padding = 0;
		swfsetting.button_cursor =  SWFUpload.CURSOR.HAND;
		swfsetting.button_text_top_padding = 0;
		swfsetting.button_window_mode = SWFUpload.WINDOW_MODE.TRANSPARENT;
		swfsetting.debug = false;
		swfsetting.button_image_url = "app/core/styles/images/uploadico.png";
		swfsetting.debug = false;
		swfsetting.post_params = {
			"exam_psid":$.cookie('exam_psid'),
			"exam_currentuser" : $.cookie("exam_currentuser"),
			"imgwidth":($(this).attr("imgwidth") && $(this).attr("imgwidth") != '')? $(this).attr("imgwidth"):0,
			"imgheight":($(this).attr("imgheight") && $(this).attr("imgheight") != '')? $(this).attr("imgheight"):0
		};
		swfsetting.file_queue_error_handler = exectype.fileQueueError;
		swfsetting.file_dialog_complete_handler = exectype.fileDialogComplete;
		swfsetting.upload_progress_handler = exectype.uploadProgress;
		swfsetting.upload_error_handler = exectype.uploadError;
		swfsetting.upload_success_handler = exectype.uploadSuccess;
		swfsetting.upload_complete_handler = exectype.uploadComplete;
		swfsetting.button_placeholder_id = $(this).attr('id');
		swfsetting.custom_settings = {
			upload_button : $(this).attr('id'),
			upload_value : $(this).attr('id')+'_value',
			upload_target : $(this).attr('id')+'_view',
			upload_msg : $(this).attr('id')+'_percent',
			upload_range : $(this).attr('id')+'_range'
		};
		new SWFUpload(swfsetting);
	}
}

function combox(){
	var _this = this;
	if($(_this).attr("target") && ($(_this).attr("target") != "")){
		var url = $(_this).attr("refUrl").replace(/{value}/,$(_this).val());
		if($(_this).attr('valuefrom') && ($(_this).attr('valuefrom') != "")){
			var t = $(_this).attr('valuefrom').split("|");
			for(i=0;i<t.length;i++)
			url = url.replace(eval("/{"+t[i]+"}/gi"),$('#'+t[i]).val());
		}
		submitAjax({'url':url,'target':$(_this).attr("target")});
		if($(_this).attr("callback") && $(_this).attr("callback") != "")
		eval($(_this).attr("callback"))($(_this));
	}
}

function autocombox(){
	var _this = this;
	var url = $(_this).attr("refUrl").replace(/{value}/,$(_this).val());
	var step = $(_this).attr("step");
	if(!step || step == "")step = 0;
	else step = parseInt(step);
	if($(_this).attr('valuefrom') && ($(_this).attr('valuefrom') != "")){
		var t = $(_this).attr('valuefrom').split("|");
		for(i=0;i<t.length;i++)
		url = url.replace(eval("/{"+t[i]+"}/gi"),$('#'+t[i]).val());
	}
	$.get(url+'&rand='+Math.random(),function(dt){
		if(dt.statusCode == '200')
		{
			var d = dt.html;
			$('select[rel="'+$(_this).attr('name')+'_auto_rel"]').each(function(){if($(this).attr('step') && $(this).attr('step') != '' && parseInt($(this).attr('step')) > step)$(this).remove();});
			var o = $('<select order="'+$(_this).attr('order')+'" class="input-medium" rel="'+$(_this).attr('name')+'_auto_rel'+'" step="'+(step+1)+'" id="'+$(_this).attr('name')+'_auto_'+(step+1)+'" valuefrom="'+$(_this).attr("valuefrom")+'" refUrl="'+$(_this).attr("refUrl")+'" name="'+$(_this).attr('name')+'" needle="needle" msg="您必须要选择一项"><option value="">请选择</option>'+d+'</select>');
			if($(_this).attr('order') == '1')
			$(_this).before(o);
			else
			$(_this).after(o);
			o.focus();
			o.on("blur",inputBlur);
			o.on("change",autocombox);
      	}
      	else
      	{
      		$('select[rel="'+$(_this).attr('name')+'_auto_rel"]').each(function(){if($(this).attr('step') && $(this).attr('step') != '' && parseInt($(this).attr('step')) > step)$(this).remove();});
      	}
	},'json');
	if($(_this).attr("callback") && $(_this).attr("callback") != "")
	eval($(_this).attr("callback"))($(_this));
}

function htmlajax(obj){
	var _this = this;
	var target = $(_this).attr('target');
	var callback = $(_this).attr('callback');
	$(_this).attr('target','_self');
	var href = $(_this).attr('href');
	$(_this).attr('href','javascript:;');
	$(_this).attr('data',href);
	$(_this).click(function(){
		var status = submitAjax({"url":href,"target":target,'action-before':$(_this).attr('action-before')});
		return false;
	});
}

function inputBlur(){
	var _this = this;
	var data = xvars($(_this));
	if(!data.result){
		$(_this).parents(".control-group").addClass("error");
	}else{
		$(_this).parents(".control-group").removeClass("error");
	}
}

function checkAll(){
	var _this = this;
	$(_this).parents('table:first').find('input').prop('checked', $(_this).is(':checked'));
}

function formsubmit(){
	var _this = this;
	var status = false;
	var query;
	var target = $(_this).attr('direct');
	if(!target || target == '')target = 'datacontent';
	for ( instance in CKEDITOR.instances )
	CKEDITOR.instances[instance].updateElement();
	query = $(":input",_this).serialize()+'&userhash='+Math.random();
	$(":input",_this).not('.ckeditor').each(function(){
		var _this = this;
		var data = xvars($(this));
		if(!data.result && !status){
			$(_this).parents(".control-group").addClass("error");
			$.zoombox.show('ajax',data);
			status = true;
		}
	});
	if(status)return false;
	if(!$(_this).attr('action') || $(_this).attr('action') == '')return false;
	if($(_this).attr('btnact') == 'on'){
		$("input:submit",_this).attr('disabled','true');
		$("input:submit",_this).attr('value','正在提交……');
	};
	submitAjax({"url":$(_this).attr('action'),"query":query,"target":target,'action-before':$(_this).attr('action-before')});
	return false;
}

function modalAjax(){
	var m = $($(this).attr('data-target'));
	var url = $(this).attr('url');
	if($(this).attr('valuefrom') && ($(this).attr('valuefrom') != "")){
		var t = $(this).attr('valuefrom').split("|");
		for(i=0;i<t.length;i++)
		url = url.replace(eval("/{"+t[i]+"}/gi"),$('#'+t[i]).val());
	}
	$.get(url+'&'+Math.random(),function(data){
		var c = m.children(".modal-body");
		c.html(data);
		c.find(".autoloaditem").each(function(){$(this).load($(this).attr('autoload')+"&current="+$(this).attr('current'));});
		c.find("a.ajax").each(htmlajax);
		c.find(".uploadbutton").each(flashupload);
		c.find('.sortable').sortable();
		c.find("form").on('submit',formsubmit);
		c.find("select.combox").on("change",combox);
		c.find(":input").attr("autocomplete","off");
		c.find(":input").on("blur",inputBlur);
		c.find("select.autocombox").on("change",autocombox);
		c.find(":checkbox.checkall").on("change",checkAll);
		c.find('.datepicker').each(initdatepicker);
		c.find(".selfmodal").on("click",modalAjax);
		c.find(".jckeditor").each(initEditor);
		c.find("a.confirm").each(confirmDialog);
		m.modal();
	})
}

function initEditor(){
	var _this = this;
	if($(this).attr('etype') == 'simple')
	{
		var config = {
			toolbar:
			[
				['Bold', 'Italic', '-', 'NumberedList', 'BulletedList'],
				['Superscript','Subscript','JustifyLeft','JustifyCenter','JustifyRight'],
				['Table','HorizontalRule','SpecialChar']
			]
		};
		CKEDITOR.replace(_this,config).on("blur", function () {
	        var _ = this;
	        var p=[];
			p.push(_.element.$.attributes.name.value);
			p.push(_.getData());
			p.push(Date.parse(new Date())/1000);
			$('#time_'+$(_this).attr('rel')).val(Date.parse(new Date())/1000);
			set.apply(formData,p);
	        batmark(_.element.$.attributes.rel.value,_.getData());
	    });
	}
	else
	CKEDITOR.replace(_this);
}

countdown = function(userOptions)
{
	var h,m,s,t;
	var init = function()
	{
		userOptions.time = userOptions.time*60 - userOptions.lefttime;
		s = userOptions.time%60;
		m = parseInt(userOptions.time%3600/60);
		h = parseInt(userOptions.time/3600);
	}

	var setval = function()
	{
		if(s >= 10)
		userOptions.sbox.html(s);
		else
		userOptions.sbox.html('0'+s.toString());
		if(m >= 10)
		userOptions.mbox.html(m);
		else
		userOptions.mbox.html('0'+ m);
		if(h >= 10)
		userOptions.hbox.html(h);
		else
		userOptions.hbox.html('0'+ h);
	}

	var step = function()
	{
		if(s > 0)
		{
			s--;
		}
		else
		{
			if(m > 0)
			{
				m--;
				s = 60;
				s--;
			}
			else
			{
				if(h > 0)
				{
					h--;
					m = 60;
					m--;
					s = 60;
					s--;
				}
				else
				{
					clearInterval(interval);
					userOptions.finish();
					return ;
				}
			}
		}
		setval();
	}
	init();
	interval = setInterval(step, 1000);
};

function confirmDialog(){
	var _this = this;
	var href = $(_this).attr('href');
	$(_this).attr('href','javascript:;')
	$(_this).on('click',function(){$.zoombox.show('confirm',_this,href);});
}

function initdatepicker(){
	var _this = this;
	var minview = $(_this).attr('data-minview');
	$(_this).datetimepicker({"language":'zh-CN',"autoclose": 1,"minView":$(_this).attr('data-minview')?$(_this).attr('data-minview'):2});
}

$(function(){
	$(".autoloaditem").each(function(){$(this).load($(this).attr('autoload')+"&current="+$(this).attr('current'));});
	$(".uploadbutton").each(flashupload);
	$(".jckeditor").each(initEditor);
	$(".randCode").on('click',function(){
		$(this).attr('src',$(this).attr('src')+'&'+Math.random());
	});
	$('.datetimepicker').each(initdatepicker);
	$(".randCode").each(function(){$(this).attr('src',$(this).attr('src')+'&'+Math.random());})
	$('.sortable').sortable();
	$('.sortable').disableSelection();
	$("form").on('submit',formsubmit);
	$("a.ajax").each(htmlajax);
	$("select.combox").on("change",combox);
	$(":input").attr("autocomplete","off");
	$(":input").on("blur",inputBlur);
	$("select.autocombox").on("change",autocombox);
	$(":checkbox.checkall").on("change",checkAll);
	$(".selfmodal").on("click",modalAjax);
	$("a.catool").each(function(){openmenu(this);});
	$("a.confirm").each(confirmDialog);
	$('a.poproom').popover();
});

function openmenu(_this){
	if($(_this).attr("data") != '1')
	{
		if($(_this).attr("app"))
		var app = $(_this).attr("app");
		else
		var app = 'content';
		var o = $(_this).parents("tr");
		var t = '';
		$.getJSON('index.php?'+app+'-master-category-ajax-getchilddata&'+Math.random(),{'catid':$(_this).attr('rel')},function(data){
			for(x in data){
				var s = $('<tr>'+o.html()+'<tr />');
				s.children("td").eq(0).children("input").eq(0).attr('name','ids['+data[x].catid+']');
				s.children("td").eq(0).children("input").eq(0).attr('value',data[x].catlite);
				s.children("td").eq(1).html(data[x].catid);
				s.children("td").eq(2).children('img').eq(0).attr('src',data[x].catimg == ''?'app/core/styles/images/noupload.gif':data[x].catimg);
				s.children("td").eq(3).children('a').eq(0).attr('rel',data[x].catid);
				s.children("td").eq(3).children('span').eq(0).html(data[x].catname);
				s.children("td").eq(3).html('<em class="span1"></em>'+s.children("td").eq(3).html());
				s.children("td").eq(4).html(s.children("td").eq(4).html().replaceAll('catid='+$(_this).attr('rel'),'catid='+data[x].catid).replaceAll('parent='+$(_this).attr('rel'),'parent='+data[x].catid));
				s.children("td").eq(4).find("a.ajax").each(function(){
					var _this = this;
					var d = $(_this).attr('data');
					$(_this).attr('href',d);
					$(_this).attr('data',null);
				});
				t = t+'<tr class="submenu'+$(_this).attr('rel')+'">'+s.html()+'<tr />';
			}
			o.after($(t));
			$('.submenu'+$(_this).attr('rel')).find("a.ajax").each(htmlajax);
			$(_this).attr("data","1");
			$(_this).attr("class","icon-minus-sign catool");
			$(_this).attr("onclick","javascript:closemenu(this);");
		});
	}
	else
	{
		$('.submenu'+$(_this).attr('rel')).show();
		$(_this).attr("class","icon-minus-sign catool");
		$(_this).attr("onclick","javascript:closemenu(this);");
	}
}

function closemenu(_this){
	if($(_this).attr('rel') && $(_this).attr('rel') != '')
	{
		var p = $('.submenu'+$(_this).attr('rel'));
		if(p)
		{
			p.each(function(){
				var x = $('.submenu'+$(this).children("td").eq(3).children("a").eq(0).attr('rel')).eq(0);
				if(x.attr('class'))
				closemenu($(this).children("td").eq(3).children("a").eq(0).get(0));
				$('.submenu'+$(_this).attr('rel')).hide();
			});
		}
		$(_this).attr("class","icon-plus-sign catool");
		$(_this).attr("onclick","javascript:openmenu(this);");
	}
}