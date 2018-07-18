<?php
if (!defined('ABSPATH'))
{
	exit;
}

$enableBPMOPROForApprove = get_option("enableBPMOPROAddonapproveuser");

if ('YES' == $enableBPMOPROForApprove)
{
	if (file_exists(BPMOPRO_ADDONS_PATH.'bpmopro_approve.php'))
	{
		require_once BPMOPRO_ADDONS_PATH.'bpmopro_approve.php';
	}	
}
