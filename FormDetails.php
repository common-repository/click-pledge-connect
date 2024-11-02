<?php
function cnp_formdetails() {

	global $wpdb;    global $cnp_formtable_name;
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
		$wpdb->query("delete from ".$cnp_formtable_name." where cnpform_ID =".$delid);
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
			              <h2>View Forms &nbsp;&nbsp;&nbsp;</h2><p></p>
			              <table class="wp-list-table widefat" id="cnpformslist" ><thead><tr><th><u>ID</u></th><th><u>Campaign Name</u></th><th><u>Form Name</u></th><th><u>GUID</u></th><th><u>Start Date/Time</u></th><th><u>End Date/Time</u></th><th></th></tr></thead><tbody>';

		 $sql          = "select * from ".$cnp_formtable_name." where cnpform_cnpform_ID ='".$cnpfrmid."'  order by cnpform_id desc";
		 $result       = $wpdb->get_results($sql);
		 if($wpdb->num_rows > 0 )
		 { $sno=1;
			foreach($result as $cnpformData):
	
				$id               = $cnpformData->cnpform_id;
			    $cnpfrmid         = $cnpformData->cnpform_cnpform_ID;
				$cname            = $cnpformData->cnpform_CampaignName;
			 	$fname            = $cnpformData->cnpform_FormName;
				$guid             = $cnpformData->cnpform_GUID;
				$stdate           = $cnpformData->cnpform_FormStartDate;
			 	$eddate           = $cnpformData->cnpform_FormEndDate;
		        $seldate           = $cnpformData->cnpform_DateCreated;
		   $frmstdate = new DateTime($stdate);
		   $frmeddate = new DateTime($eddate);
			 	 if($eddate == "0000-00-00 00:00:00") {$eddate ="";}
		   		if($eddate!=""){
				 $eddate = new DateTime($eddate);
				 $nwenddt = $eddate->format(CFCNP_PLUGIN_CURRENTDATETIMEFORMATPHP);}
				$cnpresltdsply .= '<tr><td>'.$sno.'</td><td >'.$cname.'</td><td >'.$fname.'</td><td  >'.$guid.'</td>	<td  >'.$frmstdate->format(CFCNP_PLUGIN_CURRENTDATETIMEFORMATPHP).'</td>
				<td  >'.$nwenddt.'</td><td nowrap><u>';							 
				if(count($result)!= 1){
				$cnpresltdsply .= '<a href="admin.php?page=cnp_formdetails&cnpviewid='.$cnpfrmid.'&cnpid='.$rcnpid.'&info=del&did='.$id.'" ><span class="dashicons dashicons-trash"></span></a></u>';
					}else{$cnpresltdsply .= '&nbsp;';}
		  $cnpresltdsply .= '</td></tr>';
		  $sno++;
			endforeach; 
	     } 
		 else {  $cnpresltdsply .= '<tr><td>No Record Found!</td><tr>';  }
		
		 $cnpresltdsply .= '</tbody></table></div><div class="dataTables_paginate" ><a href="admin.php?page=cnp_formsdetails"><strong>Go back to Form Groups</strong></a></div>';
		 echo $cnpresltdsply ;
}
?>