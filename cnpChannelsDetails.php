<?php
function cnp_pledgetvchannelsdetails() {

	global $wpdb;    global $cnp_settingtable_name;global $cnp_table_name;
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
	if($info=="sts")
	{
		echo "<div class='updated' id='message'><p><strong>Status updated</strong>.</p></div>";
	}
	if($info=="del")
	{
		$delid=$_GET["did"];
		$wpdb->query("delete from ".$cnp_table_name." where cnpform_ID =".$delid);
		echo "<div class='updated' id='message'><p><strong>Record Deleted.</strong>.</p></div>";
	}
	if(isset($_GET['cnpsts']) && $_GET['cnpsts']  !="")
	{	
		$cnpstsrtnval = CNPCF_updateCnPstatus($cnp_table_name,'cnpform_status','cnpform_ID',$_GET['cnpviewid'],$_GET['cnpsts']);
		if($cnpstsrtnval == true){$cnpredirectval = "sts";}else{$cnpredirectval = "stsfail";}
		wp_redirect("admin.php?page=cnp_formsdetails&info=".$cnpredirectval);
		exit;
	}

?>
<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
	
	cnpchannelslist();
	jQuery('#cnpaccntid').change(function() {
	 
		var oTable = jQuery('#cnpformslist').dataTable(); 	
		oTable.fnClearTable();
		oTable.fnDraw();
		oTable.fnDestroy();
		cnpchannelslist(); 
		
	});	
	
	});
	
	function cnpchannelslist()
	{ 
		
		var  cnpconnectaccountid= jQuery('#cnpaccntid').val().trim();
	
			 jQuery.ajax({
				  type: "POST", 
				  url: ajaxurl ,
			      serverSide: true, 
				  data: {
						'action':'getCnPUserChannelList',
					  	'cnpacid':cnpconnectaccountid,
						},
				  cache: false,
				  beforeSend: function() {
				  jQuery("#dvldimg").show();
				  jQuery('#cnpaccntid').attr("disabled", true); 
				  

					},
					complete: function() {
					
					},	
				  success: function(htmlText) {	
					 jQuery('#cnpaccntid').attr("disabled", false); 
					 jQuery("#dvldimg").hide();  
				
					
					  var body = htmlText;	  
					 jQuery("#cnpformslist tbody").html("");     
							if(htmlText != "")
							{
						
							  jQuery( "#cnpformslist tbody" ).append(body);
						    }else{
	
}
						 jQuery( "#cnpformslist" ).DataTable();
						 jQuery("#cnpformslist tr:even").css("background-color", "#f1f1f1");								   
						  },
				  error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				  }
				});
		 
	}
	/* ]]> */

</script>
<style >
table#cnpformslist tr.even {
  background-color: #f1f1f1;
}
</style>
<?php
		$cnpresltdsply = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><div class="wrap">
			              <h2>Channels &nbsp;&nbsp;&nbsp;</h2>';
	     $cnpresltdsply  .= '<p><select name="cnpaccntid" id="cnpaccntid">';
	 	 $sql          = "select cnpstngs_AccountNumber,cnpstngs_frndlyname,cnpstngs_ID,cnpstngs_guid from ".$cnp_settingtable_name." where cnpstngs_status =1 order by cnpstngs_AccountNumber ASC";
		 $result       = $wpdb->get_results($sql);
		 if($wpdb->num_rows > 0 )
		 {
			foreach($result as $cnpformData):
			 $cnpdlctid=$cnpformData->cnpstngs_AccountNumber."~".$cnpformData->cnpstngs_guid;
				$cnpresltdsply .= '<option value="'.$cnpdlctid.'" >'.$cnpformData->cnpstngs_frndlyname.' ( '.$cnpformData->cnpstngs_AccountNumber.')</option>';		  
						
			endforeach; 
		 } $cnpimgurl = plugins_url(CFCNP_PLUGIN_NAME."/images/ajax-loader_trans.gif");
		  $cnpresltdsply .= ' </select><img id="dvldimg" src="'.$cnpimgurl.'" alt="Loading" class="cnp_loadertv" /></p><table class="wp-list-table widefat  " id="cnpformslist" ><thead><tr><th><u>Channel</u></th><th><u>Channel Name</u></th><th><u>Created Date</u></th><th><u>Short Code&nbsp;<a class="tooltip" ><i class="fa fa-question-circle"></i><span class="tooltiptext">Please copy this code and place it in your required content pages, posts or any custom content types.</span></a></u></th></tr></thead><tbody>';
	     
		
		//$cnpresltdsply .= '<tr><td colspan=10>No Record Found!</td><tr>';
		$cnpresltdsply .= '</tbody></table></div>';
		echo $cnpresltdsply;
}
?>