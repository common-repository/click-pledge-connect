var getUrlParameter = function getUrlParameter(sParam) {
	var sPageURL = window.location.search.substring(1),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
		}
	}
};
if (typeof jQuery === 'undefined') { var alertDiv = '<div id="jqueryAlert" style=\"color:#333; background:rgb(250, 247, 200); padding:5px; border:1px solid #ccc;position:fixed;top: 0;left: 0;float: left;z-index: 999999;text-align:center; box-shadow:0px 2px 3px -2px #333; width:100%; font-family:arial;\">The Click &amp; Pledge Connect form library will not work on this page since the latest JQuery library is missing. Read  <a href="#" target="_blank">more</a>.</div>'; document.write(alertDiv) }
function getInternetExplorerVersion() {
	var rv = -1; if (navigator.appName == 'Microsoft Internet Explorer') { var ua = navigator.userAgent; var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})"); if (re.exec(ua) != null) { rv = parseFloat(RegExp.$1) } }
	return rv
}
function checkVersion() {
	var msg = "You're not using Internet Explorer."; var ver = getInternetExplorerVersion(); if (ver > -1) {
		if (ver >= 10.0) { }
		else { var alertDiv = '<div id="jqueryAlert" style=\"color:#333; background:rgb(250, 247, 200); padding:5px; border:1px solid #ccc;position:fixed;top: 0;left: 0;float: left;z-index: 999999;text-align:center; box-shadow:0px 2px 3px -2px #333; width:100%; font-family:arial;\">The Click &amp; Pledge Connect form library need higher version of the browser you are using.</div>'; document.write(alertDiv) }
	}
}
checkVersion();
(function ($) {
	if (getUrlParameter('cp_gtm') == 1) {
		console.log('Thank You for using GTM URL Parameter');
		var cp_gtmForceLayer = '<script id="cp_gtmForce">var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";var eventer = window[eventMethod];var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";/* Listen to message from child window*/eventer(messageEvent,function(e) {var key = e.message ? "message" : "data";var data = e[key];/*run function*/for(var i=0; i<data.length; i++){if(data[i] == "cp_gtm"){localStorage.setItem("cp_gtm",data);/*DataLayer Starts here*/var tID = data[1];var tAff = data[2];var tTot = data[3];var tTax = data[4];var tShip = data[5];var tProd = data[0];window.dataLayer = window.dataLayer || [];window.dataLayer.push({"event":"iframeload","transactionId": tID,"transactionAffiliation": tAff,"transactionTotal": tTot,"transactionTax": tTax,"transactionShipping": tShip,"transactionProducts": tProd});(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src="https://www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);})(window,document,"script","dataLayer",data[6]);}}},false);</script>';

		$('head').append(cp_gtmForceLayer);
	}

	var guid;
	var oguid;
	$(document).ready(function () {
		var uP = window.location.protocol;
		var u = window.location.hostname;
		var uri = uP + '//' + u;
		localStorage.clear();
		i = 0;
		if ($(".CnP_formloader").attr('data-guid') != null) {
			guid = $(".CnP_formloader").attr('data-guid');
			var ifstyle = "<style>#CnP_inlineiframe{width: 1px;min-width: 100%;border:none;}</style>";
			//var inlineHtml="<iframe id=\"CnP_inlineiframe\" src=\"//dev.connect.clickandpledge.biz:4434/w/Form/"+guid+"\" width=\"100%\" onload=\"iFrameResize({log:false,checkOrigin:'*'});\" scrolling=\"no\"></iframe>";
			var inlineHtml = "<iframe id=\"CnP_inlineiframe\" src=\"//connect.clickandpledge.com/w/Form/" + guid + "\" width=\"100%\" onload=\"iFrameResize({log:false,checkOrigin:'*'});\" scrolling=\"no\"></iframe>";
			var lib = '<script src=\"//resources.connect.clickandpledge.com/Library/iframeResizer.min.js\"></script>';
			$('head').append('<meta http-equiv="X-UA-Compatible" content="IE=edge">');
			//$("#CnP_inlineform").append(ifstyle+inlineHtml+lib);
			$("#CnP_inlineform").append(ifstyle + inlineHtml + lib);
			// Force GTM code

			//$("#CnP_inlineform").append();
			//$("#CnP_inlineiframe").on('load',function(){});
		}
		if ($(".CnP_inlineform").attr('data-guid') != null) {
			var C = $(".CnP_inlineform");
			var Ccount = C.length;
			console.log(Ccount);
			for (i = 0; i < Ccount; i++) {
				var g = $(C[i]).attr('data-guid');

				var ifstyleMulti = '<style>#CnP_inlineiframe' + i + '{width: 1px;min-width: 100%;border:none;}</style>';
				//var inlineHtml="<iframe id=\"CnP_inlineiframe\" src=\"//dev.connect.clickandpledge.biz:4434/w/Form/"+guid+"\" width=\"100%\" onload=\"iFrameResize({log:false,checkOrigin:'*'});\" scrolling=\"no\"></iframe>";
				var inlineHtmlMulti = '<iframe id=\"CnP_inlineiframe' + i + '\" src=\"//connect.clickandpledge.com/w/Form/' + g + '\" width=\"100%\" onload=\"iFrameResize({log:false,checkOrigin:\'\*\'});\" scrolling=\"no\"></iframe>';
				var libMulti = '<script src=\"//resources.connect.clickandpledge.com/Library/iframeResizer.min.js\"></script>';
				$('head').append('<meta http-equiv="X-UA-Compatible" content="IE=edge">');
				//$("#CnP_inlineform").append(ifstyle+inlineHtml+lib);
				$('head').append(libMulti);
				$(C[i]).append(ifstyleMulti + inlineHtmlMulti);

			}
		}
		if ($(".CnP_formlink").attr('data-guid') != null) {
			$(".CnP_formlink").each(function (index, element) {
				i++; $(this).addClass('CnP_loader' + i); guid = $(this).attr('data-guid'); $(this).css('cursor', 'pointer');
				var Html = '<style>'; Html += 'div[id*=\"CnP_container_\"]{display:none;overflow-x: hidden;overflow-y: auto;position: fixed;top: 0;right: 0;bottom: 0;left: 0; z-index:9999;-webkit-overflow-scrolling: touch;max-height:none;}'; Html += 'div[id*=\"CnP_head_\"]{width: 100%;text-align: right;position: absolute;z-index: 99999;}'; Html += '.CnP_close{color:#eee;font-family:verdana;border-radius:3px;background:#333;padding:10px 20px 10px 10px;top:5px;position:relative;border:1px solid #000;font-weight:400; font-size:18px !important;margin-top:10px !important;}'; Html += 'iframe[id*=\"CnP_iframe_\"]{width:100%; height:100%; position:fixed;}'; Html += '@media only screen and (-webkit-min-device-pixel-ratio: 2) {iframe[id*=\"CnP_iframe_\"]{position:relative;}}'; Html += '</style>'; Html += '<div id=\"CnP_container_' + i + '\" class=\"CnP_container\">'; Html += '<div id=\"CnP_head_' + i + '\">'; Html += '<button type=\"button\" class=\"CnP_close\" title="Close">CLOSE X</button>'; Html += '</div>'; Html += '<iframe id=\"CnP_iframe_' + i + '\" class=\"CnP_iframe\" src=\"//connect.clickandpledge.com/w/Form/' + guid + '"></iframe>'; Html += '</div>'; var loader = '<style>#loading{background-color:transparent;height:100%;width:100%;position:fixed;z-index:9999;margin-top:0px;top:0px;}\
			#loading_center{width:100%;height:100%;position:relative;}\
			#loading_center_absolute{position:absolute;left:50%;top:50%;height:200px;width:200px;margin-top:-100px;margin-left:-100px;}\
			#object{width:80px;height:80px;background-color:#4285f4;-webkit-animation:animate 1s infinite ease-in-out;animation:animate 1s infinite ease-in-out;margin-right:auto;margin-left:auto;margin-top:60px;}@-webkit-keyframes animate{0%{-webkit-transform:perspective(160px);}50%{-webkit-transform:perspective(160px)rotateY(-180deg);}100%{-webkit-transform:perspective(160px)rotateY(-180deg)rotateX(-180deg);}}@keyframes animate{0%{transform:perspective(160px)rotateX(0deg)rotateY(0deg);-webkit-transform:perspective(160px)rotateX(0deg)rotateY(0deg);}50%{transform:perspective(160px)rotateX(-180deg)rotateY(0deg);-webkit-transform:perspective(160px)rotateX(-180deg)rotateY(0deg);}100%{transform:perspective(160px)rotateX(-180deg)rotateY(-180deg);-webkit-transform:perspective(160px)rotateX(-180deg)rotateY(-180deg);}}</style>\
			<div id=\"loading\" style="display:none;">\
			<div id=\"loading_center\">\
			<div id=\"loading_center_absolute\"><div id=\"object\"></div></div>\
			</div>\
			</div>'
				$(this).on('click', function () { localStorage.setItem('u', window.location.href); guid = $(this).attr('data-guid'); $('body').append(Html); $('body').find(".CnP_container:last").show(); $('body').find(".CnP_close").on('click', function () { $('body').find(".CnP_container:last").remove(); window.location.href = localStorage.getItem('u'); $('body').css('position', '') }); $('body').css('position', 'fixed').css('width', '100%') })
			})
		}

		// Find GTM key
		var scripts = document.getElementsByTagName("script");
		var parentGtm;

		// $('iframe').on('load', function () {
		// 	$(window).on('scroll', function () {
		// 		//alert(1);
		// 		var s = $("iframe").find('select').prop('id');
		// 		var frm = $('iframe select').prop('id');
		// 		$('iframe').blur();
		// 	});
		// });


	});

}(jQuery))


