<?php
function Install_CNP_DB() {
	/* Add in the required globals to be able to create the tables */
  	global $wpdb;
   	global $CNP_db_version;
	global $cnp_table_name;
	global $cnp_formtable_name;
    global $cnp_settingtable_name;
	global $cnp_channelgrptable_name;
    global $cnp_channeltable_name;
   	 $sql = "CREATE TABLE $cnp_formtable_name (
			  cnpform_id int(15) NOT NULL AUTO_INCREMENT,
			  cnpform_cnpform_ID int(15) NOT NULL,
			  cnpform_CampaignName varchar(250) NOT NULL,
			  cnpform_FormName varchar(250) NOT NULL,
			  cnpform_GUID varchar(250) NOT NULL,
			  cnpform_FormStartDate datetime NOT NULL,
			  cnpform_FormEndDate datetime NOT NULL,
			  cnpform_FormStatus char(1) NOT NULL DEFAULT 'a',
			  cnpform_DateCreated datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  cnpform_DateModified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY  (cnpform_id),KEY cnpfrm_id (cnpform_id)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
	 	$sql = "CREATE TABLE $cnp_table_name (
					  cnpform_ID int(9) NOT NULL AUTO_INCREMENT,
					  cnpform_groupname varchar(250) NOT NULL,
					  cnpform_cnpstngs_ID int(15) NOT NULL,
					  cnpform_AccountNumber varchar(250) NOT NULL,
					  cnpform_guid text NOT NULL,
					  cnpform_type text NOT NULL,
					  cnpform_ptype text NOT NULL,
					  cnpform_text varchar(250) NOT NULL,
					  cnpform_img blob NOT NULL,
					  cnpform_shortcode text,
					  cnpform_custommsg varchar(250) NOT NULL,
					  cnpform_Form_StartDate datetime NOT NULL,
					  cnpform_Form_EndDate datetime NOT NULL,
					  cnpform_status char(1) DEFAULT 'a',
					  cnpform_Date_Created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  cnpform_Date_Modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY  (cnpform_ID),
					  KEY cnpfrm_id (cnpform_ID)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
	
	$sql = "CREATE TABLE $cnp_channelgrptable_name (
					  cnpchannelgrp_ID int(9) NOT NULL AUTO_INCREMENT,
					  cnpchannelgrp_groupname varchar(250) NOT NULL,
					  cnpchannelgrp_cnpstngs_ID int(15) NOT NULL,
					  cnpchannelgrp_shortcode text,
					  cnpchannelgrp_custommsg varchar(250) NOT NULL,
					  cnpchannelgrp_channel_StartDate datetime NOT NULL,
					  cnpchannelgrp_channel_EndDate datetime NOT NULL,
					  cnpchannelgrp_status char(1) DEFAULT 'a',
					  cnpchannelgrp_Date_Created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  cnpchannelgrp_Date_Modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY  (cnpchannelgrp_ID),
					  KEY cnpfrm_id (cnpchannelgrp_ID)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
	
	$sql = "CREATE TABLE $cnp_channeltable_name (
			  cnpchannel_id int(15) NOT NULL AUTO_INCREMENT,
			  cnpchannel_cnpchannelgrp_ID int(15) NOT NULL,
			  cnpchannel_channelName varchar(250) NOT NULL,
			  cnpchannel_channelStartDate datetime NOT NULL,
			  cnpchannel_channelEndDate datetime NOT NULL,
			  cnpchannel_channelStatus char(1) NOT NULL DEFAULT 'a',
			  cnpchannel_DateCreated datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  cnpchannel_DateModified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
			  PRIMARY KEY  (cnpchannel_id),KEY cnpfrm_id (cnpchannel_id)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
	
	$sql = "CREATE TABLE $cnp_settingtable_name (
					  cnpstngs_ID int(9) NOT NULL AUTO_INCREMENT,
					  cnpstngs_frndlyname varchar(250) NOT NULL,
					  cnpstngs_AccountNumber varchar(250) NOT NULL,
					  cnpstngs_guid text NOT NULL,
					  cnpstngs_status char(1) DEFAULT 'a',
					  cnpstngs_Date_Created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  cnpstngs_Date_Modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY  (cnpstngs_ID),
					  KEY cnpstngs_id (cnpstngs_ID)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	
   	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   	dbDelta($sql);
	
}
?>