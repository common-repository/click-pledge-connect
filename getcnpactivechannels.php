<?php
	define( 'CFCNP_PLUGIN_UID', "14059359-D8E8-41C3-B628-E7E030537905");
	define( 'CFCNP_PLUGIN_SKY', "5DC1B75A-7EFA-4C01-BDCD-E02C536313A3");
	$connect  = array('soap_version' => SOAP_1_1, 'trace' => 1, 'exceptions' => 0);

   $client   = new SoapClient('Auth2.wsdl', $connect);

	if( !isset($_REQUEST['CampaignId']) && isset($_REQUEST['AccountId_val']) && $_REQUEST['AccountId_val']!=""     && isset($_REQUEST['AccountGUId_val']) &&  $_REQUEST['AccountGUId_val']!="")
	{ 
		
		  $accountid            = $_REQUEST['AccountId_val'];
		 $accountguid          = $_REQUEST['AccountGUId_val'];
	$xmlr  = new SimpleXMLElement("<GetPledgeTVChannelList></GetPledgeTVChannelList>");
	$xmlr->addChild('accountId', $accountid);
	$xmlr->addChild('AccountGUID', $accountguid);
	$xmlr->addChild('username', CFCNP_PLUGIN_UID);
	$xmlr->addChild('password', CFCNP_PLUGIN_SKY);
$response = $client->GetPledgeTVChannelList($xmlr);
			$displymsg ="";
			$responsearr =  $response->GetPledgeTVChannelListResult->PledgeTVChannel;
    
    $orderRes = [];
    if (!is_array($responsearr)) {
      $orderRes[$responsearr->ChannelURLID] = $responsearr->ChannelName;
    }
    else {
      foreach ($responsearr as $obj) {
        $orderRes[$obj->ChannelURLID] = $obj->ChannelName;
      }
    }
    natcasesort($orderRes);
    
	 $camrtrnval = "<option value=''>Select channel</option>";
    if (count($orderRes) > 0) {
     foreach ($orderRes as $key => $value) {
     if($key !=""){
     if($_REQUEST['slcamp'] == $key){$displymsg ="selected"; }else{$displymsg ="";}
        $camrtrnval .= "<option value='" . $key . "' $displymsg>" . $value . " (" .$key . ")</option>";
     }
      }
    }
	/* if(!is_array($responsearr))
		{ if($_REQUEST['slcamp'] == $responsearr->ChannelURLID){$displymsg ="selected"; }else{$displymsg ="";}
		if($responsearr->ChannelURLID !=""){
		 $camrtrnval.= "<option value='".$responsearr->ChannelURLID."' $displymsg>".$responsearr->ChannelName." (".$responsearr->ChannelURLID.")</option>";
		}}else{
		for($inc = 0 ; $inc < count($responsearr);$inc++)
		{
			if($_REQUEST['slcamp'] == $responsearr[$inc]->ChannelURLID){$displymsg = "selected"; }else{$displymsg ="";}
		 $camrtrnval .= "<option value='".$responsearr[$inc]->ChannelURLID."' $displymsg >".$responsearr[$inc]->ChannelName." (".$responsearr[$inc]->ChannelURLID.")</option>";
		}

	 }*/
    echo $camrtrnval;
	

	}
	
?>