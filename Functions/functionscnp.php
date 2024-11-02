<?php

function CNPCF_getImageTextButton($guid,$cnptyp,$cnptxt)
{
	global $wpdb; 	
	global $cnp_table_name;
	global $cnp_formtable_name;
	global $cnprtrnstr;
    $cnpGetImagesql     = "SELECT * FROM " .$cnp_table_name. " WHERE cnpform_groupname='" .$guid. "' and 
																	 cnpform_ptype ='".$cnptxt."'";
	$cnpimgresult       =  $wpdb->get_results($cnpGetImagesql);
		
		   if($wpdb->num_rows > 0 )
		   {
			   foreach ($cnpimgresult as $cnpimgresultsarr)
			   { 
			         if($cnptxt == "text"){$cnprtrnstr= $cnpimgresultsarr->cnpform_text ;}
				else if($cnptxt == "button"){$cnprtrnstr= $cnpimgresultsarr->cnpform_text ;}
				else if($cnptxt == "image"){$cnprtrnstr= $cnpimgresultsarr->cnpform_img;}
			   }
		   }
return $cnprtrnstr;
}
function CNPCF_isExistShortcode($cnpshortcode)
{
	global $wpdb; 	
	global $cnp_table_name;
	global $cnprtrnstr;
	$currentdate = CFCNP_PLUGIN_CURRENTTIME;
     $cnpGetImagesql     = "SELECT * FROM " .$cnp_table_name. " WHERE (cnpform_shortcode ='[CnPConnect " .$cnpshortcode. "]' OR cnpform_shortcode ='[CnP.Form " .$cnpshortcode. "]') AND cnpform_status =1 AND IF (cnpform_Form_EndDate !='0000-00-00 00:00:00', '".$currentdate."' between cnpform_Form_StartDate and cnpform_Form_EndDate, cnpform_Form_StartDate <= '".$currentdate."') order by cnpform_Date_Modified ASC Limit 1";
	$cnpimgresult       =  $wpdb->get_results($cnpGetImagesql);
	if($wpdb->num_rows > 0 )return true; else return false;

}
function CNPCF_isExistchannelShortcode($cnpshortcode)
{
	global $wpdb; 	
	global $cnp_channelgrptable_name;
	global $cnprtrnstr;
	$currentdate = CFCNP_PLUGIN_CURRENTTIME;
     $cnpGetImagesql     = "SELECT * FROM " .$cnp_channelgrptable_name. " WHERE (cnpchannelgrp_shortcode ='[CnP.pledgeTV " .$cnpshortcode. "]') AND cnpchannelgrp_status =1 AND IF (cnpchannelgrp_channel_EndDate !='0000-00-00 00:00:00', '".$currentdate."' between cnpchannelgrp_channel_StartDate and cnpchannelgrp_channel_EndDate, cnpchannelgrp_channel_StartDate <= '".$currentdate."') order by cnpchannelgrp_Date_Modified ASC Limit 1";
	$cnpimgresult       =  $wpdb->get_results($cnpGetImagesql);
	if($wpdb->num_rows > 0 )return true; else return false;

}
function CNPCF_getGroupCustomerrmsg($cnpshortcode)
{
	global $wpdb; 	
	global $cnp_table_name;
	global $cnprtrnstr; //AND cnpform_status =1 AND IF (cnpform_Form_EndDate !='0000-00-00', CURDATE() between cnpform_Form_StartDate and cnpform_Form_EndDate, cnpform_Form_StartDate <= CURDATE()) order by cnpform_Date_Modified ASC Limit 1 
     $cnpGetImagesql     = "SELECT cnpform_custommsg FROM " .$cnp_table_name. " WHERE cnpform_shortcode ='[CnPConnect " .$cnpshortcode. "]' or cnpform_shortcode ='[CnP.Form " .$cnpshortcode. "]'  ";
	$cnperrresult       =  $wpdb->get_results($cnpGetImagesql);
 if($wpdb->num_rows > 0 )
		   {
			   foreach ($cnperrresult as $cnperrresultsarr)
			   { 
			         $cnprtrnstr= $cnperrresultsarr->cnpform_custommsg;
				
			   }
		   }
return $cnprtrnstr;
}
function CNPCF_getGroupchnlCustomerrmsg($cnpshortcode)
{
	global $wpdb; 	
	global $cnp_channelgrptable_name;
	global $cnprtrnstr; //AND cnpform_status =1 AND IF (cnpform_Form_EndDate !='0000-00-00', CURDATE() between cnpform_Form_StartDate and cnpform_Form_EndDate, cnpform_Form_StartDate <= CURDATE()) order by cnpform_Date_Modified ASC Limit 1 
  $cnpGetImagesql     = "SELECT cnpchannelgrp_custommsg FROM " .$cnp_channelgrptable_name. " WHERE cnpchannelgrp_shortcode ='[CnP.pledgeTV " .$cnpshortcode. "]'";
	$cnperrresult       =  $wpdb->get_results($cnpGetImagesql);
 if($wpdb->num_rows > 0 )
		   {
			   foreach ($cnperrresult as $cnperrresultsarr)
			   { 
			         $cnprtrnstr= $cnperrresultsarr->cnpchannelgrp_custommsg;
				
			   }
		   }
return $cnprtrnstr;
}
function CNPCF_getcnpGuid($cnpshortcode)
{
	global $wpdb; 	
	global $cnp_table_name;
	global $cnprtrnstr;
    $cnpGetguidsql     = "SELECT cnpform_guid FROM " .$cnp_table_name. " WHERE cnpform_shortcode ='[CnP " .$cnpshortcode. "]' or cnpform_shortcode ='[CnP.Form " .$cnpshortcode. "]' ";
	$cnpfrmcntresult       =  $wpdb->get_results($cnpGetguidsql);
	foreach ($cnpfrmcntresult as $cnpresultsarr) {
	         $cnpform_accountId= $cnpresultsarr->cnpform_guid;
			 return $cnpform_accountId;
			}

}
function CNPCF_getFormType($groupname)
{
	global $wpdb; 	
	global $cnp_table_name;
	global $cnprtrnstr;
	$currentdate = CFCNP_PLUGIN_CURRENTTIME;
    $cnpGetguidsql     = "SELECT cnpform_type,cnpform_ptype,cnpform_text,cnpform_img FROM " .$cnp_table_name. " WHERE cnpform_groupname ='".$groupname."' AND cnpform_status =1 AND IF (cnpform_Form_EndDate !='0000-00-00 00:00:00', '".$currentdate."' between cnpform_Form_StartDate and cnpform_Form_EndDate, cnpform_Form_StartDate <= '".$currentdate."') order by cnpform_Date_Modified DESC Limit 1";
	$cnpfrmcntresult       =  $wpdb->get_results($cnpGetguidsql);
	foreach ($cnpfrmcntresult as $cnpresultsarr) {
	         $cnpform_accountId= $cnpresultsarr->cnpform_type;
			 return $cnpform_accountId."--".$cnpresultsarr->cnpform_ptype."--".$cnpresultsarr->cnpform_text."--".$cnpresultsarr->cnpform_img;
			}

}
function CNPCF_getCountForms($frmid)
{
	global $wpdb; 	
	global $cnp_formtable_name;
	global $cnprtrnstr;
	$currentdate = CFCNP_PLUGIN_CURRENTTIME;
    $cnpGetFrmCntsql     = "SELECT * FROM " .$cnp_formtable_name. " WHERE  IF (cnpform_FormEndDate !='0000-00-00',  cnpform_FormEndDate >= '".$currentdate."' , cnpform_FormStartDate != '') and cnpform_cnpform_ID  =".$frmid ;
	$cnpfrmcntresult       =  $wpdb->get_results($cnpGetFrmCntsql);
	return $wpdb->num_rows;

}
function CNPCF_getCountChannels($chnlid)
{
	global $wpdb; 	
	global $cnp_channeltable_name;
	global $cnp_channelgrptable_name;
	global $cnp_settingtable_name;
	global $cnprtrnstr;
	$currentdate = CFCNP_PLUGIN_CURRENTTIME;
	/* $cnpGetFrmCntsql          = "select * from ".$cnp_channeltable_name." join ".$cnp_channelgrptable_name." on  cnpchannelgrp_ID = cnpchannel_cnpchannelgrp_ID join ".$cnp_settingtable_name ." on cnpstngs_ID = cnpchannelgrp_cnpstngs_ID WHERE  IF (cnpchannel_channelEndDate !='0000-00-00',  cnpchannel_channelEndDate >= '".$currentdate."' , cnpchannel_channelStartDate != '') and cnpchannel_cnpchannelgrp_ID ='".$chnlid."'";*/
    $cnpGetFrmCntsql     = "SELECT * FROM " .$cnp_channeltable_name. " WHERE  IF (cnpchannel_channelEndDate !='0000-00-00',  cnpchannel_channelEndDate >= '".$currentdate."' , cnpchannel_channelStartDate != '') and cnpchannel_cnpchannelgrp_ID  =".$chnlid ;

	$result       = $wpdb->get_results($cnpGetFrmCntsql);
	$totnoofchannels = $wpdb->num_rows;
		 if($wpdb->num_rows > 0 )
		 { $sno=0;
			/*foreach($result as $cnpchannelData):
		  $isexistpledgetvchannel = isexistpledgetvchannel($cnpchannelData->cnpstngs_AccountNumber,$cnpchannelData->cnpstngs_guid,$cnpchannelData->cnpchannel_channelName);
		  if($isexistpledgetvchannel != "no"){ $sno = $sno+1;}
		  endforeach; */
		 }
	//	if($sno == $wpdb->num_rows){return $wpdb->num_rows;}else{return $sno." of ".$wpdb->num_rows;}
	
return $wpdb->num_rows;
}
function CNPCF_getAccountId($frmid)
{
						
	global $wpdb; 	
	global $cnp_formtable_name;
	global $cnprtrnstr;
    $cnpGetFrmCntsql     = "SELECT cnpform_accountId FROM " .$cnp_formtable_name. " WHERE  cnpform_id  =".$frmid;
	$cnpfrmcntresult       =  $wpdb->get_results($cnpGetFrmCntsql);
	foreach ($cnpfrmcntresult as $cnpresultsarr) {
	         $cnpform_accountId= $cnpresultsarr->cnpform_accountId;
			 return $cnpform_accountId;
			}
				
	

}
function CNPCF_getFormId($frmid)
{
	global $wpdb; 	
	global $cnp_formtable_name;
	global $cnprtrnstr;
    $cnpGetFrmsql     = "SELECT cnpform_formId FROM " .$cnp_formtable_name. " WHERE  cnpform_id  =".$frmid;
	$cnpfrmresult       =  $wpdb->get_results($cnpGetFrmsql);
	foreach ($cnpfrmresult as $cnpresultsarr) {
	         $cnpform_formId= $cnpresultsarr->cnpform_formId;
			 return $cnpform_formId;
			}
}
function CNPCF_getFormDates($frmid)
{
						
	global $wpdb; 	
	global $cnp_formtable_name;
	global $cnprtrnstr;
    $cnpGetFrmDtsql     = "SELECT * FROM " .$cnp_formtable_name. " WHERE  cnpform_id  =".$frmid;
	$cnpfrmdtresult       =  $wpdb->get_results($cnpGetFrmDtsql);
	foreach ($cnpfrmdtresult as $cnpresultsarr) {
	         $cnpform_frmdates= $cnpresultsarr->cnpform_FormStartDate ."||" . $cnpresultsarr->cnpform_FormEndDate;
			 return $cnpform_frmdates;
			}
				
}
/*************************************************/
function CNPCF_addNewChannel($tblname,$forminfo)
		{ 
			global $wpdb;	global $cnp_channelgrptable_name; global $cnp_channeltable_name;
			$count = sizeof($forminfo);
			
			if($count  > 0)
			{
						
				if( $forminfo['lstchnlaccntfrndlynam'] !="")
				{
							 
				 $chnlcode= CNPCF_getChannelShortCode(sanitize_text_field(trim($forminfo['txtcnpchnlgrp'])));
				 $current_time = CFCNP_PLUGIN_CURRENTTIME;
							
      						 
							 
			//$active = 1;
			$active = $forminfo['lstchnlsts'];
			$cnpsettingid   = explode("||",$forminfo['lstchnlaccntfrndlynam']);
			$frmgrpstartdt  = $forminfo['txtcnpchnlstrtdt'];
			$frmgrpenddt    = $forminfo['txtcnpchnlenddt'];
			$frmgrpenddt1   = "";
			
			if(get_option('date_format') != "d/m/Y"){
	          $frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($frmgrpstartdt));
	
            }
			elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
			{
				$dateval = CNPCF_getDateFormat($frmgrpstartdt);
				$frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($dateval));
			}
			
			if($frmgrpenddt !=""){
			if(get_option('date_format') != "d/m/Y"){	
			$frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($frmgrpenddt));
			}
			elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
			{
			    $dateval = CNPCF_getDateFormat($frmgrpenddt);
			    $frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($dateval));
			}
			}	
							$cnpchnlgrp = sanitize_text_field(trim($forminfo['txtcnpchnlgrp']));
							
			$sSQL = "INSERT INTO ".$cnp_channelgrptable_name."(cnpchannelgrp_groupname,cnpchannelgrp_cnpstngs_ID,			 cnpchannelgrp_shortcode,cnpchannelgrp_channel_StartDate,cnpchannelgrp_channel_EndDate,						 cnpchannelgrp_status,cnpchannelgrp_custommsg,cnpchannelgrp_Date_Created,cnpchannelgrp_Date_Modified)values('$cnpchnlgrp','$cnpsettingid[2]',												 '$chnlcode',
			'$frmgrpstartdt1','$frmgrpenddt1',$active,'$forminfo[txtchnlerrortxt]',
			'$current_time','$current_time')"; 
							$wpdb->query($sSQL);
							   $lastid = $wpdb->insert_id;
							   $noofforms = $forminfo['hidnoofforms'];
							if($noofforms == ""){$noofforms = 1;}
						
							for($inc=0;$inc< $noofforms;$inc++)
							{
								$lstcnpactivechannel  = "lstcnpactivechannel".$forminfo['hdncnpchnlcnt'][$inc];
							 	$txtcnpchnlstrtdt  = "txtcnpchnlstrtdt".$forminfo['hdncnpchnlcnt'][$inc];
								$txtcnpchnlenddt   = "txtcnpchnlenddt".$forminfo['hdncnpchnlcnt'][$inc];
							
								$txtcnpformenddt1="";
								
								
							if(get_option('date_format') != "d/m/Y"){
							  $txtcnpformstrtdt1 = date("Y-m-d H:i:s",strtotime($forminfo[$txtcnpchnlstrtdt]));
							}
							elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
							{
								$dateval = CNPCF_getDateFormat($forminfo[$txtcnpchnlstrtdt]);
								$txtcnpformstrtdt1 = date("Y-m-d H:i:s",strtotime($dateval));
							}

							if($forminfo[$txtcnpchnlenddt]!=""){
							if(get_option('date_format') != "d/m/Y"){	
							$txtcnpformenddt1 = date("Y-m-d H:i:s",strtotime($forminfo[$txtcnpchnlenddt]));
							}
							elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
							{
								$dateval = CNPCF_getDateFormat($forminfo[$txtcnpchnlenddt]);
								$txtcnpformenddt1 = date("Y-m-d H:i:s",strtotime($dateval));
							}
							}		

								
								
					
			 $sSQL = "INSERT INTO ".$cnp_channeltable_name."(cnpchannel_cnpchannelgrp_ID,cnpchannel_channelName,			 cnpchannel_channelStartDate,cnpchannel_channelEndDate,cnpchannel_channelStatus,cnpchannel_DateCreated)values('$lastid','$forminfo[$lstcnpactivechannel]', '$txtcnpformstrtdt1','$txtcnpformenddt1',$active,'$current_time')"; 
							$wpdb->query($sSQL);
				}		
			return true;}else{return false;}}else{ return false;}
		}
