<?php
ob_start();
if ( ! defined( 'ABSPATH' ) ) exit;
function cnps_addchannel() {

if(isset($_POST["cnpchnlbtnsave"]))
{ 
	$addform= wp_unslash( sanitize_text_field( $_POST["addchannelval"]));
	global $wpdb;
	global $cnp_channelgrptable_name;
   	if($addform==1)
	{
		$cnprtnval = CNPCF_addNewChannel($cnp_channelgrptable_name,$_POST);
		if($cnprtnval == true){$cnpredirectval = "saved";}else{$cnpredirectval = "failed";}
		wp_redirect("admin.php?page=cnp_pledgetvchannelsdetails&info=".$cnpredirectval);
		exit;
	}
	else if($addform==2)
	{ 
		$cnprtnval =CNPCF_updateChannels($cnp_channelgrptable_name,$_POST);
		if($cnprtnval == true){$cnpredirectval = "upd";}else{$cnpredirectval = "failed";}
		wp_redirect("admin.php?page=cnp_pledgetvchannelsdetails&info=".$cnpredirectval);
		exit;
	}

}   $dsplycntnt ="";
	$cnpaccountfriendlynams = CNPCF_getAccountIdList();
	$cnpsettingscount       = CNPCF_getAccountNumbersCount();
   if($cnpsettingscount==1){$dsplycntnt = 'class="disabled"';}
	$hidval	   = 1;
	$act       = wp_unslash( sanitize_text_field( $_REQUEST["cnpviewid"] ) );
	if(isset($act) && $act!="")
	{
		global $wpdb;
		global $cnp_channelgrptable_name;
		global $cnp_channeltable_name;
		$cnpviewid = wp_unslash( sanitize_text_field( $_GET['cnpviewid'] ) );
		$cnpfrmdtresult    = CNPCF_GetCnPGroupDetails($cnp_channelgrptable_name,'cnpchannelgrp_ID',$cnpviewid);
		$cnpfrmrtnval      = CNPCF_GetCnPGroupDetails($cnp_channeltable_name,'cnpchannel_cnpchannelgrp_ID',$cnpviewid);
		foreach ($cnpfrmdtresult as $cnprtnval) {}

	 if (count($cnpfrmdtresult)> 0 )
		 {


				$cnpchnlid             = $cnprtnval->cnpchannelgrp_ID;
				$cnpchnlgroupname      = $cnprtnval->cnpchannelgrp_groupname;
				$cnpchnlAccountNumber  = $cnprtnval->cnpchannelgrp_cnpstngs_ID;
				$cnpfrmshortcode       = $cnprtnval->cnpchannelgrp_shortcode;
				$cnpfrmStartDate       = $cnprtnval->cnpchannelgrp_channel_StartDate;
				$cnpfrmEndDate         = $cnprtnval->cnpchannelgrp_channel_EndDate;
			    $cnpchnlerrmsg         = $cnprtnval->cnpchannelgrp_custommsg;
		 		if($cnpfrmEndDate == "0000-00-00 00:00:00") {$cnpfrmEndDate ="";}
				$cnpfrmstatus          = $cnprtnval->cnpchannelgrp_status;
				$btn	               = "Update form";
				$hidval	               = 2;

				$cnpeditaccountfriendlynams = CNPCF_editgetAccountIdList($cnpchnlAccountNumber);

		}

	$cnpeditdsplycntnt ='
	<div xmlns="http://www.w3.org/1999/xhtml" class="wrap nosubsub">
	<div class="icon32" id="icon-edit"><br/></div>
<h2>Edit Channel Group</h2><div class="dataTables_paginate" ><a href="admin.php?page=cnp_pledgetvchannelsdetails"><strong>Go back to Channels </strong></a></div>
<div id="col-left">
	<div class="col-wrap">
		<div>
			<div class="form-wrap">
				<form class="validate"  method="post" id="addchnl" name="addchnl" enctype="multipart/form-data">
	<input type="hidden" name="cnphdnediturl" id="cnphdnediturl" value="'.CNP_CF_PLUGIN_URL.'getcnpactivechannels.php">
	<input type="hidden" name="hdnfrmid" id="hdnfrmid" value="'.$cnpchnlid .'">
	<input type="hidden" name="hdndatefrmt" id="hdndatefrmt" value="'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT .'">
	<input type="hidden" name="hdnchnlstrtdt" id="hdnchnlstrtdt" value="'.$cnpfrmStartDate.'">
	<input type="hidden" name="hdnchnlenddt" id="hdnchnlenddt" value="'.$cnpfrmEndDate.'">

				<div class="form-field cnpaccountId">
						<label for="tag-name">Channel Group Name*</label>
						<input type="text" size="40" id="txtcnpedchnlgrp" name="txtedcnpchnlgrp" value="'.$cnpchnlgroupname.'" onkeypress="return AvoidSpace(event)" readonly/>
						<span class=cnperror id="spncnpchnlgrpnm"></span>
					</div>
					<div class="form-field cnplstfrndlyname" >
						<label for="tag-name">Account(s)*</label>
						<select name="lstaccntfrndlynam" id="lstaccntfrndlynam" disabled>
						'.$cnpeditaccountfriendlynams.'</select>
						<p></p>
					</div>

					<div class="input-group date form-field cnpfrmstrtdt" >
						<label for="tag-name">Start Date & Time* [Time Zone: '.  wp_get_timezone_string().']</label>
						<input type="text" size="40" id="txtcnpchnlstrtdt" name="txtcnpchnlstrtdt"  />
						<span class=cnperror id="spncnpchnlstrtdt"></span>
					</div>
					<div class="input-group date form-field cnpfrmenddt" >
						<label for="tag-name">End Date & Time</label>
						<input type="text" size="40" id="txtcnpchnlenddt" name="txtcnpchnlenddt"/>
						<span class=cnperror id="spncnpchnlenddt"></span>
					</div>
					
					<div class="form-field cnpfrmerror">
						<label for="tag-name">No Valid Channel Message</label>

						<textarea id="txterrortxt" name="txterrortxt">'.$cnpchnlerrmsg.'</textarea>
						<p></p>
					</div>
					<div class="form-field cnplstfrmsts" >
						<label for="tag-name">Status</label>
						<select name="lstchnlsts" id="lstchnlsts">';
						$cnpeditdsplycntnt .='<option value="1"'; if($cnpfrmstatus == "1"){$cnpeditdsplycntnt .= 'selected';} $cnpeditdsplycntnt .=' >Active</option>
						<option value="0"'; if($cnpfrmstatus == "0"){$cnpeditdsplycntnt .= 'selected';} $cnpeditdsplycntnt .='>Inactive</option>
						</select>
						<p></p>
					</div>
					<p class="submit">';

					$frmscount = count($cnpfrmrtnval);
					if($frmscount > 0){

						$cnpimgurl = plugins_url(CFCNP_PLUGIN_NAME."/images/ajax-loader_trans.gif");
					$cnpeditdsplycntnt .='<input type="hidden" name="addchannelval" id="addchannelval" value='.$hidval.'>
					<input type="hidden" name="hidnoofforms" id="hidnoofforms" value='.$frmscount.'>

					 <input type="hidden" name="cnphdneditchnlaccountId" id="cnphdneditchnlaccountId" value="'.$cnpchnlAccountNumber.'">
					
					</p><div style="float:left"  width="100%">
					<div class=" frmadddiv">
					<p>1. Select your Channel, enter a start date and click SAVE.</p><p>
					2. Copy the "shortcode" from pledgeTV Channels page, to your WordPress page.
					Multiple Channels may be added. Channels will display in order of start date. If start dates overlap, the first Channel in the list will show first.</p><p></p>
			        <table class="wp-list-table widefat" id="cnpformslist" >
					<thead><tr><th><strong>Channel</strong>*</th><th><strong>Start Date</strong>*</th><th><strong>End Date</strong></th><th></th></tr>
						</thead><tbody>';
						$frminc =1;
						foreach($cnpfrmrtnval as $cnpfrmlst){
						 $frmsenddt = $cnpfrmlst->cnpchannel_channelEndDate;
						if($frmsenddt == "0000-00-00 00:00:00") {$frmsenddt ="";}
						$cnpeditdsplycntnt .=' <tr id="trid'.$frminc.'"><td><u><input type="hidden" name="hdncnpformcnt[]" id="hdncnpformcnt[]" value="'.$frminc.'"><input type="hidden" name="hdneditfrmid'.$frminc.'" id="hdneditfrmid'.$frminc.'" value="'.$cnpfrmlst->cnpchannel_id .'"><input type="hidden" name="cnphdneditlstcnpactivecamp'.$frminc.'" id="cnphdneditlstcnpactivecamp'.$frminc.'" value="'.$cnpfrmlst->cnpchannel_channelName.'"><select name="lstcnpeditactivecamp'.$frminc.'" id="lstcnpeditactivecamp'.$frminc.'" class="cnp_campaigns_select" ><option value="">Select Channel</option></select></u><div id="dvldimg'.$frminc.'" class="cnp_loader"><img src="'.$cnpimgurl.'" alt="Loading" /></div><span class=cnperror id="spncampnname'.$frminc.'"></span></td>
						
				        <td  ><u>
						<input type="hidden" name="hdncnpformstrtdt'.$frminc.'" id="hdncnpformstrtdt'.$frminc.'" value="'.$cnpfrmlst->cnpchannel_channelStartDate.'">
						<input type="hidden" name="hdncnpformenddt'.$frminc.'" id="hdncnpformenddt'.$frminc.'" value="'.$frmsenddt.'">
						<input type="text" size="20" id="txtcnpformstrtdt'.$frminc.'" name="txtcnpformstrtdt'.$frminc.'"/></u><span class=cnperror id="spnstrtdt'.$frminc.'"></span></td>
						<td ><input type="text" size="20" id="txtcnpformenddt'.$frminc.'" name="txtcnpformenddt'.$frminc.'" /><span class=cnperror id="spnenddt'.$frminc.'"></span></td>
						<td><u>';
						//if($frminc != 1 || $frmscount !=1){
							$cnpeditdsplycntnt .='<a href="#" onclick="getDeletechannelrows('.$frminc.')"><span class="dashicons dashicons-trash" name="cnpbtndelte" id="cnpbtndelte"  style="text-decoration:none !important"></span></a>';
							//}
							 $cnpeditdsplycntnt .='</u></td></tr>';
						  $frminc++;
						}
						  $cnpeditdsplycntnt .='</tbody></table>
						  <div><table class="wp-list-table widefat" id="ist" >
						 <tr><td>
						 <div style="float:right">
						 <input type="button" name="cnpbtncadd" id="cnpbtncadd" value="Add Channel" class="add-new-h2"><div >
						 </td></tr>
						 </table>
						 </div>
						 <div style="text-align-last:center;">
						 <div>

						 <input type="button" name="cnpbtnedit" id="cnpbtnedit" value="Close" class="add-new-h2" onclick="window.history.go(-1); return false;">
						 <input type="submit" name="cnpchnlbtnsave" id="cnpchnlbtnsave" value="Save" class="add-new-h2">  <div class="dataTables_paginate" ><a href="admin.php?page=cnp_pledgetvchannelsdetails"><strong>Go back to Channels</strong></a></div>
						 </div></div>
						 </div>';
						 }
						$cnpeditdsplycntnt .='</form>
			</div>
		</div>
	</div>
</div></div>
</div>';
echo $cnpeditdsplycntnt;
	}
	else
	{

$cnpdsplycntnt ='<div xmlns="http://www.w3.org/1999/xhtml" class="wrap nosubsub">
<div class="icon32" id="icon-edit"><br/></div>
<h2>Add Channel Group</h2>
<div id="col-left">
	<div class="col-wrap">
		<div>
			<div class="form-wrap">
				<h3>'.$btn.'</h3>
				<form class="validate"  method="post" id="addchnl" name="addchnl" enctype="multipart/form-data">
				<input type="hidden" name="cnpchdnurl" id="cnpchdnurl" value="'.CNP_CF_PLUGIN_URL.'getcnpactivechannels.php">
			
				<input type="hidden" name="hdncdatefrmt" id="hdncdatefrmt" value="'.CFCNP_PLUGIN_CURRENTDATETIMEFORMAT .'">
				<div class="form-field cnpfrmgrp">
						<label for="tag-name">Channel Group Name*</label>
						<input type="text" size="40" id="txtcnpchnlgrp" name="txtcnpchnlgrp" onkeypress="return AvoidSpace(event)"/>
						<p>Please enter the channel group name</p><span class=cnperror id="spncnpchnlgrpnm"></span>
					</div>
					<div class="form-field cnplstfrndlyname" >
						<label for="tag-name">Account(s)*</label>
						<select name="lstchnlaccntfrndlynam" id="lstchnlaccntfrndlynam"'.$dsplycntnt.' >
						'.$cnpaccountfriendlynams.'</select>
						<p></p>
					</div>

					<div class="input-group date form-field cnpfrmstrtdt" >
						<label for="tag-name">Start Date & Time* [Time Zone: '. wp_get_timezone_string().']</label>
						<input type="text" size="40" id="txtcnpchnlstrtdt" name="txtcnpchnlstrtdt" />
						<span class=cnperror id="spncnpchnlstrtdt"></span>
					</div>
					
					<div class="input-group date form-field cnpfrmenddt" >
						<label for="tag-name">End Date & Time</label>
						<input type="text" size="40" id="txtcnpchnlenddt" name="txtcnpchnlenddt" />
						<span class=cnperror id="spncnpchnlenddt"></span>
					</div>
					
   					
					<div class="form-field cnplstfrmsts" >
						<label for="tag-name">No Valid Channel Message</label>
						<textarea id="txtchnlerrortxt" name="txtchnlerrortxt" >Sorry! This channel is expired</textarea>
					<p></p>
					</div>
					<div class="form-field cnplstfrmsts" >
						<label for="tag-name">Status</label>
						<select name="lstchnlsts" id="lstchnlsts"><option value="1">Active</option>
						<option value="0">Inactive</option></select>
						<p></p>
					</div>
					<p class="submit">

						<input type="button" value="Save" class="button-primary" id="cnpachnlbtnsubmit" name="cnpachnlbtnsubmit" class="add-new-h2"/>
						<input type="button" name="cnpbtnchnlcancel" id="cnpbtnchnlcancel" value="Cancel" class="button-primary" onclick="window.history.go(-1); return false;">

					<input type="hidden" name="addchannelval" id="addchannelval" value='.$hidval.'>
					<input type="hidden" name="hidnoofforms" id="hidnoofforms">
					<input type="hidden" name="hdncnpformname1" id="hdncnpformname1">
					</p>

					<div style="float:left"  width="100%">
					<div class="chnladddiv" style ="display:none">
					<p>1. Select your Channel, enter a start date and click SAVE.</p><p>
2. Copy the "shortcode" from pledgeTV Channels page, to your WordPress page.
Multiple Channels may be added. Channels will display in order of start date. If start dates overlap, the first Channel in the list will show first.

</p><p></p>

			              <table class="wp-list-table widefat" id="cnpformslist" >
						  <thead><tr><th><strong>Channel</strong>*</th><th><strong>Start Date</strong>*</th><th><strong>End Date</strong></th><th></th></tr>
						  </thead><tbody>
						  <tr id="trid1"><td><u><input type="hidden" name="hdncnpchnlcnt[]" id="hdncnpchnlcnt[]" value=1><select name="lstcnpactivechannel1" id="lstcnpactivechannel1"  class="cnp_forms_select"><option value="">Select Channel</option></select></u><span class=cnperror id="spncampnname1"></span></td>
						  
				          <td><div class="input-group date" id="datetimepicker3"><input type="text" size="20" id="txtcnpchnlstrtdt1" name="txtcnpchnlstrtdt1"/><span class=cnperror id="spnstrtdt1"></span></div></td>
						  <td><div class="input-group date" id="datetimepicker4"><input type="text" size="20" id="txtcnpchnlenddt1" name="txtcnpchnlenddt1"/><span class=cnperror id="spnenddt1"></span></div></td>
						  <td><u><a href="#" onclick="getDeletechannelrows(1)"><span class="dashicons dashicons-trash" name="cnpbtndelte" id="cnpbtndelte"  style="text-decoration:none !important"></span></a></u></td></tr>
						  </tbody></table>
						  <div><table class="wp-list-table widefat" id="ist" >
						 <tr><td>
						 <div style="float:right">
						 <input type="button" name="cnpbtncadd" id="cnpbtncadd" value="Add Channel" class="add-new-h2"><div>
						 </td></tr>
						 </table>
						 </div>
						 <div style="text-align-last:center;">
						 <div>
<br>
						 <input type="button" name="cnpbtnclose" id="cnpbtnclose" value="Close" class="add-new-h2" onclick="window.history.go(-1); return false;">
						 <input type="submit" name="cnpchnlbtnsave" id="cnpchnlbtnsave" value="Save" class="add-new-h2">

						 </div></div>
						 </div>
						</form>
			        </div>
		        </div>
	         </div>
         </div>
      ';
echo $cnpdsplycntnt;
}
 }
ob_clean();
?>
