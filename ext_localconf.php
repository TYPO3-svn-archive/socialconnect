<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TYPO3_CONF_VARS['FE']['eID_include']['socialconnect'] = 'EXT:socialconnect/library/tx_socialconnect_callback.php';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['socialconnect']['SC_enabledSocialMedia'] = array (
	'EXT:socialconnect/classes/user_connect_twitter.php:&user_connect_twitter'
	'EXT:socialconnect/classes/user_connect_facebook.php:&user_connect_facebook'
);
?>