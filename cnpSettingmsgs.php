<?php
	define( 'CFCNP_PLUGIN_UID', "14059359-D8E8-41C3-B628-E7E030537905");
	define( 'CFCNP_PLUGIN_SKY', "5DC1B75A-7EFA-4C01-BDCD-E02C536313A3");
	
if(extension_loaded('soap')) {

	$connect  = array('soap_version' => SOAP_1_1, 'trace' => 1, 'exceptions' => 0);
	$client   = new SoapClient('https://resources.connect.clickandpledge.com/wordpress/Auth2.wsdl', $connect);

	if(!isset($_REQUEST['verfication']) && isset($_REQUEST['AccountId_val']) && $_REQUEST['AccountId_val']!=""     && isset($_REQUEST['AccountGUId_val']) &&  $_REQUEST['AccountGUId_val']!="")
	{ 
		
		 $accountid            = $_REQUEST['AccountId_val'];
		 $accountguid          = $_REQUEST['AccountGUId_val'];
		 $xmlr  = new SimpleXMLElement("<GetAccountDetail></GetAccountDetail>");
		 $xmlr->addChild('accountId', $accountid);
		 $xmlr->addChild('accountGUID', $accountguid);
		 $xmlr->addChild('username', CFCNP_PLUGIN_UID);
	     $xmlr->addChild('password', CFCNP_PLUGIN_SKY);
		 $response = $client->GetAccountDetail($xmlr); 

	 $responsearr =  $response->GetAccountDetailResult->AccountNickName;
	
	 echo $responsearr;
	

	}
	else if(isset($_REQUEST['verfication']) && isset($_REQUEST['AccountId_val']) && $_REQUEST['AccountId_val']!=""     && isset($_REQUEST['AccountGUId_val']) &&  $_REQUEST['AccountGUId_val']!="")
	{ global  $wpdb;
		if (@file_exists(dirname(dirname(dirname(dirname(__FILE__))))."/wp-config.php"))
		{ define( 'BLOCK_LOAD', true );  
		  require_once(dirname(dirname(dirname(dirname(__FILE__))))."/wp-config.php");
		  require_once( dirname(dirname(dirname(dirname(__FILE__)))).'/wp-includes/wp-db.php' );
		  $wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);

		}
 		 $accountid            = $_REQUEST['AccountId_val'];
		 $accountguid          = $_REQUEST['AccountGUId_val'];
		 $xmlr  = new SimpleXMLElement("<GetAccountDetail></GetAccountDetail>");
		 $xmlr->addChild('accountId', $accountid);
		 $xmlr->addChild('accountGUID', $accountguid);
		 $xmlr->addChild('username', CFCNP_PLUGIN_UID);
	     $xmlr->addChild('password', CFCNP_PLUGIN_SKY);
		 $response = $client->GetAccountDetail($xmlr); 

	 	$responsearr =   addslashes($response->GetAccountDetailResult->AccountNickName);
		
		if($responsearr!="")
		{
			$cnp_settingtable_name =   $_REQUEST['cnptblnm'];
			$current_time = date('Y-m-d H:i:s');
			$active =1;
			
			 	$sSQL = "UPDATE ".$cnp_settingtable_name." set 
				 									 cnpstngs_frndlyname = '$responsearr',
			 										 cnpstngs_Date_Modified='$current_time'
											   where cnpstngs_ID ='".$_REQUEST['verfication']."'"; 
			$wpdb->query($sSQL);
			echo "true";;
		}
		else{echo "False";}
		
	}
	}
else{
	echo "SOAP";
}
	
?>