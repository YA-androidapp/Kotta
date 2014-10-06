// http://www5.pf-x.net/~pine6/upload/referer/noreferer.js

// リファラ送らずリダイレクトする

var NoRefererRedirect = function(url){
	//@cc_on
	//@if(false)
	
	var html;
	
	if(Prototype.Browser.Opera){
		html =
			'<html><head></head><body>'+
			'<p style="display:none"><iframe></iframe></p>'+
			'<script type="text/javascript">'+
			'<!--\n'+
			'var ele = document.getElementsByTagName("iframe")[0];'+
			'ele.contentWindow.document.write("'+
				'<script type=\\"text/javascript\\">'+
				'<!--\\n'+
				'window.parent.location.href=\\"' + url + '\\";'+
				'//-->'+
				'<\\\/script>'+
			'");'+
			'//-->'+
			'<\/script><\/body><\/html>';
	} else {
		html =
			'<html><head><script type="text/javascript">'+
			'<!--\n'+
			'document.write(\'<meta http-equiv="Refresh" content="0; url=' + url + '">\');'+
			'//-->'+
			'<\/script></head><body></body></html>';
	}
	
	location.href = "data:text/html; charset=utf-8," + encodeURIComponent(html);
	return;
	
	//@end
	
	location.href = url;
};