$(function(){
	var ec = new evercookie();
	ec.get("exam_psid", function(data){
		if(!data || data.length != 32){
			ec.set('exam_psid','{x2;$sessionid}');
		}
		else
		{
			if(data != '{x2;$sessionid}')
			{
				alert(data+'|'+'{x2;$sessionid}');
				window.location.reload();
			}

		}
	});
	var uec = new evercookie();
	uec.get("exam_currentuser", function(data){
		if(!data || data == ''){
			ec.set('exam_currentuser','{x2;v:_COOKIE['exam_currentuser']}');
		}
	});
});