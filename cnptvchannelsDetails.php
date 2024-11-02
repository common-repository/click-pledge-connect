<?php
function cnp_pledgetvchannelsdetails() {

	global $wpdb;    global $cnp_channelgrptable_name;global $cnp_channeltable_name;global $cnp_settingtable_name;
	$info          = $_REQUEST["info"];
    $cnpresltdsply = "";
	if($info=="saved")
	{
		echo "<div class='updated' id='message'><p><strong>Channel Added</strong>.</p></div>";
	}
	if($info=="failed")
	{
		echo "<div class='updated' id='message'><p><strong>Already Existed</strong>.</p></div>";
	}
	if($info=="upd")
	{
		echo "<div class='updated' id='message'><p><strong>Channel updated</strong>.</p></div>";
	}
	if($info=="sts")
	{
		echo "<div class='updated' id='message'><p><strong>Status updated</strong>.</p></div>";
	}
	if($info=="del")
	{
		$delid=$_GET["did"];
		$wpdb->query("delete from ".$cnp_channelgrptable_name." where cnpchannelgrp_ID =".$delid);
		echo "<div class='updated' id='message'><p><strong>Record Deleted.</strong>.</p></div>";
	}
	if(isset($_GET['cnpsts']) && $_GET['cnpsts']  !="")
	{	
		$cnpstsrtnval = CNPCF_updateCnPstatus($cnp_channelgrptable_name,'cnpchannelgrp_status','cnpchannelgrp_ID',$_GET['cnpviewid'],$_GET['cnpsts']);
		if($cnpstsrtnval == true){$cnpredirectval = "sts";}else{$cnpredirectval = "stsfail";}
		wp_redirect("admin.php?page=cnp_pledgetvchannelsdetails&info=".$cnpredirectval);
		exit;
	}

?>
<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery('#cnpformslist').dataTable();
		jQuery("tr:even").css("background-color", "#f1f1f1");
	});
	/* ]]> */

</script>
<?php
		$cnpresltdsply = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><div class="wrap">
			              <h2>pledgeTV<sup class="cnpc-regsymbol">&reg;</sup> Channels &nbsp;&nbsp;&nbsp;<a class="page-title-action add-new-h2" href="admin.php?page=cnps_addchannel&act=add">Add New Channel Group</a></h2><p></p>
			              <table class="wp-list-table widefat cnp_table_w" id="cnpformslist" ><thead><tr><th>Group Name</th><th>Account #</th><th>Short Code&nbsp;<a class="tooltip" ><i class="fa fa-question-circle"></i><span class="tooltiptext">Please copy this code and place it in your required content pages, posts or any custom content types. This code will run the series of the channels which has been added to this particular channel Group inside your content page.</span></a></th><th>Start Date/Time</th><th>End Date/Time</th><th>Active Channel(s)</th><th>Last Modified</th><th>Status</th><th>Actions</th></tr></thead><tbody>';

		  $sql          = "select * from ".$cnp_channelgrptable_name." join ".$cnp_settingtable_name." on cnpchannelgrp_cnpstngs_ID= cnpstngs_ID order by cnpchannelgrp_ID desc";
		 $result        = $wpdb->get_results($sql);
		 if($wpdb->num_rows > 0 )
		 {
			foreach($result as $cnpformData):
	        //<td nowrap><u><a href="admin.php?page=cnpform_add&cnpid='.$id.'"">Edit</a></u></td>
			    $nwenddt="";
				$cnpform_id     = $cnpformData->cnpchannelgrp_ID;
				$gname          = $cnpformData->cnpchannelgrp_groupname;
				$account        = $cnpformData->cnpstngs_AccountNumber;
				$frmstrtdt      = $cnpformData->cnpchannelgrp_channel_StartDate;
				$frmenddt       = $cnpformData->cnpchannelgrp_channel_EndDate;
			 	if($frmenddt == "0000-00-00 00:00:00") {$frmenddt ="";}
		  	
		  		$frmshrtcode    = $cnpformData->cnpchannelgrp_shortcode;
			  	 $stdate        = new DateTime($frmstrtdt);
			 if($frmenddt!=""){
				 $eddate       = new DateTime($frmenddt);
				 $nwenddt      = $eddate->format(CFCNP_PLUGIN_CURRENTDATETIMEFORMATPHP);}
			  $mddate          = new DateTime($cnpformData->cnpchannelgrp_Date_Modified);
			  $frmmodifiddt    = date_format(date_create($cnpformData->cnpchannelgrp_Date_Modified),"d-m-Y H:i:s");
			  $frmstrtddt      = date_format(date_create($cnpformData->cnpchannelgrp_channel_StartDate),"d-m-Y H:i:s");
				$frmsts        = CNPCF_getfrmsts($cnp_channelgrptable_name,'cnpchannelgrp_status','cnpchannelgrp_ID',$cnpform_id);
			 if($frmenddt!=""){
			    	if(strtotime($frmenddt) < strtotime(CFCNP_PLUGIN_CURRENTTIME)){
					$frmsts ="Expired";
					}
			 }
				$noofchannels      = CNPCF_getCountChannels($cnpform_id);
				$cnpresltdsply .= '<tr><td>'.$gname.'</td><td>'.$account.'</td><td>'.$frmshrtcode.'</td><td data-sort="'.strtotime($frmstrtddt).'">'.$stdate->format(CFCNP_PLUGIN_CURRENTDATETIMEFORMATPHP).'</td><td>'.$nwenddt.'</td><td align="center">'.$noofchannels.'</td><td data-sort="'.strtotime($frmmodifiddt).'">'.$mddate->format(CFCNP_PLUGIN_CURRENTDATETIMEFORMATPHP).'</td>
								   <td><a href="admin.php?page=cnp_pledgetvchannelsdetails&cnpsts='.$frmsts.'&cnpviewid='.$cnpform_id.'"">'.$frmsts.'</a></td>
								   <td><a href="admin.php?page=cnp_channeldetails&cnpviewid='.$cnpform_id.'""><span class="dashicons dashicons-visibility"></span></a> |  <a href="admin.php?page=cnps_addchannel&act=edit&cnpviewid='.$cnpform_id.'""><span class="dashicons dashicons-edit"></span></a> |  <a href="admin.php?page=cnp_pledgetvchannelsdetails&info=del&did='.$cnpform_id.'" ><span class="dashicons dashicons-trash"></span></a></td></tr>';
			endforeach; 
	     } 
		 else {$cnpresltdsply .= '<tr><td>No Record Found!</td><tr>';}
		
		 $cnpresltdsply .= '</tbody></table></div>';
		 echo $cnpresltdsply ;
}
?>