/*************************************************/
 function CNPCF_addNewForms($tblname,$forminfo)
		{ 
			global $wpdb;	global $cnp_table_name; global $cnp_formtable_name;
			$count = sizeof($forminfo);
			
			if($count  > 0)
			{
						
						if( $forminfo['lstaccntfrndlynam'] !="")
						{
							 
							 $frmcode= CNPCF_getFormShortCode($forminfo['txtcnpfrmgrp']);
							 $current_time = CFCNP_PLUGIN_CURRENTTIME;
							 $maxsize = 10000000; //set to approx 10 MB 
      						 
							 if(is_uploaded_file($_FILES['txtpopupimg']['tmp_name'])) {     
								//checks size of uploaded image on server side
							 if( $_FILES['txtpopupimg']['size'] < $maxsize) {    
			 
								$finfo = finfo_open(FILEINFO_MIME_TYPE);
								//checks whether uploaded file is of image type
								if(strpos(finfo_file($finfo, $_FILES['txtpopupimg']['tmp_name']),"image")===0)
								{    
								   // prepare the image for insertion
									$imgData =addslashes (file_get_contents($_FILES['txtpopupimg']['tmp_name']));
								}
								else
								{  
									$msg="<p>Uploaded file is not an image.</p>";
								}
						}
					    else {
						// if the file is not less than the maximum allowed, print an error
							$msg='<div>File exceeds the Maximum File limit</div>
							<div>Maximum File limit is '.$maxsize.' bytes</div>
							<div>File '.$_FILES['txtpopupimg']['name'].' is '.$_FILES['txtpopupimg']['size'].
							' bytes</div><hr />';
						}
        }
        else
            $msg    = "File not uploaded successfully.";
		//	$active = 1;
	
		    $active = $forminfo['lstfrmsts'];
			$cnpsettingid   = explode("||",$forminfo['lstaccntfrndlynam']);
			$frmgrpstartdt  = $forminfo['txtcnpformstrtdt'];
			$frmgrpenddt    = $forminfo['txtcnpformenddt'];
			$frmgrpenddt1   = "";
			
			if(get_option('date_format') != "d/m/Y"){
	          $frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($frmgrpstartdt));
	
            }
			elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
			{
				$dateval = CNPCF_getDateFormat($frmgrpstartdt);
				$frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($dateval));
			}
			
			if($frmgrpenddt !=""){
			if(get_option('date_format') != "d/m/Y"){	
			$frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($frmgrpenddt));
			}
			elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
			{
			    $dateval = CNPCF_getDateFormat($frmgrpenddt);
			    $frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($dateval));
			}
			}			
			$sSQL = "INSERT INTO ".$cnp_table_name."(cnpform_groupname,cnpform_cnpstngs_ID,cnpform_type, cnpform_ptype,cnpform_text,cnpform_img,cnpform_shortcode,cnpform_Form_StartDate,cnpform_Form_EndDate,						 cnpform_status,cnpform_custommsg,cnpform_Date_Created,cnpform_Date_Modified)values('$forminfo[txtcnpfrmgrp]','$cnpsettingid[2]',												 '$forminfo[lstfrmtyp]','$forminfo[lstpopuptyp]','$forminfo[txtpopuptxt]','{$imgData}','$frmcode',
			'$frmgrpstartdt1','$frmgrpenddt1',$active,'$forminfo[txterrortxt]',
			'$current_time','$current_time')"; 
			
							$wpdb->query($sSQL);
							   $lastid = $wpdb->insert_id;
							   $noofforms = $forminfo['hidnoofforms'];
							if($noofforms == ""){$noofforms = 1;}
							for($inc=0;$inc< $noofforms;$inc++)
							{
								$lstcnpactivecamp  = "lstcnpactivecamp".$forminfo['hdncnpformcnt'][$inc];
							    $lstcnpfrmtyp      = "hdncnpformname".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpguid        = "txtcnpguid".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformstrtdt  = "txtcnpformstrtdt".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformenddt   = "txtcnpformenddt".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformurlparms   = "txtbtnurlparms".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformenddt1="";
															
							if(get_option('date_format') != "d/m/Y"){
							  $txtcnpformstrtdt1 = date("Y-m-d H:i:s",strtotime($forminfo[$txtcnpformstrtdt]));
							}
							elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
							{
								$dateval = CNPCF_getDateFormat($forminfo[$txtcnpformstrtdt]);
								$txtcnpformstrtdt1 = date("Y-m-d H:i:s",strtotime($dateval));
							}

							if($forminfo[$txtcnpformenddt]!=""){
							if(get_option('date_format') != "d/m/Y"){	
							$txtcnpformenddt1 = date("Y-m-d H:i:s",strtotime($forminfo[$txtcnpformenddt]));
							}
							elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
							{
								$dateval = CNPCF_getDateFormat($forminfo[$txtcnpformenddt]);
								$txtcnpformenddt1 = date("Y-m-d H:i:s",strtotime($dateval));
							}
							}		
 $sSQL = "INSERT INTO ".$cnp_formtable_name."(cnpform_cnpform_ID,cnpform_CampaignName,cnpform_FormName,cnpform_GUID,cnpform_FormStartDate,cnpform_FormEndDate,cnpform_FormStatus,cnpform_DateCreated,cnpform_urlparameters)values('$lastid','$forminfo[$lstcnpactivecamp]','$forminfo[$lstcnpfrmtyp]','$forminfo[$txtcnpguid]','$txtcnpformstrtdt1','$txtcnpformenddt1',$active, '$current_time','$forminfo[$txtcnpformurlparms]')"; 
							$wpdb->query($sSQL);
								}		
			return true;}else{return false;}}else{ return false;}
		}
		
		function CNPCF_addSettings($tblname,$forminfo)
		{ 
			global $wpdb;	global $cnp_settingtable_name; 
			$count = sizeof($forminfo);
			
			if($count  > 0)
			{
						 $scnpSQL = "SELECT * FROM ".$cnp_settingtable_name." where cnpstngs_frndlyname ='".$forminfo['txtcnpfrmfrndlynm']."'  or cnpstngs_AccountNumber = '".$forminfo['txtcnpacntid']."'";
						$cnpresults  = $wpdb->get_results($scnpSQL);
					 	$cnpformrows = $wpdb->num_rows;
						if( $cnpformrows == 0)
						{
							

if(isset($forminfo['txtcnpacntid']) && $forminfo['txtcnpacntid']!="" && isset($forminfo['txtcnpacntguid']) && $forminfo['txtcnpacntguid']!="")
{
	
	
    $current_time = CFCNP_PLUGIN_CURRENTTIME;
	$cnpactive       =1;
	$sSQL = "INSERT INTO ".$cnp_settingtable_name."(cnpstngs_frndlyname,cnpstngs_AccountNumber,cnpstngs_guid,cnpstngs_status,cnpstngs_Date_Created,cnpstngs_Date_Modified)values('$forminfo[txtcnpfrmfrndlynm]','$forminfo[txtcnpacntid]',
													 '$forminfo[txtcnpacntguid]',$cnpactive,
													 '$current_time',
													 '$current_time')"; 
	$wpdb->query($sSQL);
							 
							
							
							
			//return $cnpcampcnt;
					return true;}else{return false;}
		}
				else{return "error";}
	}
}
function CNPCF_getActivecampaigns($cnpaccountno,$cnpaccountguid,$retrnstrng){
	$connect  = array('soap_version' => SOAP_1_1, 'trace' => 1, 'exceptions' => 0);
    $client   = new SoapClient('https://resources.connect.clickandpledge.com/wordpress/Auth2.wsdl', $connect);

	$accountid     = $cnpaccountno; 
	$accountguid   = $cnpaccountguid;
	$xmlr  = new SimpleXMLElement("<GetActiveCampaignList2></GetActiveCampaignList2>");
	$xmlr->addChild('accountId', $accountid);
	$xmlr->addChild('AccountGUID', $accountguid);
	$xmlr->addChild('username', CFCNP_PLUGIN_UID);
	$xmlr->addChild('password', CFCNP_PLUGIN_PWD);
	$response = $client->GetActiveCampaignList2($xmlr); 

    $responsearr  =  $response->GetActiveCampaignList2Result->connectCampaign;
	
	if($retrnstrng =="count"){
	$cnpcampcnt   = count($responsearr);
	return $cnpcampcnt;}
	if($retrnstrng =="lst"){
	return $responsearr;
	}
}
		function CNPCF_getfrmsts($tablenm,$filedname,$wherefldid,$fieldid)
		{
						
			global $wpdb; 	
			global $cnp_formtable_name;
			global $cnprtrnstr;
			$cnpGetFrmDtsql     = "SELECT ".$filedname." as fldsts FROM " .$tablenm. " WHERE  " .$wherefldid. "  =".$fieldid;
			$cnpfrmdtresult       =  $wpdb->get_results($cnpGetFrmDtsql);
			foreach ($cnpfrmdtresult as $cnpresultsarr) {
					 $cnpform_frmdates= $cnpresultsarr->fldsts;if($cnpform_frmdates == "1")$cnprtrnstr = "Active";else $cnprtrnstr = "Inactive";
					 return $cnprtrnstr;
					}
				
	   }

	function CNPCF_GetCnPGroupDetails($tablenm,$filedname,$wherefldid)
		{
						
			global $wpdb; 	
			global $cnp_formtable_name;
			global $cnprtrnstr;
		    $cnpGetFrmDtsql       = "SELECT * FROM " .$tablenm. " WHERE  " .$filedname. "  = ".$wherefldid;
			$cnpfrmdtresult       =  $wpdb->get_results($cnpGetFrmDtsql);
			
			 return $cnpfrmdtresult;	
	   }
		
	function CNPCF_updateCnPstatus($tablenm,$filedname,$wherefldid,$fieldid,$sts)
		{
						
			global $wpdb; 	
			global $cnp_formtable_name;
			global $cnprtrnstr;
			if($sts == "Active"){$updtsts ="0";}else{$updtsts ="1";}
			$cnpGetFrmeDtsql     = "update " .$tablenm. " SET ".$filedname." = '".$updtsts."' WHERE  " .$wherefldid. "  =".$fieldid; 
			$returnval = $wpdb->query($cnpGetFrmeDtsql);
			/*if($returnval){$cnpGetFrmeDtsql     = "update " .$tablenm. " SET ".$filedname." = '".$updtsts."' WHERE  " .$wherefldid. "  =".$fieldid; 
			$returnval = $wpdb->query($cnpGetFrmeDtsql);}*/
			return true;
	   }
		function CNPCF_updateChannels($tblname,$forminfo)
		{ 
			global $wpdb;	global $cnp_channelgrptable_name;global $cnp_channeltable_name;
			$count = sizeof($forminfo);
			if($count>0)
			{
			    $current_time = CFCNP_PLUGIN_CURRENTTIME;
				$frmgrpstartdt  = $forminfo['txtcnpchnlstrtdt'];
				$frmgrpenddt    = $forminfo['txtcnpchnlenddt'];
				$frmgrpenddt1   = "";
			
			/*//$frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($frmgrpstartdt));
			if($frmgrpenddt !=""){
			$frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($frmgrpenddt));}	
				*/
			if(get_option('date_format') != "d/m/Y")
			{
				$frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($frmgrpstartdt));
				if($frmgrpenddt !=""){
				$frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($frmgrpenddt));
				}
			}
			elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
			{
				$dateval = CNPCF_getDateFormat($frmgrpstartdt);
				$frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($dateval));
				if($frmgrpenddt !=""){
					$dateval = CNPCF_getDateFormat($frmgrpenddt);
					$frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($dateval));
				}	
				
			}	

				// cnpform_shortcode='$frmcode',
			 $active =1;//cnpform_groupname ='$forminfo[txtcnpfrmgrp]',
			 $sSQL = "UPDATE ".$cnp_channelgrptable_name." set 
													 cnpchannelgrp_channel_StartDate='$frmgrpstartdt1',
													 cnpchannelgrp_channel_EndDate='$frmgrpenddt1',
			 										 cnpchannelgrp_status='$forminfo[lstchnlsts]',
													 cnpchannelgrp_custommsg='$forminfo[txterrortxt]',
													 cnpchannelgrp_Date_Modified='$current_time'
											   where cnpchannelgrp_ID ='".$forminfo['hdnfrmid']."'"; 
			$wpdb->query($sSQL);
				 $noofforms = $forminfo['hidnoofforms'];
				$wpdb->query("delete from ".$cnp_channeltable_name." where cnpchannel_cnpchannelgrp_ID =".$forminfo['hdnfrmid']);
				
				
							for($inc=0;$inc< $noofforms;$inc++)
							{
							
								$lstcnpactivecamp = "lstcnpeditactivecamp".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformstrtdt  = "txtcnpformstrtdt".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformenddt   = "txtcnpformenddt".$forminfo['hdncnpformcnt'][$inc];
							   /* $lstcnpactivecamp  = "lstcnpeditactivecamp".$inc;
							    
								$txtcnpformstrtdt  = "txtcnpformstrtdt".$inc;
								$txtcnpformenddt   = "txtcnpformenddt".$inc;*/
								$txtcnpformenddt1  = "";
								
			if(get_option('date_format') != "d/m/Y")
			{
				$txtcnpformstrtdt1 = date("Y-m-d H:i:s",strtotime($forminfo[$txtcnpformstrtdt]));
				if($forminfo[$txtcnpformenddt] !=""){
				$txtcnpformenddt1 = date("Y-m-d H:i:s",strtotime($forminfo[$txtcnpformenddt]));
				}
			}
			elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
			{
				$dateval = CNPCF_getDateFormat($forminfo[$txtcnpformstrtdt]);
				$txtcnpformstrtdt1 = date("Y-m-d H:i:s",strtotime($dateval));
				if($forminfo[$txtcnpformenddt] !=""){
					$datevale = CNPCF_getDateFormat($forminfo[$txtcnpformenddt]);
					$txtcnpformenddt1 = date("Y-m-d H:i:s",strtotime($datevale));
				}	
				
			}	

			if($forminfo[$lstcnpactivecamp] !=""){					
			 $sSQL = "INSERT INTO ".$cnp_channeltable_name."(cnpchannel_cnpchannelgrp_ID,cnpchannel_channelName,		 cnpchannel_channelStartDate,cnpchannel_channelEndDate,cnpchannel_channelStatus,cnpchannel_DateCreated)values('".$forminfo['hdnfrmid']."','$forminfo[$lstcnpactivecamp]',
																										 '$txtcnpformstrtdt1','$txtcnpformenddt1',$active,
													 '$current_time')"; 
							$wpdb->query($sSQL);
				}				
			
				} 
			return true;/*}else{return false;	}*/}else{ return false;}
		}
		function CNPCF_updateForms($tblname,$forminfo)
		{ 
			global $wpdb;	global $cnp_table_name;global $cnp_formtable_name;
			$count = sizeof($forminfo);
			if($count>0)
			{
										 
						 $frmcode= CNPCF_getFormShortCode($forminfo['txtcnpfrmgrp']);
						 $current_time = CFCNP_PLUGIN_CURRENTTIME;
						 $maxsize = 10000000; //set to approx 10 MB 
							if(is_uploaded_file($_FILES['txtpopupimg']['tmp_name'])) {     
								//checks size of uploaded image on server side
							if( $_FILES['txtpopupimg']['size'] < $maxsize) {    
			 
							$finfo = finfo_open(FILEINFO_MIME_TYPE);
								//checks whether uploaded file is of image type
								if(strpos(finfo_file($finfo, $_FILES['txtpopupimg']['tmp_name']),"image")===0)
								{    
								   // prepare the image for insertion
									$imgData =addslashes (file_get_contents($_FILES['txtpopupimg']['tmp_name']));
									$sSQL = "UPDATE ".$cnp_table_name." set cnpform_img = '{$imgData}',
																 cnpform_Date_Modified='$current_time'
														   where cnpform_ID ='".$forminfo['hdnfrmid']."'"; 
									$wpdb->query($sSQL);
								}
								else{$msg="<p>Uploaded file is not an image.</p>";}
							}
							 else {
								// if the file is not less than the maximum allowed, print an error
								$msg='<div>File exceeds the Maximum File limit</div>
								<div>Maximum File limit is '.$maxsize.' bytes</div>
								<div>File '.$_FILES['txtpopupimg']['name'].' is '.$_FILES['txtpopupimg']['size'].
								' bytes</div><hr />';
							}	}	else $msg="File not uploaded successfully.";
 

			$frmgrpstartdt  = $forminfo['txtcnpformstrtdt'];
			$frmgrpenddt    = $forminfo['txtcnpformenddt'];
			$frmgrpenddt1   = "";
		
			if(get_option('date_format') != "d/m/Y")
			{
				$frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($frmgrpstartdt));
				if($frmgrpenddt !=""){
				$frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($frmgrpenddt));
				}
			}
			elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
			{
				$dateval = CNPCF_getDateFormat($frmgrpstartdt);
				$frmgrpstartdt1 = date("Y-m-d H:i:s",strtotime($dateval));
				if($frmgrpenddt !=""){
					$dateval = CNPCF_getDateFormat($frmgrpenddt);
					$frmgrpenddt1 = date("Y-m-d H:i:s",strtotime($dateval));
				}	
				
			}	

				// cnpform_shortcode='$frmcode',
			 $active =1;//cnpform_groupname ='$forminfo[txtcnpfrmgrp]',
			 $sSQL = "UPDATE ".$cnp_table_name." set cnpform_type='$forminfo[lstfrmtyp]',
													 cnpform_ptype='$forminfo[lstpopuptyp]',
												     cnpform_text='$forminfo[txtpopuptxt]',
													 cnpform_Form_StartDate='$frmgrpstartdt1',
													 cnpform_Form_EndDate='$frmgrpenddt1',
			 										 cnpform_status='$forminfo[lstfrmsts]',
													 cnpform_custommsg='$forminfo[txterrortxt]',
													 cnpform_Date_Modified='$current_time'
											   where cnpform_ID ='".$forminfo['hdnfrmid']."'"; 
			$wpdb->query($sSQL);
				$noofforms = $forminfo['hidnoofforms'];
				$wpdb->query("delete from ".$cnp_formtable_name." where cnpform_cnpform_ID =".$forminfo['hdnfrmid']);
							for($inc=0;$inc< $noofforms;$inc++)
							{
						
								
								$lstcnpactivecamp = "lstcnpeditactivecamp".$forminfo['hdncnpformcnt'][$inc];
							    $lstcnpfrmtyp  = "hdncnpformname".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpguid = "txtcnpguid".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformstrtdt = "txtcnpformstrtdt".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformenddt= "txtcnpformenddt".$forminfo['hdncnpformcnt'][$inc];
								$txtcnpformurlparms= "txtbtnurlparms".$forminfo['hdncnpformcnt'][$inc];
							
								$txtcnpformenddt1="";
							
			if(get_option('date_format') != "d/m/Y")
			{
				$txtcnpformstrtdt1 = date("Y-m-d H:i:s",strtotime($forminfo[$txtcnpformstrtdt]));
				if($forminfo[$txtcnpformenddt] !=""){
				$txtcnpformenddt1 = date("Y-m-d H:i:s",strtotime($forminfo[$txtcnpformenddt]));
				}
			}
			elseif(get_option('date_format') == "d/m/Y" || get_option('date_format') == "d-m-Y")
			{
				$dateval = CNPCF_getDateFormat($forminfo[$txtcnpformstrtdt]);
				$txtcnpformstrtdt1 = date("Y-m-d H:i:s",strtotime($dateval));
				if($forminfo[$txtcnpformenddt] !=""){
					$datevale = CNPCF_getDateFormat($forminfo[$txtcnpformenddt]);
					$txtcnpformenddt1 = date("Y-m-d H:i:s",strtotime($datevale));
				}	
				
			}	

								
			 $sSQL = "INSERT INTO ".$cnp_formtable_name."(cnpform_cnpform_ID,cnpform_CampaignName,cnpform_FormName,cnpform_GUID,			 cnpform_FormStartDate,cnpform_FormEndDate,cnpform_FormStatus,cnpform_DateCreated,cnpform_urlparameters)values('".$forminfo['hdnfrmid']."','$forminfo[$lstcnpactivecamp]',
													 '$forminfo[$lstcnpfrmtyp]','$forminfo[$txtcnpguid]',
													 '$txtcnpformstrtdt1','$txtcnpformenddt1',$active,
													 '$current_time','$forminfo[$txtcnpformurlparms]')"; 
							$wpdb->query($sSQL);
								
			
				}
			return true;/*}else{return false;	}*/}else{ return false;}
		}
		function CNPCF_updateSettings($tblname,$forminfo)
		{ 
			global $wpdb;	global $cnp_settingtable_name;
			$count = sizeof($forminfo);
			if($count>0)
			{
				 $cnpcampcnt = //CNPCF_getActivecampaigns($forminfo[txtcnpacntid],$forminfo[txtcnpacntguid],"count");
				 $current_time = date('Y-m-d H:i:s');
				 $active =1;
			 	 $sSQL = "UPDATE ".$cnp_settingtable_name." set 
				 									 cnpstngs_frndlyname ='$forminfo[txtcnpfrmfrndlynm]',
			 										 cnpstngs_AccountNumber='$forminfo[txtcnpacntid]',
													 cnpstngs_guid='$forminfo[txtcnpacntguid]',
													 cnpstngs_Date_Modified='$current_time'
											   where cnpstngs_ID ='".$forminfo['hdnfrmid']."'"; 
			$wpdb->query($sSQL);
				//return $cnpcampcnt;
			return true;}else{ return false;}
		}
 function CNPCF_getFormShortCode($groupnm)
 {
	     global $wpdb; 	
		 global $cnp_table_name;
		 $rtrnval="";
		 $frmcode = $groupnm;
		 $shrtcode= str_replace(' ', '-', $frmcode);
		 $shortcode = '[CnP.Form '.$shrtcode.']';
					
	return $shortcode;
 }
 function CNPCF_getChannelShortCode($groupnm)
 {
	     global $wpdb; 	
		 global $cnp_table_name;
		 $rtrnval="";
		 $chnlcode = $groupnm;
		 $shrtcode= str_replace(' ', '-', $chnlcode);
		 $shortcode = '[CnP.pledgeTV '.$shrtcode.']';
					
	return $shortcode;
 }
 function  CNPCF_getMaxFormid($tablename)
 {
 	     global $wpdb; 	
		 global $cnp_table_name;
		 $rtrnval="";
		 $scnpSQL    = "SELECT MAX(cnpform_id) as frmid FROM ".$tablename;
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
					 if( $cnpformrows != NULL){
							foreach ($cnpresults as $cnpresultsarr) {
							  $cnpfrmid= $cnpresultsarr->frmid;
							  $rtrnval = $cnpfrmid + 1;
							}
						}
						else { $rtrnval = 1;}
					if($rtrnval <=9){ $rtrnval = "00".$rtrnval;}elseif($rtrnval <=99 && $rtrnval >=9){ $rtrnval = "0".$rtrnval;}else{$rtrnval = $rtrnval;}
						
	return "CNPCF".$rtrnval;
 }
