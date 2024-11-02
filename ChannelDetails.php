<?php
function cnp_channeldetails() {

	global $wpdb;    global $cnp_channeltable_name;global $cnp_channelgrptable_name; global $cnp_settingtable_name;
	$info          = $_REQUEST["info"];
    $cnpresltdsply = "";
	if($info=="saved")
	{
		echo "<div class='updated' id='message'><p><strong>Form Added</strong>.</p></div>";
	}
	if($info=="failed")
	{
		echo "<div class='updated' id='message'><p><strong>Already Existed</strong>.</p></div>";
	}
	if($info=="upd")
	{
		echo "<div class='updated' id='message'><p><strong>Form updated</strong>.</p></div>";
	}
	if($info=="del")
	{
		$delid=$_GET["did"];
		$wpdb->query("delete from ".$cnp_channeltable_name." where cnpchannel_id =".$delid);
		echo "<div class='updated' id='message'><p><strong>Record Deleted.</strong>.</p></div>";
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
<?php   /*<td nowrap><u><a href="admin.php?page=cnpform_add&cnpid='.$id.'"">Edit</a></u></td> <th></th>*/
		$cnpfrmid = $_REQUEST['cnpviewid']; 
		$rcnpid   = $_REQUEST['cnpid']; 
		$cnpresltdsply = '<div class="wrap">
			              <h2>View Channels &nbsp;&nbsp;&nbsp;</h2><p></p>
			              <table class="wp-list-table widefat" id="cnpformslist" ><thead><tr><th><u>ID</u></th><th><u>Channel</u></th><th><u>Start Date/Time</u></th><th><u>End Date/Time</u></th><th></th></tr></thead><tbody>';

		 $sql          = "select * from ".$cnp_channeltable_name." join ".$cnp_channelgrptable_name." on  cnpchannelgrp_ID = cnpchannel_cnpchannelgrp_ID join ".$cnp_settingtable_name ." on cnpstngs_ID = cnpchannelgrp_cnpstngs_ID where cnpchannel_cnpchannelgrp_ID ='".$cnpfrmid."'  order by cnpchannel_id desc";
		 $result       = $wpdb->get_results($sql);
	
		 if($wpdb->num_rows > 0 )
		 { $sno=1;
			foreach($result as $cnpchannelData):
	 
				$id               = $cnpchannelData->cnpchannel_id;
			    $cnpfrmid         = $cnpchannelData->cnpchannel_cnpchannelgrp_ID;
				$cname            = $cnpchannelData->cnpchannel_channelName;
			
				$stdate           = $cnpchannelData->cnpchannel_channelStartDate;
			 	$eddate           = $cnpchannelData->cnpchannel_channelEndDate;
		        $seldate          = $cnpchannelData->cnpchannel_DateCreated;
		   $frmstdate = new DateTime($stdate);
		   $frmeddate = new DateTime($eddate);
		  $isexistpledgetvchannel = isexistpledgetvchannel($cnpchannelData->cnpstngs_AccountNumber,$cnpchannelData->cnpstngs_guid,$cnpchannelData->cnpchannel_channelName);
		  
		  if($isexistpledgetvchannel != "no"){
			  $rtrnval = explode("~",$isexistpledgetvchannel);
			  $cname = $rtrnval[1]." (".$cname.")";
		  }
			 	if($eddate == "0000-00-00 00:00:00") {$eddate ="";}
		   		if($eddate!=""){
				 $eddate = new DateTime($eddate);
				 $nwenddt = $eddate->format(CFCNP_PLUGIN_CURRENTDATETIMEFORMATPHP);}
				$cnpresltdsply .= '<tr><td>'.$sno.'</td><td >'.$cname.'</td><td  >'.$frmstdate->format(CFCNP_PLUGIN_CURRENTDATETIMEFORMATPHP).'</td>
				<td  >'.$nwenddt.'</td><td nowrap>';	
		  if($isexistpledgetvchannel == "no"){
			$cnpresltdsply .= '<font color="red"><strong>Channel has been deleted from Connect</strong></font>';  
		  }else{
				if(count($result)!= 1){
				$cnpresltdsply .= '<u><a href="admin.php?page=cnp_channeldetails&cnpviewid='.$cnpfrmid.'&cnpid='.$rcnpid.'&info=del&did='.$id.'" ><span class="dashicons dashicons-trash"></span></a></u>';
					}else{$cnpresltdsply .= '&nbsp;';}}
		
		  $cnpresltdsply .= '</td></tr>';
		  $sno++;
			endforeach; 
	     } 
		 else {  $cnpresltdsply .= '<tr><td>No Record Found!</td><tr>';  }
		
		 $cnpresltdsply .= '</tbody></table></div><div class="dataTables_paginate" ><a href="admin.php?page=cnp_pledgetvchannelsdetails"><strong>Go back to Channels</strong></a></div>';
		 echo $cnpresltdsply ;
}
?>