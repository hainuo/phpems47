$(function(){
	var ec = new evercookie();
	ec.get("exam_psid", function(data){
		if(!data){
			$.getScript('index.php?core-api-setsessionid');
		}
		else
		alert(data);
	});
});