function CNPCF_getformsofGroup($groupname){
	
	 global $wpdb; 	
		 global $cnp_table_name; global $cnp_formtable_name;
		 $returnarr = array();
		 $rtrnval="";
	     $currentdate = CFCNP_PLUGIN_CURRENTTIME;
		  $scnpSQL    = "SELECT cnpform_ID as frmid FROM ".$cnp_table_name ." WHERE cnpform_groupname = '".$groupname."' AND 
	 						cnpform_status =1 AND IF (cnpform_Form_EndDate !='0000-00-00 00:00:00', '".$currentdate."' between cnpform_Form_StartDate and cnpform_Form_EndDate, cnpform_Form_StartDate <=  '".$currentdate."') order by cnpform_Date_Modified DESC Limit 1";
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
					 if( $cnpformrows != NULL){
							foreach ($cnpresults as $cnpresultsarr) {
							  $cnpfrmid= $cnpresultsarr->frmid;
							 
							}
						   $scnpFormsSQL    = "SELECT cnpform_GUID as frmguid,cnpform_urlparameters FROM ".$cnp_formtable_name ." WHERE cnpform_cnpform_ID = '".$cnpfrmid."' AND cnpform_FormStatus =1 AND   IF (cnpform_FormEndDate !='0000-00-00 00:00:00',  '".$currentdate."' between cnpform_FormStartDate and cnpform_FormEndDate, cnpform_FormStartDate <=  '".$currentdate."') order by cnpform_DateCreated DESC Limit 1";
		 $cnpformsresults = $wpdb->get_results($scnpFormsSQL);
		 $cnpformrows = $wpdb->num_rows;
						
					 if( $cnpformrows != NULL){
							foreach ($cnpformsresults as $cnpfrmresultsarr) {
								$cnpurlparam = $cnpfrmresultsarr->cnpform_urlparameters;
								//$cnpurlparamnw = str_replace(';', '&', $cnpurlparam);
								$newfrmguid = $cnpfrmresultsarr->frmguid ."?".$cnpurlparam;
								array_push($returnarr, $newfrmguid);
							
							 
							}
						}
						}
				
	return $returnarr;
}
function CNPCF_getchannelsofGroup($groupname){
	
	 global $wpdb; 	
		 global $cnp_channelgrptable_name; global $cnp_channeltable_name;
		 $returnarr = array();
		 $rtrnval="";
	     $currentdate = CFCNP_PLUGIN_CURRENTTIME;
		  $scnpSQL    = "SELECT cnpchannelgrp_ID as chnlid FROM ".$cnp_channelgrptable_name ." WHERE cnpchannelgrp_groupname = '".$groupname."' AND 
	 						cnpchannelgrp_status =1 AND IF (cnpchannelgrp_channel_EndDate !='0000-00-00 00:00:00', '".$currentdate."' between cnpchannelgrp_channel_StartDate and cnpchannelgrp_channel_EndDate, cnpchannelgrp_channel_StartDate <=  '".$currentdate."') order by cnpchannelgrp_Date_Modified DESC Limit 1";
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
					 if( $cnpformrows != NULL){
							foreach ($cnpresults as $cnpresultsarr) {
							  $cnpfrmid= $cnpresultsarr->chnlid;
							 
							}
						   $scnpFormsSQL    = "SELECT cnpchannel_channelName as chnlnm FROM ".$cnp_channeltable_name ." WHERE cnpchannel_cnpchannelgrp_ID = '".$cnpfrmid."' AND cnpchannel_channelStatus =1 AND   IF (cnpchannel_channelEndDate !='0000-00-00 00:00:00',  '".$currentdate."' between cnpchannel_channelStartDate and cnpchannel_channelEndDate, cnpchannel_channelStartDate <=  '".$currentdate."') order by cnpchannel_DateCreated DESC Limit 1";
						   $cnpformsresults = $wpdb->get_results($scnpFormsSQL);
		 				   $cnpformrows = $wpdb->num_rows;
						
					 if( $cnpformrows != NULL){
							foreach ($cnpformsresults as $cnpfrmresultsarr) {
								array_push($returnarr, $cnpfrmresultsarr->chnlnm);
							
							 
							}
						}
						}
				
	return $returnarr;
}
function CNPCF_getCNPAccountDetails($cnpfrndlynm){
	     global $wpdb; 	
		 global $cnp_settingtable_name;
		 global $cnp_table_name; global $cnp_formtable_name;
		 $acntrtrnval= "";
		 $scnpSQL    = "SELECT *  FROM ".$cnp_settingtable_name ." WHERE cnpstngs_ID ='".$cnpfrndlynm."'";
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
		 if( $cnpformrows != NULL){	
			
			 foreach ($cnpresults as $cnpresultsarr) {
				if(count($cnpresultsarr) >= 1)
				{
					 $acntrtrnval = $cnpresultsarr->cnpstngs_AccountNumber."--".$cnpresultsarr->cnpstngs_guid;
				}
			}
		 }
		
	return $acntrtrnval;
	
}
function CNPCF_getAccountNumbersCount()
{
	 	 global $wpdb; 	
		 global $cnp_settingtable_name;
		 $rtrnval="";
		 $scnpSQL    = "SELECT *  FROM ".$cnp_settingtable_name;
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
		
		
	return $cnpformrows;
	
}
function CNPCF_editgetAccountIdList($cnpeditid)
{
	 	 global $wpdb; 	
		 global $cnp_settingtable_name;
		 $rtrnval="";
		 $scnpSQL    = "SELECT *  FROM ".$cnp_settingtable_name." order by cnpstngs_AccountNumber" ;
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
		 if( $cnpformrows != NULL){	
			 $camrtrnval = "";
			 //$camrtrnval = "<option value=''>Select Friendly Name</option>";
			 foreach ($cnpresults as $cnpresultsarr) {
				if(count($cnpresults) >= 1)
				{ $cnpoptnsel = "";
					if($cnpresultsarr->cnpstngs_ID == $cnpeditid){$cnpoptnsel="selected";}
					$optnval = $cnpresultsarr->cnpstngs_AccountNumber."||".$cnpresultsarr->cnpstngs_guid."||".$cnpresultsarr->cnpstngs_ID;
					 $camrtrnval.= "<option value='".$optnval."' ".$cnpoptnsel.">".$cnpresultsarr->cnpstngs_frndlyname." ( ".$cnpresultsarr->cnpstngs_AccountNumber." )</option>";
				}
			}
		 }
		
	return $camrtrnval;
	
}
function CNPCF_getAccountIdList()
{
	 	 global $wpdb; 	
		 global $cnp_settingtable_name;
		 $rtrnval="";
		 $scnpSQL    = "SELECT *  FROM ".$cnp_settingtable_name ." order by cnpstngs_AccountNumber";
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
		 if( $cnpformrows != NULL){	
		
			 $camrtrnval ="";
			 foreach ($cnpresults as $cnpresultsarr) {
				if(count($cnpresults) >= 1)
				{
					$optnval = $cnpresultsarr->cnpstngs_AccountNumber."||".$cnpresultsarr->cnpstngs_guid."||".$cnpresultsarr->cnpstngs_ID;
					 $camrtrnval.= "<option value='".$optnval."'>".$cnpresultsarr->cnpstngs_frndlyname." ( ".$cnpresultsarr->cnpstngs_AccountNumber." )</option>";
				}
			}
		 }
		
	return $camrtrnval;
	
}
function CNPCF_getAccountNumbersInfo($cnpeditid)
{
	 	 global $wpdb; 	
		 global $cnp_table_name;
		 $rtrnval="";
		 $scnpSQL    = "SELECT *  FROM ".$cnp_table_name ." WHERE cnpform_cnpstngs_ID=".$cnpeditid;
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
		
		
	return $cnpformrows;
	
}
function CNPCF_getchnlAccountNumbersInfo($cnpeditid)
{
	 	 global $wpdb; 	
		 global $cnp_channelgrptable_name ;
		 $rtrnval="";
		 $scnpSQL    = "SELECT *  FROM ".$cnp_channelgrptable_name ." WHERE cnpchannelgrp_cnpstngs_ID=".$cnpeditid;
		 $cnpresults = $wpdb->get_results($scnpSQL);
		 $cnpformrows = $wpdb->num_rows;
		
		
	return $cnpformrows;
	
}

