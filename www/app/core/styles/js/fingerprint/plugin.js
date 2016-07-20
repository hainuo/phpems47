$(function(){
	var fp = new Fingerprint();
	var finger = fp.get();
	$.getScript('index.php?core-api-finger&finger='+finger);
});