<?php
	define( 'CFCNP_PLUGIN_UID', "14059359-D8E8-41C3-B628-E7E030537905");
	define( 'CFCNP_PLUGIN_SKY', "5DC1B75A-7EFA-4C01-BDCD-E02C536313A3");
$connect  = array('soap_version' => SOAP_1_1, 'trace' => 1, 'exceptions' => 0);
$client   = new SoapClient('https://resources.connect.clickandpledge.com/wordpress/Auth2.wsdl', $connect);

if( !isset($_REQUEST['CampaignId']) && isset($_REQUEST['AccountId_val']) && 
           $_REQUEST['AccountId_val']!="" && 
     isset($_REQUEST['AccountGUId_val']) &&  $_REQUEST['AccountGUId_val']!=""
  )
{
	$accountid     = $_REQUEST['AccountId_val'];
	$accountguid   = $_REQUEST['AccountGUId_val'];
$xmlr  = new SimpleXMLElement("<GetActiveCampaignList2></GetActiveCampaignList2>");
$xmlr->addChild('accountId', $accountid);
$xmlr->addChild('AccountGUID', $accountguid);
$xmlr->addChild('username', CFCNP_PLUGIN_UID);
$xmlr->addChild('password', CFCNP_PLUGIN_SKY);
$response = $client->GetActiveCampaignList2($xmlr); 

 $responsearr =  $response->GetActiveCampaignList2Result->connectCampaign;
 $cnporderRes = [];
    if( !is_array($responsearr)){

      $cnporderRes[$responsearr->alias] = $responsearr->name;
    }
    else {
      foreach ($responsearr as $obj) {
        $cnporderRes[$obj->alias] = $obj->name;
      }
    }
    natcasesort($cnporderRes);$displymsg ="";
 $camrtrnval = "<option value=''>Select Campaign Name</option>";
	
 
		foreach ($cnporderRes as $cnpkey => $cnpvalue) {
        if($_REQUEST['slcamp'] == $cnpkey){$displymsg ="selected"; }else{$displymsg ="";}
        $camrtrnval .= "<option value='" . $cnpkey . "'  $displymsg>" . $cnpvalue . " (" . $cnpkey . ")</option>";
      }
	
 
echo $camrtrnval;
	
}
if( isset($_REQUEST['AccountId_val']) && $_REQUEST['AccountId_val']!="" && 
    isset($_REQUEST['AccountGUId_val']) &&  $_REQUEST['AccountGUId_val']!="" && 
    isset($_REQUEST['CampaignId']) &&  $_REQUEST['CampaignId']!="" )
{

	$cnpaccountID      = $_REQUEST['AccountId_val'];
	$cnpaccountguidID  = $_REQUEST['AccountGUId_val'];
	$cnpcampaignId     = $_REQUEST['CampaignId'];
	$xmlr  = new SimpleXMLElement("<GetActiveFormList2></GetActiveFormList2>");
	$xmlr->addChild('accountId', $cnpaccountID);
	$xmlr->addChild('AccountGUID', $cnpaccountguidID);
	$xmlr->addChild('username', CFCNP_PLUGIN_UID);
	$xmlr->addChild('password', CFCNP_PLUGIN_SKY);
	$xmlr->addChild('campaignAlias', $cnpcampaignId);
	$displymsg ="";
	$frmresponse    =  $client->GetActiveFormList2($xmlr); 	
	$frmresponsearr =  $frmresponse->GetActiveFormList2Result->form;	
	 $cnpforderRes = [];
 if( !is_array($frmresponsearr)){
      $cnpforderRes[$frmresponsearr->formGUID] = $frmresponsearr->formName;
    }
    else {
      foreach ($frmresponsearr as $obj) {
        $cnpforderRes[$obj->formGUID] = $obj->formName;
      }
    }
    natcasesort($cnpforderRes);
	 $rtrnval = "<option value=''>Select Form Name</option>";
foreach ($cnpforderRes as $cnpkey => $cnpvalue) {
 if($_REQUEST['sform'] == $cnpkey){$displymsg ="selected"; }else{$displymsg ="";}
        $rtrnval .= "<option value='" . $cnpkey . "'$displymsg>" . $cnpvalue ."</option>";
      }

	
	echo $rtrnval;
}
?>