function CNPCF_getDateFormat($frmgrpstartdt)
{
	
	$dateval = $frmgrpstartdt;
	$bits = explode(' ',$dateval);
	$bits1 = explode('/',$bits[0]);
	$curdate = $bits1[1].'/'.$bits1[0].'/'.$bits1[2] . " ".$bits[1]. " ".$bits[2];
	return $curdate;
}
function wp_get_timezone_string() {
 
    // if site timezone string exists, return it
    if ( $timezone = get_option( 'timezone_string' ) )
        return $timezone;
 
    // get UTC offset, if it isn't set then return UTC
    if ( 0 === ( $utc_offset = get_option( 'gmt_offset', 0 ) ) )
        return 'UTC';
 
    // adjust UTC offset from hours to seconds
    $utc_offset *= 3600;
 
    // attempt to guess the timezone string from the UTC offset
    if ( $timezone = timezone_name_from_abbr( '', $utc_offset, 0 ) ) {
        return $timezone;
    }
 
    // last try, guess timezone string manually
    $is_dst = date( 'I' );
 
    foreach ( timezone_abbreviations_list() as $abbr ) {
        foreach ( $abbr as $city ) {
            if ( $city['dst'] == $is_dst && $city['offset'] == $utc_offset )
                return $city['timezone_id'];
        }
    }
     
    // fallback to UTC
    return 'UTC';
}


?>