jQuery(document).ready(function () {

	/*jQuery("#myHref").on('click', function () {

	});*/	
	/*jQuery(".").on('click', function (e) {
		
	});*/

	/*jQuery("#dialogForm").dialog({
		   modal: true,
		   autoOpen: false,
		   maxWidth: 600,
		   show: {effect: "blind", duration: 800}
   	
	   });
	   jQuery("#dialogForm").dialog( "option", "width", 500 );*/
	if (jQuery("#hidnoofforms").val() == 1 || jQuery("#hidnoofforms").val() == "") { jQuery("#cnpbtndelte").hide(); }

	if (jQuery("#cnphdneditaccountId").val() !== "" && typeof jQuery("#cnphdneditaccountId").val() !== "undefined") {
	var nofrms = jQuery("#hidnoofforms").val();
		var cnpfrmt = jQuery("#hdndatefrmt").val();
		var strtdt = jQuery("#hdnstrtdt").val();
		var enddt = jQuery("#hdnenddt").val();

		jQuery('#txtcnpformstrtdt').datetimepicker({ format: cnpfrmt, defaultDate: strtdt });
		jQuery('#txtcnpformenddt').datetimepicker({ format: cnpfrmt, defaultDate: enddt });
		for (var i = 1; i <= nofrms; i++) {
			var selcampaign = jQuery("#cnphdneditlstcnpactivecamp" + i).val();
			var selform = jQuery("#cnphdneditlstcnpfrmtyp" + i).val();
			getEditActiveCampaigns(i, selcampaign);

			getEditActiveForms(i, "cnphdneditlstcnpactivecamp", selform);
			jQuery('#txtcnpformstrtdt' + i).datetimepicker({ format: cnpfrmt, defaultDate: jQuery('#hdncnpformstrtdt' + i).val() });
			jQuery('#txtcnpformenddt' + i).datetimepicker({ format: cnpfrmt, defaultDate: jQuery('#hdncnpformenddt' + i).val() });
		}

	}
	if (jQuery("#cnphdneditchnlaccountId").val() !== "" && typeof jQuery("#cnphdneditchnlaccountId").val() !== "undefined") {
			var nofrms = jQuery("#hidnoofforms").val();
		var cnpfrmt = jQuery("#hdndatefrmt").val();
		var strtdt = jQuery("#hdnchnlstrtdt").val();
		var enddt = jQuery("#hdnchnlenddt").val();

		jQuery('#txtcnpchnlstrtdt').datetimepicker({ format: cnpfrmt, defaultDate: strtdt });
		jQuery('#txtcnpchnlenddt').datetimepicker({ format: cnpfrmt, defaultDate: enddt });
		for (var i = 1; i <= nofrms; i++) {
			var selcampaign = jQuery("#cnphdneditlstcnpactivecamp" + i).val();

			getEditActiveChannels(i, selcampaign);
			jQuery('#txtcnpformstrtdt' + i).datetimepicker({ format: cnpfrmt, defaultDate: jQuery('#hdncnpformstrtdt' + i).val() });
			jQuery('#txtcnpformenddt' + i).datetimepicker({ format: cnpfrmt, defaultDate: jQuery('#hdncnpformenddt' + i).val() });


		}

	}
	/************************************/

	jQuery("#lstchnlaccntfrndlynam").focus(function () {
		prev_val = jQuery(this).val();
	}).change(function () {

		if (jQuery("#cnpachnlbtnsubmit").is(":hidden")) {
			var result = confirm("Changing the account will clear all entered data. Are you sure?");
			if (result === true) {
				counter = 2;
				jQuery("#hidnoofforms").val(1);
				getDeleteChannelchangerows();
				addchannelslist(1);
			}
			else { jQuery("#lstaccntfrndlynam").val(prev_val); return false; }
		}
	});
	/************************************/
	jQuery("#lstaccntfrndlynam").focus(function () {
		prev_val = jQuery(this).val();
	}).change(function () {
		//var frndlynm = jQuery("#lstaccntfrndlynam").find(".selected").val()

		if (jQuery("#cnpbtnsubmit").is(":hidden")) {
			var result = confirm("Changing the account will clear all entered data. Are you sure?");
			if (result === true) {
				counter = 2;
				jQuery("#hidnoofforms").val(1);
				getDeleteFormchangerows();
				addcampaignlist(1);
			}
			else { jQuery("#lstaccntfrndlynam").val(prev_val); return false; }
		}
	});
	var counter = 2;
	jQuery("#lstfrmtyp").change(function () {
		if (jQuery("#lstfrmtyp option:selected").text() == "Overlay") {
			jQuery(".popuptyp").show();
			if (jQuery("#lstpopuptyp option:selected").text() != "Image" && jQuery("#lstpopuptyp option:selected").text() != "Select Link Type") {

				jQuery(".popuptyptxt").show();
				jQuery(".popuptypimg").hide();
			}
			else if (jQuery("#lstpopuptyp option:selected").text() == "Image") {
				jQuery(".popuptypimg").show();
				jQuery(".popuptyptxt").hide();
			}
		}
		else {
			jQuery(".popuptyp").hide();
			jQuery(".popuptyptxt").hide();
			jQuery(".popuptypimg").hide();
		}
	});
	jQuery("#lstpopuptyp").change(function () {

		if (jQuery("#lstpopuptyp option:selected").text() == "Button") {
			jQuery('#cnplbllink').text("Button Label*");
		}
		if (jQuery("#lstpopuptyp option:selected").text() == "Text") {
			jQuery('#cnplbllink').text("Link Label*");
		}
		if (jQuery("#lstpopuptyp option:selected").text() != "Image" && jQuery("#lstpopuptyp option:selected").text() != "Select Link Type") {
			jQuery(".popuptyptxt").show();
			jQuery(".popuptypimg").hide();
		}
		else if (jQuery("#lstpopuptyp option:selected").text() == "Image" && jQuery("#lstpopuptyp option:selected").text() != "Select Link Type") {
			jQuery(".popuptypimg").show();
			jQuery(".popuptyptxt").hide();
		}
		else if (jQuery("#lstpopuptyp option:selected").text() == "Select Link Type") {
			jQuery(".popuptyptxt").hide();
			jQuery(".popuptypimg").hide();
		}
	});

	jQuery("#lstcnpactivecamp").change(function () {
		var campaignVal = jQuery("#lstcnpactivecamp").val();
		var cnpaccountid = jQuery("#txtcnpacntid").val();
		var cnpaccountguid = jQuery("#txtcnpacntguid").val();
		var campainurl = jQuery("#cnphdnurl").val();

		jQuery.ajax({
			type: "POST",
			url: campainurl,
			data: { AccountId_val: cnpaccountid, AccountGUId_val: cnpaccountguid, CampaignId: campaignVal },
			success: function (data) {
				jQuery(".cnpformslst").show();
				jQuery("#lstcnpfrmtyp").html(data);
			}
		});
	});

	jQuery("#lstcnpditactivecamp").change(function () {
		var campaignVal = jQuery("#lstcnpditactivecamp").val();
		var form_val = jQuery("#cnphdneditaccountId").val();
		var campainurl = jQuery("#cnphdnediturl").val();

		jQuery.ajax({
			type: "POST",
			url: campainurl,
			data: { Accountidval: form_val, CampaignId: campaignVal },
			success: function (data) {
				jQuery("#lsteditcnpfrmtyp").html(data);
			}
		});
	});


	jQuery("#lstcnpfrmtyp").change(function () {
		var campaignVal = jQuery("#lstcnpfrmtyp").val();
		if (campaignVal != "") {
			jQuery(".cnpguid").show();
			jQuery(".cnplstfrmtyp").show();
			jQuery("#txtcnpguid").val(campaignVal);
			jQuery(".cnpfrmstrtdt").show();
			jQuery(".cnpfrmenddt").show();
			jQuery('#txtcnpfrmstrtdt').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			jQuery('#txtcnpfrmenddt').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			jQuery("#txtcnpfrmstrtdt").val(jQuery.datepicker.formatDate("yy-mm-dd", new Date()));
		}
	});
	jQuery("#lsteditcnpfrmtyp").change(function () {
		var campaignVal = jQuery("#lsteditcnpfrmtyp").val();
		if (campaignVal != "") {
			jQuery("#txtcnpguid").val(campaignVal);

		}

	});
	jQuery("#txtcnpfrmfrndlynm").change(function () {
		var campaignVal = jQuery("#txtcnpfrmfrndlynm").val();
		var data = { action: 'CNPCF_friendlyname', param: campaignVal };
		var ajaxurl = "admin-ajax.php";
		jQuery.post(ajaxurl, data, function (dat) {
			if (dat != 0) {
				jQuery("#spnfrndlynm").html(dat); if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', true); } jQuery("#cnpbtnaddsettings").prop('disabled', true);
			}
			else { jQuery("#spnfrndlynm").html(""); jQuery("#cnpbtnaddsettings").prop('disabled', false); if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', false); } }
		});
	});
	jQuery("#txtcnpchnlgrp").change(function () {
		var campaignVal = jQuery("#txtcnpchnlgrp").val();
		if(/^[a-zA-Z0-9 ]*$/.test(campaignVal) == true) {
		var data = { action: 'CNPCF_cnpchnlgroupname', param: campaignVal };
		var ajaxurl = "admin-ajax.php";
	
		jQuery.post(ajaxurl, data, function (dat) {
			if (dat != 0) {
				jQuery("#spncnpchnlgrpnm").html(dat);
				jQuery("#txtcnpchnlgrp").focus();
				if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', true); }
				jQuery("#cnpachnlbtnsubmit").prop('disabled', true);
			}
			else {
				jQuery("#spncnpchnlgrpnm").html("");
				jQuery("#cnpachnlbtnsubmit").prop('disabled', false);
				if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', false); }
			}
		});
		}
		else
			{
				jQuery("#spncnpchnlgrpnm").html("Enter valid characters");
				jQuery("#txtcnpchnlgrp").focus();
				jQuery("#cnpachnlbtnsubmit").prop('disabled', true);
			}
	});
	jQuery("#txtcnpchnlgrp").blur(function () {
		var campaignVal = jQuery("#txtcnpchnlgrp").val();
		if(/^[a-zA-Z0-9 ]*$/.test(campaignVal) == true) {
		var data = { action: 'CNPCF_cnpchnlgroupname', param: campaignVal };
		var ajaxurl = "admin-ajax.php";
	
		jQuery.post(ajaxurl, data, function (dat) {
			if (dat != 0) {
				jQuery("#spncnpchnlgrpnm").html(dat);
				jQuery("#txtcnpchnlgrp").focus();
				if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', true); }
				jQuery("#cnpachnlbtnsubmit").prop('disabled', true);
			}
			else {
				jQuery("#spncnpchnlgrpnm").html("");
				jQuery("#cnpachnlbtnsubmit").prop('disabled', false);
				if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', false); }
			}
		});
		}
		else
			{
				jQuery("#spncnpchnlgrpnm").html("Enter valid characters");
				jQuery("#txtcnpchnlgrp").focus();
				jQuery("#cnpachnlbtnsubmit").prop('disabled', true);
			}
	});
	jQuery("#txtcnpchnlgrp").keyup(function () {
	var campaignVal = jQuery("#txtcnpchnlgrp").val();
	if(/^[a-zA-Z0-9 ]*$/.test(campaignVal) == false) {
		jQuery("#spncnpchnlgrpnm").html("Enter valid characters");
		jQuery("#txtcnpchnlgrp").focus();
		jQuery("#cnpachnlbtnsubmit").prop('disabled', true);
	}
	else
		{
			jQuery(".cnpfrmgrp").removeClass("cnpform-invalid");
			jQuery("#spncnpchnlgrpnm").html("");
			jQuery("#cnpachnlbtnsubmit").prop('disabled', false);
		}
});
jQuery("#txtcnpfrmgrp").keyup(function () {
	var campaignVal = jQuery("#txtcnpfrmgrp").val();
	if(/^[a-zA-Z0-9 ]*$/.test(campaignVal) == false) {
		jQuery("#spncnpgrpnm").html("Enter valid characters");
		jQuery("#txtcnpfrmgrp").focus();
		jQuery("#cnpbtnsubmit").prop('disabled', true);
	}
	else
		{
			jQuery(".cnpfrmgrp").removeClass("cnpform-invalid");
			jQuery("#spncnpgrpnm").html("");
			jQuery("#cnpbtnsubmit").prop('disabled', false);
		}
});
	jQuery("#txtpopuptxt").keyup(function () {
	var campaignVal = jQuery("#txtpopuptxt").val();
	if(/^[a-zA-Z0-9 ]*$/.test(campaignVal) == false) {
		jQuery(".popuptyptxt").addClass("cnpform-invalid");
		jQuery("#cnpbtnsubmit").prop('disabled', true);
		return false;
	}
		else
			{
				jQuery(".popuptyptxt").removeClass("cnpform-invalid");
		        jQuery("#cnpbtnsubmit").prop('disabled', false);
				return true;
			}
	
});
	jQuery("#txtpopuptxt").change(function () {
	var campaignVal = jQuery("#txtpopuptxt").val();
	if(/^[a-zA-Z0-9 ]*$/.test(campaignVal) == false) {
		jQuery(".popuptyptxt").addClass("cnpform-invalid");
		return false;
	}
	else
	{
		jQuery(".popuptyptxt").removeClass("cnpform-invalid");
	    jQuery("#cnpbtnsubmit").prop('disabled', false);
		return true;
	}
	
});
	jQuery("#txtcnpfrmgrp").blur(function () {
		var campaignVal = jQuery("#txtcnpfrmgrp").val();
		if(/^[a-zA-Z0-9 ]*$/.test(campaignVal) == true) {
		var data = { action: 'CNPCF_cnpgroupname', param: campaignVal };
		var ajaxurl = "admin-ajax.php";
		jQuery.post(ajaxurl, data, function (dat) {
			if (dat != 0) {
				jQuery("#spncnpgrpnm").html(dat);
				jQuery("#txtcnpfrmgrp").focus();
				if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', true); }
				jQuery("#cnpbtnsubmit").prop('disabled', true);
			}
			else {
				jQuery("#spncnpgrpnm").html("");
				jQuery("#cnpbtnsubmit").prop('disabled', false);
				if(jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', false); }
			}
		});
	 }
		else
			{
				jQuery("#spncnpgrpnm").html("Enter valid characters");
				jQuery("#txtcnpfrmgrp").focus();
				jQuery("#cnpbtnsubmit").prop('disabled', true);
			}
	});
jQuery("#txtcnpacntguid").change(function () {
		var campaignVal1 = jQuery("#txtcnpacntguid").val();
		  
    if(campaignVal1 != "") { jQuery(".cnpacntguid").removeClass("cnpform-invalid"); }
});
	jQuery("#txtcnpacntid").change(function () {
		var campaignVal = jQuery("#txtcnpacntid").val();
		  
    if(campaignVal != "") { jQuery(".cnpaccountId").removeClass("cnpform-invalid"); }
		var data = { action: 'CNPCF_cnpaccountid', param: campaignVal };
		var ajaxurl = "admin-ajax.php";
		jQuery.post(ajaxurl, data, function (dat) {
			if (dat != 0) {
				jQuery("#spncnpacntid").html(dat);
				jQuery("#txtcnpacntid").focus();
				if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', true); }
				jQuery("#cnpbtnverifysettings").prop('disabled', true);
			}
			else {
				jQuery("#spncnpacntid").html("");
				jQuery("#cnpbtnverifysettings").prop('disabled', false);
				if (jQuery("#cnpbtnaddsettings").val() == "Update") { jQuery("#cnpbtnaddsettings").prop('disabled', false); }
			}
		});
	});
	jQuery('#cnpbtnaddsettings').on("click", function () {

		if (jQuery("#txtcnpfrmfrndlynm").val() == "") {
			jQuery(".cnpfrmfrndlynm").addClass("cnpform-invalid");
			return false;
		}

		if (jQuery("#txtcnpacntid").val() == "") {
			jQuery(".cnpaccountId").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#txtcnpacntguid").val() == "") {
			jQuery(".cnpacntguid").addClass("cnpform-invalid");
			return false;
		}

	});

	jQuery('#cnpachnlbtnsubmit').on("click", function () {
		var stdt = jQuery("#txtcnpchnlstrtdt").val();
		var eddt = jQuery("#txtcnpchnlenddt").val();

		var greg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
		if (stdt.match(greg)) {

			var gres = stdt.split(" ");
			var gres1 = gres[0].split("/");
			var gres2 = gres1[1] + "/" + gres1[0] + "/" + gres1[2];
			stdt = gres2 + " " + gres[1] + " " + gres[2];

		}
		if (eddt != "") {
			if (eddt.match(greg)) {
				var gcres = eddt.split(" ");
				var gcres1 = gcres[0].split("/");
				var gcres2 = gcres1[1] + "/" + gcres1[0] + "/" + gcres1[2];
				eddt = gcres2 + " " + gcres[1] + " " + gcres[2];

			}
		}
		var mstdt = new Date(stdt);
		var meddt = new Date(eddt);
		var nofrms = jQuery("#hidnoofforms").val();
		var campfldnm;
		var frmfldnm;
		var guidfldnm;
		var chksdt = jQuery("#txtcnpchnlstrtdt").val();
		var chkedt = jQuery("#txtcnpchnlenddt").val();

		var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
		if (chksdt.match(reg)) {

			var res = chksdt.split(" ");
			var res1 = res[0].split("/");
			var res2 = res1[1] + "/" + res1[0] + "/" + res1[2];
			chksdt = res2 + " " + res[1] + " " + res[2];

		}
		if (chkedt != "") {
			if (chkedt.match(reg)) {
				var cres = chkedt.split(" ");
				var cres1 = cres[0].split("/");
				var cres2 = cres1[1] + "/" + cres1[0] + "/" + cres1[2];
				chkedt = cres2 + " " + cres[1] + " " + cres[2];

			}
		}
		var mchksdt = new Date(chksdt);
		var mchkedt = new Date(chkedt);

		if (jQuery.trim(jQuery("#txtcnpchnlgrp").val()) == "") {
			jQuery(".cnpfrmgrp").addClass("cnpform-invalid");
			return false;
		}

		if (jQuery("#txtcnpchnlstrtdt").val() == "") {
			jQuery(".cnpfrmstrtdt").addClass("cnpform-invalid");
			jQuery("#spncnpchnlstrtdt").text("Please Select Start Date");
			jQuery("#txtcnpchnlstrtdt").focus();
			return false;
		}
		if (chksdt != "" && chkedt != "") {
			if (mchksdt.getTime() > mchkedt.getTime()) {
				jQuery(".cnpfrmenddt").addClass("cnpform-invalid");
				jQuery("#spncnpchnlenddt").text("End date should be greater than start date");
				jQuery("#spncnpchnlenddt").focus();
				return false;
			}
			else {
				jQuery("#spncnpchnlenddt").text(""); jQuery(".cnpfrmenddt").removeClass("cnpform-invalid");
			}
		}
		addchannelslist(1);
	});

	function addchannelslist(inc) {
		var accntid = jQuery("#lstchnlaccntfrndlynam").val();
		var url = jQuery("#cnpchdnurl").val();
		var frndlynamarr = jQuery("#lstchnlaccntfrndlynam").val().split('||');
		var hdncdatefrmt = jQuery("#hdncdatefrmt").val();
		if (accntid !== "") {

			jQuery.ajax({
				type: "POST",
				url: url,
				data: { AccountId_val: frndlynamarr[0], AccountGUId_val: frndlynamarr[1] },
				success: function (data) {

					jQuery("#cnpachnlbtnsubmit").hide();
					jQuery("#cnpbtnchnlcancel").hide();
					jQuery(".chnladddiv").show();
					jQuery(".cnpfooter").show();
					jQuery("#lstcnpactivechannel" + inc).html(data);

					var finc = inc - 1;
					if (inc == 1) {
						jQuery("#txtcnpchnlstrtdt" + inc).datetimepicker({ format: hdncdatefrmt, defaultDate: new Date() });
					}
					else {
						// var d = new Date(jQuery("#txtcnpformenddt"+finc).val());
						var chnlchksdt = jQuery("#txtcnpchnlenddt" + finc).val();
						if (jQuery("#txtcnpchnlenddt" + finc).val() != "") {
							var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
							if (jQuery("#txtcnpchnlenddt" + finc).val().match(reg)) {
								var getdtfrmt = hdncdatefrmt.split(" ");
								if (getdtfrmt[0] != "MM/DD/YYYY") {
									var res = jQuery("#txtcnpchnlenddt" + finc).val().split(" ");
									var res1 = res[0].split("/");
									var res2 = res1[1] + "/" + res1[0] + "/" + res1[2];
									chnlchksdt = res2 + " " + res[1] + " " + res[2];
								}
							}

						}
						//	var chnlchksdt = jQuery("#txtcnpchnlenddt"+inc).val();
						var d = new Date(chnlchksdt);
						if (d == "Invalid Date") {
							jQuery("#txtcnpchnlstrtdt" + inc).datetimepicker({ format: hdncdatefrmt, defaultDate: new Date() });
						} else {
							jQuery("#txtcnpchnlstrtdt" + inc).datetimepicker({ format: hdncdatefrmt, defaultDate: new Date(d.setMinutes(d.getMinutes() + 1)) });
							jQuery('#txtcnpchnlenddt' + inc).datetimepicker({ format: hdncdatefrmt });

						}
					}


				}
			});
		}
	}
	/***********************************/

	jQuery('#cnpchnlbtnsave').on("click", function () {
		var stdt = jQuery("#txtcnpchnlstrtdt").val();
		var eddt = jQuery("#txtcnpchnlenddt").val();

		var greg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
		if (stdt.match(greg)) {

			var gres = stdt.split(" ");
			var gres1 = gres[0].split("/");
			var gres2 = gres1[1] + "/" + gres1[0] + "/" + gres1[2];
			stdt = gres2 + " " + gres[1] + " " + gres[2];

		}
		if (eddt != "") {
			if (eddt.match(greg)) {
				var gcres = eddt.split(" ");
				var gcres1 = gcres[0].split("/");
				var gcres2 = gcres1[1] + "/" + gcres1[0] + "/" + gcres1[2];
				eddt = gcres2 + " " + gcres[1] + " " + gcres[2];

			}
		}
		var mstdt = new Date(stdt);
		var meddt = new Date(eddt);
		var nofrms = jQuery("#hidnoofforms").val();
		var campfldnm;
		var frmfldnm;
		var guidfldnm;
		var chksdt = jQuery("#txtcnpchnlstrtdt").val();
		var chkedt = jQuery("#txtcnpchnlenddt").val();

		var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
		if (chksdt.match(reg)) {

			var res = chksdt.split(" ");
			var res1 = res[0].split("/");
			var res2 = res1[1] + "/" + res1[0] + "/" + res1[2];
			chksdt = res2 + " " + res[1] + " " + res[2];

		}
		if (chkedt != "") {
			if (chkedt.match(reg)) {
				var cres = chkedt.split(" ");
				var cres1 = cres[0].split("/");
				var cres2 = cres1[1] + "/" + cres1[0] + "/" + cres1[2];
				chkedt = cres2 + " " + cres[1] + " " + cres[2];

			}
		}
		var mchksdt = new Date(chksdt);
		var mchkedt = new Date(chkedt);

		if (jQuery("#txtcnpchnlgrp").val() == "") {
			jQuery(".cnpfrmgrp").addClass("cnpform-invalid");
			return false;
		}

		if (jQuery("#txtcnpchnlstrtdt").val() == "") {
			jQuery(".cnpfrmstrtdt").addClass("cnpform-invalid");
			jQuery("#spncnpchnlstrtdt").text("Please select a start date");
			jQuery("#txtcnpchnlstrtdt").focus();

			return false;
		}
		else if (jQuery("#txtcnpchnlstrtdt").val() != "") {
			jQuery("#spncnpchnlstrtdt").text("");
		}
		if (chksdt != "" && chkedt != "") {
			if (mchksdt.getTime() > mchkedt.getTime()) {
				jQuery(".cnpfrmenddt").addClass("cnpform-invalid");
				jQuery("#spncnpchnlenddt").text("End date should be greater than or equal to start date");
				jQuery("#txtcnpchnlenddt").focus();
				return false;
			} else {
				jQuery("#spncnpchnlenddt").text("");
			}
		}

		if (nofrms == "") { nofrms = 1; }
		for (var j = 1; j <= nofrms; j++) {

			if (jQuery("#addchannelval").val() == 2) {
				campfldnm = jQuery("#lstcnpeditactivecamp" + j);
				var strtdtf = jQuery("#txtcnpformstrtdt" + j);
				var chkedtf = jQuery("#txtcnpformenddt" + j);
				var strtdt1 = jQuery("#txtcnpformstrtdt" + j).val();
				var chkedt1 = jQuery("#txtcnpformenddt" + j).val();

			}
			else {
				campfldnm = jQuery("#lstcnpactivechannel" + j);
				var strtdtf = jQuery("#txtcnpchnlstrtdt" + j);
				var chkedtf = jQuery("#txtcnpchnlenddt" + j);
				var strtdt1 = jQuery("#txtcnpchnlstrtdt" + j).val();
				var chkedt1 = jQuery("#txtcnpchnlenddt" + j).val();

			}


			var ereg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
			if (strtdt1.match(ereg)) {

				var eres = strtdt1.split(" ");
				var eres1 = eres[0].split("/");
				var eres2 = eres1[1] + "/" + eres1[0] + "/" + eres1[2];
				strtdt1 = eres2 + " " + eres[1] + " " + eres[2];

			}
			if (chkedt1 != "") {
				if (chkedt1.match(ereg)) {
					var ecres = chkedt1.split(" ");
					var ecres1 = ecres[0].split("/");
					var ecres2 = ecres1[1] + "/" + ecres1[0] + "/" + ecres1[2];
					chkedt1 = ecres2 + " " + ecres[1] + " " + ecres[2];

				}
			}

			var mchksdt1 = new Date(strtdt1);
			var mchkedt1 = new Date(chkedt1);

			if (campfldnm.val() == "") {
				jQuery("#spncampnname" + j).text("Please Select a Channel ID");
				campfldnm.focus();
				return false;
			}
			else if (campfldnm.val() != "") { jQuery("#spncampnname" + j).text(""); }


			if (strtdt1 == "") {
				jQuery("#spnstrtdt" + j).text("Please select a start date");
				strtdtf.focus();
				return false;
			}
			else if (strtdt1 != "") { jQuery("#spnstrtdt" + j).text(""); }
			if (chkedt1 == "" && nofrms > 1 && j != nofrms) {
				jQuery("#spnenddt" + j).text("Please select a End date");
				chkedtf.focus();
				return false;
			}
			else if (strtdt1 != "") { jQuery("#spnenddt" + j).text(""); }


			if (strtdt1 != "" && chkedt1 == "") {

				if (mchksdt1.getTime() < mstdt.getTime()) {
					jQuery("#spnstrtdt" + j).text("Channel start date should be greater or equal to group start date");
					strtdtf.focus();
					return false;
				}
				if (mchksdt1.getTime() > meddt.getTime()) {
					jQuery("#spnstrtdt" + j).text("Channel start date should be less than or equal to group end date");
					strtdtf.focus();
					return false;
				}
			}
			if (strtdt1 != "" && chkedt1 != "") {

				if (mchkedt1.getTime() > meddt.getTime()) {
					jQuery("#spnenddt" + j).text("Channel end date should be less than or equal to group end date");
					chkedtf.focus();
					return false;
				}
				if (mchksdt1.getTime() > meddt.getTime()) {
					jQuery("#spnstrtdt" + j).text("Channel start date should be less than or equal to group end date");
					strtdtf.focus();
					return false;
				}
				if (mchksdt1.getTime() < mstdt.getTime()) {
					jQuery("#spnstrtdt" + j).text("Channel start date should be greater or equal to group start date");
					strtdtf.focus();
					return false;
				}
				if (mchksdt1.getTime() > mchkedt1.getTime()) {
					jQuery("#spnenddt" + j).text("End date should be greater than or equal to start date");
					chkedtf.focus();
					return false;
				}
			}
		}


	});
	/********************************/
	jQuery('#cnpbtnsave').on("click", function () {
		var stdt = jQuery("#txtcnpformstrtdt").val();
		var eddt = jQuery("#txtcnpformenddt").val();
	
		var greg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
		if (stdt.match(greg)) {

			var gres = stdt.split(" ");
			var gres1 = gres[0].split("/");
			var gres2 = gres1[1] + "/" + gres1[0] + "/" + gres1[2];
			stdt = gres2 + " " + gres[1] + " " + gres[2];

		}
		if (eddt != "") {
			if (eddt.match(greg)) {
				var gcres = eddt.split(" ");
				var gcres1 = gcres[0].split("/");
				var gcres2 = gcres1[1] + "/" + gcres1[0] + "/" + gcres1[2];
				eddt = gcres2 + " " + gcres[1] + " " + gcres[2];

			}
		}
		var mstdt = new Date(stdt);
		var meddt = new Date(eddt);
		var nofrms = jQuery("#hidnoofforms").val();
		var campfldnm;
		var frmfldnm;
		var guidfldnm;
		var chksdt = jQuery("#txtcnpformstrtdt").val();
		var chkedt = jQuery("#txtcnpformenddt").val();

		var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
		if (chksdt.match(reg)) {

			var res = chksdt.split(" ");
			var res1 = res[0].split("/");
			var res2 = res1[1] + "/" + res1[0] + "/" + res1[2];
			chksdt = res2 + " " + res[1] + " " + res[2];

		}
		if (chkedt != "") {
			if (chkedt.match(reg)) {
				var cres = chkedt.split(" ");
				var cres1 = cres[0].split("/");
				var cres2 = cres1[1] + "/" + cres1[0] + "/" + cres1[2];
				chkedt = cres2 + " " + cres[1] + " " + cres[2];

			}
		}
		var mchksdt = new Date(chksdt);
		var mchkedt = new Date(chkedt);

		if (jQuery("#txtcnpfrmgrp").val() == "") {
			jQuery(".cnpfrmgrp").addClass("cnpform-invalid");
			return false;
		}

		if (jQuery("#txtcnpformstrtdt").val() == "") {
			jQuery(".cnpfrmstrtdt").addClass("cnpform-invalid");
			return false;
		}
		if (chksdt != "" && chkedt != "") {
			if (mchksdt.getTime() > mchkedt.getTime()) {
				jQuery(".cnpfrmenddt").addClass("cnpform-invalid");
				return false;
			}
		}
		if (jQuery("#lstfrmtyp").val() == "") {
			jQuery(".cnplstfrmtyp").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && jQuery("#lstpopuptyp").val() == "") {
			jQuery(".popuptyp").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && (jQuery("#lstpopuptyp").val() == "text" || jQuery("#lstpopuptyp").val() == "button") && jQuery("#txtpopuptxt").val() == "") {
			jQuery(".popuptyptxt").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && jQuery("#lstpopuptyp").val() == "image" && (jQuery("#hdnpopupimg").val() == "N" && jQuery("#txtpopupimg").val() == "")) {
			jQuery(".popuptypimg").addClass("cnpform-invalid");
			return false;
		}
		if (nofrms == "") { nofrms = 1; }
		for (var j = 1; j <= nofrms; j++) {

			if (jQuery("#addformval").val() == 2) {
				campfldnm = jQuery("#lstcnpeditactivecamp" + j);
				frmfldnm = jQuery("#lstcnpeditfrmtyp" + j);

			}
			else {
				campfldnm = jQuery("#lstcnpactivecamp" + j);
				frmfldnm = jQuery("#lstcnpfrmtyp" + j);
			}
			var strtdt1 = jQuery("#txtcnpformstrtdt" + j).val();
			var chkedt1 = jQuery("#txtcnpformenddt" + j).val();

			var ereg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
			if (strtdt1.match(ereg)) {

				var eres = strtdt1.split(" ");
				var eres1 = eres[0].split("/");
				var eres2 = eres1[1] + "/" + eres1[0] + "/" + eres1[2];
				strtdt1 = eres2 + " " + eres[1] + " " + eres[2];

			}
			if (chkedt1 != "") {
				if (chkedt1.match(ereg)) {
					var ecres = chkedt1.split(" ");
					var ecres1 = ecres[0].split("/");
					var ecres2 = ecres1[1] + "/" + ecres1[0] + "/" + ecres1[2];
					chkedt1 = ecres2 + " " + ecres[1] + " " + ecres[2];

				}
			}

			var mchksdt1 = new Date(strtdt1);
			var mchkedt1 = new Date(chkedt1);

			if (campfldnm.val() == "") {
				jQuery("#spncampnname" + j).text("Please select a campaign");
				campfldnm.focus();
				return false;
			}
			else if (campfldnm.val() != "") { jQuery("#spncampnname" + j).text(""); }

			if (frmfldnm.val() == "") {
				jQuery("#spnformname" + j).text("Please select a form");
				frmfldnm.focus();
				return false;
			}
			else if (frmfldnm.val() != "") { jQuery("#spnformname" + j).text(""); }

			if (jQuery("#txtcnpformstrtdt" + j).val() == "") {
				jQuery("#spnstrtdt" + j).text("Please select a start date");
				jQuery("#txtcnpformstrtdt" + j).focus();
				return false;
			}
			else if (jQuery("#txtcnpformstrtdt" + j).val() != "") { jQuery("#spnstrtdt" + j).text(""); }
			if (jQuery("#txtcnpformenddt" + j).val() == "" && nofrms > 1 && j != nofrms) {
				jQuery("#spnenddt" + j).text("Please select a End date");
				jQuery("#txtcnpformenddttxtcnpformenddt" + j).focus();
				return false;
			}
			else if (jQuery("#txtcnpformstrtdt" + j).val() != "") { jQuery("#spnenddt" + j).text(""); }


			if (strtdt1 != "" && chkedt1 == "") {

				if (mchksdt1.getTime() < mstdt.getTime()) {
					jQuery("#spnstrtdt" + j).text("Form start date should be greater or equal to group start date");
					jQuery("#txtcnpformstrtdt" + j).focus();
					return false;
				}
				if (mchksdt1.getTime() > meddt.getTime()) {
					jQuery("#spnstrtdt" + j).text("Form start date should be less than or equal to group end date");
					jQuery("#txtcnpformstrtdt" + j).focus();
					return false;
				}
			}
			if (strtdt1 != "" && chkedt1 != "") {
				if (mchkedt1.getTime() > meddt.getTime()) {
					jQuery("#spnenddt" + j).text("Form end date should be less than or equal to group end date");
					jQuery("#txtcnpformenddt" + j).focus();
					return false;
				}
				if (mchksdt1.getTime() < mstdt.getTime()) {
					jQuery("#spnstrtdt" + j).text("Form start date should be greater or equal to group start date");
					jQuery("#txtcnpformstrtdt" + j).focus();
					return false;
				}
				if (mchksdt1.getTime() > mchkedt1.getTime()) {
					jQuery("#spnenddt" + j).text("End date should be greater than or equal to start date");
					jQuery("#txtcnpformenddt" + j).focus();
					return false;
				}
			}
		}


	});
	jQuery("form :input").change(function () {
		//jQuery(this).closest('.form-invalid').removeClass('form-invalid');
	});
	jQuery(".hasDatepicker").change(function () {
		jQuery(".cnperror").text("");

	});

	jQuery("#editguid").submit(function (event) {
		var stdt = jQuery("#cnphdnFrmstrtdt").val();
		var eddt = jQuery("#cnphdnFrmenddt").val();
		var chksdt = jQuery("#txtcnpfrmstrtdt").val();
		var chkedt = jQuery("#txtcnpfrmenddt").val();

		var mstdt = new Date(stdt);
		var meddt = new Date(eddt);
		var mchksdt = new Date(chksdt);
		var mchkedt = new Date(chkedt);

		if (jQuery("#lstcnpditactivecamp").val() == "") {
			jQuery(".cnpcampaignlst").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lsteditcnpfrmtyp").val() == "") {
			jQuery(".cnpformslst").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#txtcnpguid").val() == "") {
			jQuery(".cnpguid").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "") {
			jQuery(".cnplstfrmtyp").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && jQuery("#lstpopuptyp").val() == "") {
			jQuery(".popuptyp").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && (jQuery("#lstpopuptyp").val() == "text" || jQuery("#lstpopuptyp").val() == "button") && jQuery("#txtpopuptxt").val() == "") {
			jQuery(".popuptyptxt").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && jQuery("#lstpopuptyp").val() == "image" && jQuery("#txtpopupimg").val() == "") {
			jQuery(".popuptypimg").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#txtcnpfrmstrtdt").val() == "") {
			jQuery(".cnpfrmstrtdt").addClass("cnpform-invalid");
			return false;
		}
		if (chksdt != "" && chkedt == "") {
			if (mchksdt.getTime() < mstdt.getTime()) {
				alert("Form start date should be greater or equal to group start date");
				jQuery(".cnpfrmstrtdt").addClass("cnpform-invalid");
				return false;
			}
		}
		else if (chksdt != "" && chkedt != "") {
			if (mchksdt.getTime() > mstdt.getTime() || meddt.getTime() < mchkedt.getTime()) {
				alert("Form start & end date should be within the group  " + stdt + " and " + eddt);
				jQuery(".cnpfrmstrtdt").addClass("cnpform-invalid");
				return false;
			}
		}

	});
	jQuery("#addfrm").submit(function (event) {

		if (jQuery("#txtcnpacntid").val() == "") {
			jQuery(".cnpaccountId").addClass("cnpform-invalid");
			return false;
		}
		else if (jQuery("#txtcnpfrmname").val() == "") {
			jQuery(".cnpcampaignlst").addClass("cnpform-invalid");
			return false;
		}
		else if (jQuery("#txtcnpformstrtdt").val() == "") {
			jQuery(".cnpfrmstrtdt").addClass("cnpform-invalid");
			return false;
		}
		return true;
	});
	/*jQuery('#cnpbtnurlparms').click(function() { 
		document.getElementById("txturlparmsrowid").val()								
		jQuery("#dialogForm").dialog("open");
	});*/

	jQuery('#btnaddparms').click(function (e) {
		e.preventDefault();
		var cnprowpos = jQuery("#txturlparmsrowid").val();
		var asgnvaluu = "#txtbtnurlparms" + cnprowpos;
		var cnpparmlst = document.getElementById("txturlparms").value;
		jQuery("#txtbtnurlparms" + cnprowpos).val(jQuery.trim(cnpparmlst.replace(/^\s+|\s+$/gm, '')));
		jQuery("#cnpsuccess").html("");
		jQuery("#cnpsuccess").html("<span class='cnpsuccess'>Parameters added</span>");
	});

	function svclscnpdlgform() {
		var cnprowpos = jQuery("#txturlparmsrowid").val();
		var asgnvaluu = "#txtbtnurlparms" + cnprowpos;
		var cnpparmlst = document.getElementById("txturlparms").value;
		jQuery("#txtbtnurlparms" + cnprowpos).val(jQuery.trim(cnpparmlst.replace(/^\s+|\s+$/gm, '')));
		jQuery("#cnpsuccess").html("");
		jQuery("#cnpsuccess").html("<span class='cnpsuccess'>Parameters added</span>");
	}

	jQuery('#cnpbtnadd').click(function (e) {
		e.preventDefault();
		if (jQuery("#addformval").val() == 2) {
			var nofrms = +jQuery("#hidnoofforms").val() + 1;
			counter = nofrms;
			for (var jinc = 1; jinc <= counter; jinc++) {
				if (jQuery("#lstcnpeditactivecamp" + jinc).val() == "") {
					jQuery("#spncampnname" + jinc).text("Please select a campaign");
					jQuery("#lstcnpeditactivecamp" + jinc).focus();
					return false;
				}
				else if (jQuery("#lstcnpeditactivecamp" + jinc).val() != "") {
					jQuery("#spncampnname" + jinc).text("");
				}
				if (jQuery("#lstcnpeditfrmtyp" + jinc).val() == "") {
					jQuery("#spnformname" + jinc).text("Please select a form");
					jQuery("#lstcnpeditfrmtyp" + jinc).focus();
					return false;
				}
				else if (jQuery("#lstcnpeditfrmtyp" + jinc).val() != "") {
					jQuery("#spnformname" + jinc).text("");
				}
				if (jQuery("#txtcnpformstrtdt" + jinc).val() == "") {
					jQuery("#spnstrtdt" + jinc).text("Please select a start date");
					jQuery("#txtcnpformstrtdt" + jinc).focus();
					return false;
				}
				else if (jQuery("#txtcnpformstrtdt" + jinc).val() != "") {
					jQuery("#spnstrtdt" + jinc).text("");
				}
				if (jQuery("#txtcnpformenddt" + jinc).val() == "") {
					jQuery("#spnenddt" + jinc).text("You must select an end date before adding another form");
					jQuery("#txtcnpformenddt" + jinc).focus();
					return false;
				} else if (jQuery("#txtcnpformenddt" + jinc).val() == "") {
					jQuery("#spnenddt" + jinc).text("");
				}

				if (jQuery("#txtcnpformstrtdt" + jinc).val() != "" &&
					jQuery("#txtcnpformenddt" + jinc).val() != "") {
					if (new Date(jQuery("#txtcnpformstrtdt" + jinc).val()).getTime() > new Date(jQuery("#txtcnpformenddt" + jinc).val()).getTime()) {
						jQuery("#spnenddt" + jinc).text("End date should be greater than start date");
						jQuery("#txtcnpformenddt" + jinc).focus();
						return false;
					}
					else { jQuery("#spnenddt" + jinc).text(""); }
				}
			}
			var html = '<tr id="trfid' + counter + '"><td><input type="hidden" name="hdncnpformcnt[]" id="hdncnpformcnt[]" value="' + counter + '"><input type="hidden" name="hdncnpformname' + counter + '" id="hdncnpformname' + counter + '"><select name="lstcnpeditactivecamp' + counter + '" id="lstcnpeditactivecamp' + counter + '" onchange=getEditActiveForms(' + counter + ',"lstcnpeditactivecamp","");  class="cnp_campaigns_select"><option value="">Select Campaign</option></select><span class=cnperror id="spncampnname' + counter + '"></span></td>  <td><select name="lstcnpeditfrmtyp' + counter + '" id="lstcnpeditfrmtyp' + counter + '" onchange="getEditActiveGUID(' + counter + ')" class="cnp_forms_select"><option value="">Select Forms</option></select><span class=cnperror id="spnformname' + counter + '"></span></td><td><input type="text" size="36" id="txtcnpguid' + counter + '" name="txtcnpguid' + counter + '"  readonly/></td><td><div class="input-group date" ><input type="text" size="23" id="txtcnpformstrtdt' + counter + '" name="txtcnpformstrtdt' + counter + '" /><span class=cnperror id="spnstrtdt' + counter + '"></span><div></td><td><div class="input-group date"><input type="text" size="23" id="txtcnpformenddt' + counter + '" name="txtcnpformenddt' + counter + '" /><span class=cnperror id="spnenddt' + counter + '"></span></div></td><td><input type="hidden"  id="txtbtnurlparms' + counter + '" name="txtbtnurlparms' + counter + '"/><input type="button"name="cnpbtnurlparms" id="cnpbtnurlparms" value="URL +" onclick="cnpAddurlparameters(' + counter + ')" class="add-new-h2"></td><td><a href="#" onclick="getDeleteFormrows(' + counter + ')"><span class="dashicons dashicons-trash" name="cnpbtndelte" id="cnpbtndelte"  style="text-decoration:none !important"></a></span></td></tr>';
			getEditActiveChannels(counter, "");
			jQuery("#hidnoofforms").val(counter);
			if (counter >= 2) { jQuery("#cnpbtndelte").show(); }
			jQuery('#cnpformslist').append(html);
		}
		else {
			var nofrms = +jQuery("#hidnoofforms").val() + 1;

			if (nofrms == 1) { counter = 2; } else { counter = nofrms; }

			for (var jinc = 1; jinc <= counter; jinc++) {
				if (jQuery("#lstcnpactivecamp" + jinc).val() == "") {
					jQuery("#spncampnname" + jinc).text("Please select a campaign");
					jQuery("#lstcnpactivecamp" + jinc).focus();
					return false;
				} else if (jQuery("#lstcnpactivecamp" + jinc).val() != "") {
					jQuery("#spncampnname" + jinc).text("");
				}
				if (jQuery("#lstcnpfrmtyp" + jinc).val() == "") {
					jQuery("#spnformname" + jinc).text("Please select a form");
					jQuery("#lstcnpfrmtyp" + jinc).focus();
					return false;
				} else if (jQuery("#lstcnpfrmtyp" + jinc).val() != "") {
					jQuery("#spnformname" + jinc).text("");
				}
				if (jQuery("#txtcnpformstrtdt" + jinc).val() == "") {
					jQuery("#spnstrtdt" + jinc).text("Please select a start date");
					jQuery("#txtcnpformstrtdt" + jinc).focus();
					return false;
				} else if (jQuery("#txtcnpformstrtdt" + jinc).val() != "") {
					jQuery("#spnstrtdt" + jinc).text("");
				}
				if (jQuery("#txtcnpformenddt" + jinc).val() == "") {
					jQuery("#spnenddt" + jinc).text("You must select an end date before adding another form");
					jQuery("#txtcnpformenddt" + jinc).focus();
					return false;
				}
				else if (jQuery("#txtcnpformenddt" + jinc).val() != "") {
					jQuery("#spnenddt" + jinc).text("");
				}
				if (jQuery("#txtcnpformstrtdt" + jinc).val() != "" &&
					jQuery("#txtcnpformenddt" + jinc).val() != "") {
					if (new Date(jQuery("#txtcnpformstrtdt" + jinc).val()).getTime() > new Date(jQuery("#txtcnpformenddt" + jinc).val()).getTime()) {
						jQuery("#spnenddt" + jinc).text("End date should be greater than start date");
						jQuery("#txtcnpformenddt" + jinc).focus();
						return false;
					}
				}

			}
			var html = '<tr id="trfid' + counter + '"><td><input type="hidden" name="hdncnpformcnt[]" id="hdncnpformcnt[]" value="' + counter + '"><input type="hidden" name="hdncnpformname' + counter + '" id="hdncnpformname' + counter + '"><select name="lstcnpactivecamp' + counter + '" id="lstcnpactivecamp' + counter + '" onchange="getActiveForms(' + counter + ')";  class="cnp_campaigns_select"><option value="">Select Campaign</option></select><span class=cnperror id="spncampnname' + counter + '"></span></td>  <td><select name="lstcnpfrmtyp' + counter + '" id="lstcnpfrmtyp' + counter + '" onchange="getActiveGUID(' + counter + ')"; class="cnp_forms_select"><option value="">Select Forms</option></select><span class=cnperror id="spnformname' + counter + '"></span></td><td><input type="text" size="36" id="txtcnpguid' + counter + '" name="txtcnpguid' + counter + '" readonly/></td><td><div class="input-group date" ><input type="text" size="23" id="txtcnpformstrtdt' + counter + '" name="txtcnpformstrtdt' + counter + '" /></div><span class=cnperror id="spnstrtdt' + counter + '"></span></td><td><div class="input-group date" ><input type="text" size="23" id="txtcnpformenddt' + counter + '" name="txtcnpformenddt' + counter + '" /><span class=cnperror id="spnenddt' + counter + '"></span><div></td><td><input type="hidden"  id="txtbtnurlparms' + counter + '" name="txtbtnurlparms' + counter + '"/><input type="button"name="cnpbtnurlparms" id="cnpbtnurlparms" value="URL +"  onclick="cnpAddurlparameters(' + counter + ')" class="add-new-h2"></td><td><a href="#" onclick="getDeleteFormrows(' + counter + ')"><span class="dashicons dashicons-trash" name="cnpbtndelte" id="cnpbtndelte"  style="text-decoration:none !important"></span></a></td></tr>';
			addcampaignlist(counter);
			jQuery('#cnpformslist').append(html);
			if (counter >= 2) { jQuery("#cnpbtndelte").show(); }
			jQuery("#hidnoofforms").val(counter);

		}
		counter++;
	});

	jQuery('#cnpbtncadd').click(function (e) {
		e.preventDefault();
		if (jQuery("#addchannelval").val() == 2) {
			var nofrms = +jQuery("#hidnoofforms").val() + 1;
			counter = nofrms;

			for (var jinc = 1; jinc <= counter; jinc++) {
				if (jQuery("#lstcnpeditactivecamp" + jinc).val() == "") {
					jQuery("#spncampnname" + jinc).text("Please select a channel");
					jQuery("#lstcnpeditactivecamp" + jinc).focus();
					return false;
				}
				else if (jQuery("#lstcnpeditactivecamp" + jinc).val() != "") {
					jQuery("#spncampnname" + jinc).text("");
				}

				if (jQuery("#txtcnpformstrtdt" + jinc).val() == "") {
					jQuery("#spnstrtdt" + jinc).text("Please select a start date");
					jQuery("#txtcnpformstrtdt" + jinc).focus();
					return false;
				}
				else if (jQuery("#txtcnpformstrtdt" + jinc).val() != "") {
					jQuery("#spnstrtdt" + jinc).text("");
				}
				if (jQuery("#txtcnpformenddt" + jinc).val() == "") {
					jQuery("#spnenddt" + jinc).text("You must select an end date before adding another channel");
					jQuery("#txtcnpformenddt" + jinc).focus();
					return false;
				} else if (jQuery("#txtcnpformenddt" + jinc).val() == "") {
					jQuery("#spnenddt" + jinc).text("");
				}

				if (jQuery("#txtcnpformstrtdt" + jinc).val() != "" &&
					jQuery("#txtcnpformenddt" + jinc).val() != "") {
					if (new Date(jQuery("#txtcnpformstrtdt" + jinc).val()).getTime() > new Date(jQuery("#txtcnpformenddt" + jinc).val()).getTime()) {
						jQuery("#spnenddt" + jinc).text("End date should be greater than start date");
						jQuery("#txtcnpformenddt" + jinc).focus();
						return false;
					}
					else { jQuery("#spnenddt" + jinc).text(""); }
				}
			}
			var html = '<tr id="trid' + counter + '"><td><input type="hidden" name="hdncnpformcnt[]" id="hdncnpformcnt[]" value="' + counter + '"><select name="lstcnpeditactivecamp' + counter + '" id="lstcnpeditactivecamp' + counter + '"   class="cnp_campaigns_select"><option value="">Select Channel</option></select><span class=cnperror id="spncampnname' + counter + '"></span></td>  <td><div class="input-group date" ><input type="text" size="23" id="txtcnpformstrtdt' + counter + '" name="txtcnpformstrtdt' + counter + '" /><span class=cnperror id="spnstrtdt' + counter + '"></span><div></td><td><div class="input-group date"><input type="text" size="23" id="txtcnpformenddt' + counter + '" name="txtcnpformenddt' + counter + '" /><span class=cnperror id="spnenddt' + counter + '"></span></div></td><td><a href="#" onclick="getDeletechannelrows(' + counter + ')"><span class="dashicons dashicons-trash" name="cnpbtndelte" id="cnpbtndelte"  style="text-decoration:none !important"></span></a></td></tr>';

			getEditActiveChannels(counter, "");
			jQuery("#hidnoofforms").val(counter);
			if (counter >= 2) { jQuery("#cnpbtndelte").show(); }
			jQuery('#cnpformslist').append(html);
		}
		else {
			var nofrms = +jQuery("#hidnoofforms").val() + 1;

			if (nofrms == 1) { counter = 2; } else { counter = nofrms; }

			for (var jinc = 1; jinc <= counter; jinc++) {
				if (jQuery("#lstcnpactivechannel" + jinc).val() == "") {
					jQuery("#spncampnname" + jinc).text("Please select a channel ID");
					jQuery("#lstcnpactivechannel" + jinc).focus();
					return false;
				} else if (jQuery("#lstcnpactivechannel" + jinc).val() != "") {
					jQuery("#spncampnname" + jinc).text("");
				}

				if (jQuery("#txtcnpchnlstrtdt" + jinc).val() == "") {
					jQuery("#spnstrtdt" + jinc).text("Please select a start date");
					jQuery("#txtcnpchnlstrtdt" + jinc).focus();
					return false;
				} else if (jQuery("#txtcnpchnlstrtdt" + jinc).val() != "") {
					jQuery("#spnstrtdt" + jinc).text("");
				}
				if (jQuery("#txtcnpchnlenddt" + jinc).val() == "") {
					jQuery("#spnenddt" + jinc).text("You must select an end date before adding another channel");
					jQuery("#txtcnpchnlenddt" + jinc).focus();
					return false;
				}
				else if (jQuery("#txtcnpchnlenddt" + jinc).val() != "") {
					jQuery("#spnenddt" + jinc).text("");
				}
				if (jQuery("#txtcnpchnlstrtdt" + jinc).val() != "" &&
					jQuery("#txtcnpchnlenddt" + jinc).val() != "") {
					if (new Date(jQuery("#txtcnpchnlstrtdt" + jinc).val()).getTime() > new Date(jQuery("#txtcnpchnlenddt" + jinc).val()).getTime()) {
						jQuery("#spnenddt" + jinc).text("End date should be greater than start date");
						jQuery("#txtcnpchnlenddt" + jinc).focus();
						return false;
					}
				}

			}
			var html = '<tr id="trid' + counter + '"><td><input type="hidden" name="hdncnpchnlcnt[]" id="hdncnpchnlcnt[]" value="' + counter + '"><input type="hidden" name="hdncnpformname' + counter + '" id="hdncnpformname' + counter + '"><select name="lstcnpactivechannel' + counter + '" id="lstcnpactivechannel' + counter + '"  class="cnp_campaigns_select"><option value="">Select Channel ID</option></select><span class=cnperror id="spncampnname' + counter + '"></span></td><td><div class="input-group date" ><input type="text" size="20" id="txtcnpchnlstrtdt' + counter + '" name="txtcnpchnlstrtdt' + counter + '" /></div><span class=cnperror id="spnstrtdt' + counter + '"></span></td><td><div class="input-group date" ><input type="text" size="20" id="txtcnpchnlenddt' + counter + '" name="txtcnpchnlenddt' + counter + '" /><span class=cnperror id="spnenddt' + counter + '"></span><div></td><td><a href="#" onclick="getDeletechannelrows(' + counter + ')"><span class="dashicons dashicons-trash" name="cnpbtnchnldelte" id="cnpbtnchnldelte"  style="text-decoration:none !important"></span></a></td></tr>';
			addchannelslist(counter);
			jQuery('#cnpformslist').append(html);
			if (counter >= 2) { jQuery("#cnpbtndelte").show(); }
			jQuery("#hidnoofforms").val(counter);

		}
		counter++;
	});

	jQuery('#cnpbtnsubmit').click(function (e) {
		e.preventDefault();

		var chksdt = jQuery("#txtcnpformstrtdt").val();
		var chkedt = jQuery("#txtcnpformenddt").val();
	
		if (chkedt != "") {
			var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
			if (chksdt.match(reg)) {

				var res = chksdt.split(" ");
				var res1 = res[0].split("/");
				var res2 = res1[1] + "/" + res1[0] + "/" + res1[2];
				chksdt = res2 + " " + res[1] + " " + res[2];

			}
			if (chkedt.match(reg)) {
				var cres = chkedt.split(" ");
				var cres1 = cres[0].split("/");
				var cres2 = cres1[1] + "/" + cres1[0] + "/" + cres1[2];
				chkedt = cres2 + " " + cres[1] + " " + cres[2];

			}
		}

		var mchksdt = new Date(chksdt);
		var mchkedt = new Date(chkedt);

		if (jQuery.trim(jQuery("#txtcnpfrmgrp").val()) == "") {
			jQuery(".cnpfrmgrp").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstaccntfrndlynam").val() == "") {
			jQuery(".cnplstfrndlyname").addClass("cnpform-invalid");
			return false;
		}

		if (jQuery("#txtcnpformstrtdt").val() == "") {
	
			jQuery(".cnpfrmstrtdt").addClass("cnpform-invalid");
			return false;
		}
		if (chksdt != "" && chkedt != "") {
			if (mchksdt.getTime() > mchkedt.getTime()) {
				jQuery(".cnpfrmenddt").addClass("cnpform-invalid");
				return false;
			}
		}
		if (jQuery("#lstfrmtyp").val() == "") {
			jQuery(".cnplstfrmtyp").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && jQuery("#lstpopuptyp").val() == "") {
			jQuery(".popuptyp").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && (jQuery("#lstpopuptyp").val() == "text" || jQuery("#lstpopuptyp").val() == "button") && jQuery("#txtpopuptxt").val() == "") {
			jQuery(".popuptyptxt").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#lstfrmtyp").val() == "popup" && jQuery("#lstpopuptyp").val() == "image" && jQuery("#txtpopupimg").val() == "") {
			jQuery(".popuptypimg").addClass("cnpform-invalid");
			return false;
		}
		jQuery("#txtcnpformenddt").closest('.cnpform-invalid').removeClass('cnpform-invalid');
		jQuery(this).closest('.cnpform-invalid').removeClass('cnpform-invalid');
		addcampaignlist(1);
		

	});

	function addcampaignlist(inc) {
		var accntid = jQuery("#lstaccntfrndlynam").val();
		var url = jQuery("#cnphdnurl").val();
		var frndlynamarr = jQuery("#lstaccntfrndlynam").val().split('||');
		if (accntid !== "") {
			jQuery.ajax({
				type: "POST",
				url: url,
				data: { AccountId_val: frndlynamarr[0], AccountGUId_val: frndlynamarr[1] },
				success: function (data) {
					jQuery("#cnpbtnsubmit").hide();
					jQuery("#cnpbtncancel").hide();
					jQuery(".frmadddiv").show();
					jQuery(".cnpfooter").show();
					jQuery("#lstcnpactivecamp" + inc).html(data);
				}
			});
		}
	}
	jQuery('#cnpbtnverifysettings').click(function (e) {

		var accntid = jQuery("#txtcnpacntid").val();
		var guid = jQuery("#txtcnpacntguid").val();
		var url = jQuery("#cnphdnerrurl").val();
		if (jQuery("#txtcnpacntid").val() == "") {
			jQuery(".cnpaccountId").addClass("cnpform-invalid");
			return false;
		}
		if (jQuery("#txtcnpacntguid").val() == "") {
			jQuery(".cnpacntguid").addClass("cnpform-invalid");
			return false;
		}
		if (accntid !== "") {
			jQuery.ajax({
				type: "POST",
				url: url,
				data: { AccountId_val: accntid, AccountGUId_val: guid },
				success: function (data) {
					if (data != "" && data !== "SOAP") {
						jQuery("#cnpbtnverifysettings").hide();
						jQuery("#spnverify").hide();
						jQuery('#txtcnpacntid').attr('readonly', true);
						jQuery('#txtcnpacntguid').attr('readonly', true);
						jQuery(".frmaddnickdiv").show();
						jQuery("#txtcnpfrmfrndlynm").val(data);
						jQuery('#txtcnpfrmfrndlynm').attr('readonly', true);

					}
					else if (data != "" && data == "SOAP") {
						jQuery("#spnverify").show();

					}
					else {
						jQuery("#spnverify").hide();
						alert("Sorry but I cannot find the Account Number, GUID combination.  Please verify and try again");
						jQuery("#txtcnpacntid").focus();

					}
				}
			});
		}
	});

});

function getActiveForms(campaigninc) {
	var campaignVal = jQuery("#lstcnpactivecamp" + campaigninc).val();
	var frndlynamarr = jQuery("#lstaccntfrndlynam").val().split('||');
	var cnpaccountid = frndlynamarr[0];
	var cnpaccountguid = frndlynamarr[1];
	var campainurl = jQuery("#cnphdnurl").val();
	jQuery.ajax({
		type: "POST",
		url: campainurl,
		data: { AccountId_val: cnpaccountid, AccountGUId_val: cnpaccountguid, CampaignId: campaignVal },
		success: function (data) {
			jQuery(".cnpformslst").show();
			jQuery("#lstcnpfrmtyp" + campaigninc).html(data);
			jQuery("#spncampnname" + campaigninc).text("");

		}
	});
}
function getEditActiveForms(campaigninc, fldnm, selform) {
	var campfldnm = "#" + fldnm + campaigninc;
	var campaignVal = jQuery(campfldnm).val();
	var frndlynamarr = jQuery("#lstaccntfrndlynam").val().split('||');
	var cnpaccountid = frndlynamarr[0];
	var cnpaccountguid = frndlynamarr[1];
	var campainurl = jQuery("#cnphdnediturl").val();

	jQuery.ajax({
		type: "POST",
		url: campainurl,
		data: { AccountId_val: cnpaccountid, AccountGUId_val: cnpaccountguid, CampaignId: campaignVal, sform: selform },
		success: function (data) {
			jQuery("#dvfdimg" + campaigninc).hide();

			if (data != "") {
				jQuery(".cnpformslst").show();
				jQuery("#lstcnpeditfrmtyp" + campaigninc).html(data);
				jQuery("#spncampnname" + campaigninc).text("");
				var fldnm = jQuery("#lstcnpeditfrmtyp" + campaigninc).find('option:selected').text();
				jQuery("#hdncnpformname" + campaigninc).val(fldnm);
				if (fldnm == "Select Form Name") {
					jQuery("#txtcnpguid" + campaigninc).val("");
					//jQuery("#txtcnpformstrtdt"+campaigninc).val("");
					jQuery("#txtcnpformenddt" + campaigninc).val("");
				}
			} else {
				jQuery("#lstcnpeditfrmtyp" + campaigninc).html("");
				jQuery("#txtcnpguid" + campaigninc).val("");
				jQuery("#txtcnpformstrtdt" + campaigninc).val("");
				jQuery("#txtcnpformenddt" + campaigninc).val("");
			}
		}
	});
}
function getActiveGUID(forminc) {

	var campaignVal = jQuery("#lstcnpfrmtyp" + forminc).val();
	var fldnm = jQuery("#lstcnpfrmtyp" + forminc).find('option:selected').text();
	var cnpfrmt = jQuery("#hdndatefrmt").val();
	if (campaignVal != "") {
		jQuery("#txtcnpguid" + forminc).val(campaignVal);
		jQuery("#hdncnpformname" + forminc).val(fldnm);
		var finc = forminc - 1;
		if (forminc == 1) {
			jQuery("#txtcnpformstrtdt" + forminc).val(jQuery("#txtcnpformstrtdt").val())
		}
		else {
			var chksdt = jQuery("#txtcnpformenddt" + finc).val();
			if (jQuery("#txtcnpformenddt" + finc).val() != "") {
				var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
				if (jQuery("#txtcnpformenddt" + finc).val().match(reg)) {
					var getdtfrmt = cnpfrmt.split(" ");
					if (getdtfrmt[0] != "MM/DD/YYYY") {
						var res = jQuery("#txtcnpformenddt" + finc).val().split(" ");
						var res1 = res[0].split("/");
						var res2 = res1[1] + "/" + res1[0] + "/" + res1[2];
						chksdt = res2 + " " + res[1] + " " + res[2];
					}
				}

			}
			var d = new Date(chksdt);
			if (d == "Invalid Date") {
				jQuery("#txtcnpformstrtdt" + forminc).val(jQuery("#txtcnpformstrtdt").val())
			}
			else {
				// var d = new Date(jQuery("#txtcnpformenddt"+finc).val());

				jQuery("#txtcnpformstrtdt" + forminc).datetimepicker({ format: cnpfrmt, defaultDate: new Date(d.setMinutes(d.getMinutes() + 1)) });
				jQuery('#txtcnpformenddt' + forminc).datetimepicker({ format: cnpfrmt });

			}
		}
	} else {
		jQuery("#txtcnpguid" + forminc).val("");
		jQuery("#txtcnpformstrtdt" + forminc).val("");
		jQuery("#txtcnpformenddt" + forminc).val("");
	}
}
function getEditActiveGUID(forminc) {

	var cnpfrmt = jQuery("#hdndatefrmt").val();
	var campaignVal = jQuery("#lstcnpeditfrmtyp" + forminc).val();
	var fldnm = jQuery("#lstcnpeditfrmtyp" + forminc).find('option:selected').text();

	if (campaignVal != "") {
		jQuery("#txtcnpguid" + forminc).val(campaignVal);
		jQuery("#hdncnpformname" + forminc).val(fldnm);
		jQuery("#spnformname" + forminc).text("");

		var finc = forminc - 1;
		if (forminc == 1) {
			jQuery("#txtcnpformstrtdt" + forminc).datetimepicker({ format: cnpfrmt, defaultDate: new Date() });
		}
		else {
			// var d = new Date(jQuery("#txtcnpformenddt"+finc).val());
			var chksdt = jQuery("#txtcnpformenddt" + finc).val();
			if (jQuery("#txtcnpformenddt" + finc).val() != "") {
				var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
				if (jQuery("#txtcnpformenddt" + finc).val().match(reg)) {
					var getdtfrmt = cnpfrmt.split(" ");
					if (getdtfrmt[0] != "MM/DD/YYYY") {
						var res = jQuery("#txtcnpformenddt" + finc).val().split(" ");
						var res1 = res[0].split("/");
						var res2 = res1[1] + "/" + res1[0] + "/" + res1[2];
						chksdt = res2 + " " + res[1] + " " + res[2];
					}
				}

			}
			var d = new Date(chksdt);
			if (d == "Invalid Date") {
				jQuery("#txtcnpformstrtdt" + forminc).datetimepicker({ format: cnpfrmt, defaultDate: new Date() });
			} else {

				jQuery("#txtcnpformstrtdt" + forminc).datetimepicker({ format: cnpfrmt, defaultDate: new Date(d.setMinutes(d.getMinutes() + 1)) });
				jQuery('#txtcnpformenddt' + forminc).datetimepicker({ format: cnpfrmt });

			}
		}
	} else {
		jQuery("#txtcnpguid" + forminc).val("");
		jQuery("#txtcnpformstrtdt" + forminc).val("");
		jQuery("#txtcnpformenddt" + forminc).val("");
	}
}
function clscnpdlgform() {
	//jQuery("#dialogForm").dialog("close");
	jQuery("#dialogForm,.Fader").fadeOut();
}
function svclscnpdlgform() {
	var cnprowpos = jQuery("#txturlparmsrowid").val();
	var asgnvaluu = "#txtbtnurlparms" + cnprowpos;
	var cnpparmlst = document.getElementById("txturlparms").value;
	jQuery("#txtbtnurlparms" + cnprowpos).val(jQuery.trim(cnpparmlst.replace(/^\s+|\s+$/gm, '')));
	jQuery("#cnpsuccess").html("");
	jQuery("#dialogForm,.Fader").fadeOut();
}
function cnpAddurlparameters(rowid) {

	jQuery(".cnpsuccess").remove();
	var cnpparmurl = document.getElementById("txtbtnurlparms" + rowid).value;
	if (cnpparmurl == "") {
		document.getElementById("txturlparms").value = "";
	}
	else {
		document.getElementById("txturlparms").value = cnpparmurl;
	}
	document.getElementById("txturlparmsrowid").value = rowid;
	jQuery("#dialogForm,.Fader").fadeIn();
	//Query("#dialogForm").dialog("open");
}
function getDeleteFormrows(rowid) {

	if (jQuery("#hidnoofforms").val() != 1) {
		var result = confirm("Are you sure want to delete?");
		if (result) {
			if (jQuery("#hidnoofforms").val() == 1) {
				jQuery("#cnpbtnsubmit").show();
				jQuery(".frmadddiv").hide();
				jQuery(".cnpfooter").hide();
			}

			var delvar = "#trfid" + rowid;
			jQuery(delvar).remove();
			//document.getElementById("cnpformslist").deleteRow(rowid);
			jQuery("#hidnoofforms").val(jQuery("#hidnoofforms").val() - 1);
			if (jQuery("#hidnoofforms").val() == 1) {
				jQuery("#cnpbtndelte").hide();
				var currowid = jQuery('input[type=hidden][name="hdncnpformcnt[]"]').val();
				//alert(jQuery('input[type=hidden][name="hdncnpformcnt[]"]').val());
				var cnpfrmt = jQuery("#hdndatefrmt").val();
				jQuery("#lstcnpactivecamp" + currowid).attr('name', 'lstcnpactivecamp1');
				jQuery("#lstcnpactivecamp" + currowid).attr('id', 'lstcnpactivecamp1');
				jQuery("#lstcnpfrmtyp" + currowid).attr('name', 'lstcnpfrmtyp1');
				jQuery("#lstcnpfrmtyp" + currowid).attr('id', 'lstcnpfrmtyp1');
				jQuery("#lstcnpactivecamp1").attr('onchange', 'getActiveForms(1)');
				jQuery("#lstcnpfrmtyp1").attr('onchange', 'getActiveGUID(1)');

				jQuery("#lstcnpeditactivecamp" + currowid).attr('name', 'lstcnpeditactivecamp1');
				jQuery("#lstcnpeditactivecamp" + currowid).attr('id', 'lstcnpeditactivecamp1');
				jQuery("#lstcnpeditfrmtyp" + currowid).attr('name', 'lstcnpeditfrmtyp1');
				jQuery("#lstcnpeditfrmtyp" + currowid).attr('id', 'lstcnpeditfrmtyp1');
				jQuery("#lstcnpeditactivecamp1").attr('onchange', 'getEditActiveForms(1,"lstcnpeditactivecamp","")');
				jQuery("#lstcnpeditfrmtyp1").attr('onchange', 'getEditActiveGUID(1)');
				jQuery("#txtcnpguid" + currowid).attr('name', 'txtcnpguid1');
				jQuery("#txtcnpguid" + currowid).attr('id', 'txtcnpguid1');
				jQuery("#txtcnpformstrtdt" + currowid).attr('name', 'txtcnpformstrtdt1');
				jQuery("#txtcnpformstrtdt" + currowid).attr('id', 'txtcnpformstrtdt1');
				jQuery("#txtcnpformenddt" + currowid).attr('name', 'txtcnpformenddt1');
				jQuery("#txtcnpformenddt" + currowid).attr('id', 'txtcnpformenddt1');
				jQuery('input[type=hidden][name="hdncnpformcnt[]"]').val(1);
				jQuery("#txtcnpformstrtdt1").datetimepicker({ format: cnpfrmt, defaultDate: new Date() });
				jQuery("#txtcnpformenddt1").datetimepicker({ format: cnpfrmt, defaultDate: new Date() });
			}
		}

	}

}
function getDeletechannelrows(rowid) {
	if (jQuery("#hidnoofforms").val() != 1) {
		var result = confirm("Are you sure want to delete?");
		if (result) {
			if (jQuery("#hidnoofforms").val() == 1) {
				jQuery("#cnpbtnsubmit").show();
				jQuery(".frmadddiv").hide();
				jQuery(".cnpfooter").hide();
			}
			var delvar = "#trid" + rowid;
			//document.getElementById("cnpformslist").deleteRow(rowid);
			jQuery(delvar).remove();
			jQuery("#hidnoofforms").val(jQuery("#hidnoofforms").val() - 1);
			if (jQuery("#hidnoofforms").val() == 1) {
				jQuery("#cnpbtndelte").hide();
				var currowid = rowid + 1;
				jQuery('input[type=hidden][name="hdncnpformcnt[]"]').val(1);
				jQuery("#lstcnpeditactivecamp" + currowid).attr('name', 'lstcnpeditactivecamp1');
				jQuery("#lstcnpeditactivecamp" + currowid).attr('id', 'lstcnpeditactivecamp1');
				jQuery("#txtcnpformstrtdt" + currowid).attr('name', 'txtcnpformstrtdt1');
				jQuery("#txtcnpformstrtdt" + currowid).attr('id', 'txtcnpformstrtdt1');
				jQuery("#txtcnpformenddt" + currowid).attr('name', 'txtcnpformenddt1');
				jQuery("#txtcnpformenddt" + currowid).attr('id', 'txtcnpformenddt1');
			}

		}

	}

}
function getDeleteFormchangerows() {
	jQuery("#lstcnpfrmtyp1").html('');
	jQuery('#lstcnpfrmtyp1').append('<option value="">Select Form Name</option>');
	jQuery("#txtcnpguid1").val("");
	jQuery("#txtcnpformstrtdt1").val("");
	jQuery("#txtcnpformenddt1").val("");
	jQuery('#cnpformslist > tbody tr:not(:first)').remove();
}
function getDeleteChannelchangerows() {
	jQuery("#txtcnpchnlstrtdt1").val("");
	jQuery("#txtcnpchnlenddt1").val("");
	jQuery('#cnpformslist > tbody tr:not(:first)').remove();
}
function getEditActiveCampaigns(campaigninc, selcampaign) {

	var frndlynamarr = jQuery("#lstaccntfrndlynam").val().split('||');
	var cnpeaccountid = frndlynamarr[0];
	var cnpeaccountguid = frndlynamarr[1];
	var editcampainurl = jQuery("#cnphdnediturl").val();

	jQuery.ajax({
		type: "POST",
		url: editcampainurl,
		data: { AccountId_val: cnpeaccountid, AccountGUId_val: cnpeaccountguid, slcamp: selcampaign },
		success: function (data) {
			jQuery(".cnpformslst").show();
			jQuery("#dvldimg" + campaigninc).hide();
			jQuery("#lstcnpeditactivecamp" + campaigninc).html(data);
		}
	});
}
function getEditActiveChannels(channelinc, selchannel) {

	var frndlynamarr = jQuery("#lstaccntfrndlynam").val().split('||');
	var cnpeaccountid = frndlynamarr[0];
	var cnpeaccountguid = frndlynamarr[1];
	var editcampainurl = jQuery("#cnphdnediturl").val();
	var cnpfrmt = jQuery("#hdndatefrmt").val();
	var campaignVal = jQuery("#lstcnpeditactivecamp" + channelinc).val();
	jQuery.ajax({
		type: "POST",
		url: editcampainurl,
		data: { AccountId_val: cnpeaccountid, AccountGUId_val: cnpeaccountguid, slcamp: selchannel },
		success: function (data) {
			jQuery(".cnpformslst").show();
			jQuery("#dvldimg" + channelinc).hide();
			jQuery("#lstcnpeditactivecamp" + channelinc).html(data);




			if (campaignVal != "") {

				var finc = channelinc - 1;
				if (channelinc == 1) {
					jQuery("#txtcnpformstrtdt" + channelinc).datetimepicker({ format: cnpfrmt, defaultDate: new Date() });
				}
				else {
					// var d = new Date(jQuery("#txtcnpformenddt"+finc).val());
					var chksdt = jQuery("#txtcnpformenddt" + finc).val();
					if (jQuery("#txtcnpformenddt" + finc).val() != "") {
						var reg = /(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d/;
						if (jQuery("#txtcnpformenddt" + finc).val().match(reg)) {
							var getdtfrmt = cnpfrmt.split(" ");
							if (getdtfrmt[0] != "MM/DD/YYYY") {
								var res = jQuery("#txtcnpformenddt" + finc).val().split(" ");
								var res1 = res[0].split("/");
								var res2 = res1[1] + "/" + res1[0] + "/" + res1[2];
								chksdt = res2 + " " + res[1] + " " + res[2];
							}
						}

					}
					var d = new Date(chksdt);
					if (d == "Invalid Date") {
						jQuery("#txtcnpformstrtdt" + channelinc).datetimepicker({ format: cnpfrmt, defaultDate: new Date() });
					} else {
						jQuery("#txtcnpformstrtdt" + channelinc).datetimepicker({ format: cnpfrmt, defaultDate: new Date(d.setMinutes(d.getMinutes() + 1)) });
						jQuery('#txtcnpformenddt' + channelinc).datetimepicker({ format: cnpfrmt });

					}
				}
			}






		}
	});
}
function AvoidSpace(event) {
	var k = event ? event.which : window.event.keyCode;
	//if (k == 32 ) return false;
	if ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57)) { return true; } else { return false; }

}
function getFormattedDate(date) {
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear().toString().slice(2);
	return day + '-' + month + '-' + year;
}
function mycnpaccountId(cnpaccountid) {

	var result = confirm("I am refreshing the account information, please wait");
	if (result == true) {
		var accntid = jQuery("#hdncnpaccntid" + cnpaccountid).val();
		var guid = jQuery("#hdncnpguid" + cnpaccountid).val();
		var url = jQuery("#cnphdnerrurl").val();
		var setid = jQuery("#hdnsetngsid" + cnpaccountid).val();
		var tblnm = jQuery("#hdncnptblname").val();


		if (accntid !== "") {
			jQuery.ajax({
				type: "POST",
				url: url,
				data: { AccountId_val: accntid, AccountGUId_val: guid, verfication: setid, cnptblnm: tblnm },
				success: function (data) {
					if (data == "true") {
						alert("All account information has been updated.  Please click OK to continue.");
						location.reload();

					}
					else {
						alert("Sorry but I cannot find the Account Number, GUID combination.  Please verify and try again");
						return false;
					}
				}
			});
		}
	}
}