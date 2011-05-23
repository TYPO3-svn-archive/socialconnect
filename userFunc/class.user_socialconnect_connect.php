<?php
require_once t3lib_extMgm::extPath('socialconnect')."library/tx_socialconnect_lib.php";
//class.user_socialconnect_connect.php
class user_socialconnect_connect extends lib_socialconnect_be {
	var $prefixId      = 'user_socialconnect_connect';		// Same as class name
	var $scriptRelPath = 'userFunc/class.user_socialconnect_connect.php';	// Path to this script relative to the extension dir.
	//var $extKey        = 'socialconnect';	// The extension key.

	function user_connectToSocialMedia() {
		$content = ''; $mediaConf = array(); $enabledSocialMedia = array();
		$mediaConf = $this->getConnectedMedia();
		
		//$content .= t3lib_div::view_array($mediaConf);	
		// add hook
		$enabledSocialMedia = $this->init_enabledSocialMedia();
		
		foreach($enabledSocialMedia as $key => $conf) {
			if(!in_array($conf['value'], array_keys($mediaConf)) ) {
				$content .= '<p>No connected accounts</p><p>&nbsp;</p>';
			} else {
				$content .= '<p>Already connected to '.$conf['value'].' with account(s): ' . implode(', ', $mediaConf[$conf['value']]).'</p><p>&nbsp;</p>';
			}
			$content .= $this->connectToMedia($key, $conf);
		}
		
		if(!empty($connected)) {
			$content .= 'Connected to: '.implode(', ', $connected);
		}
		
		return $content;
	}
			
	function connectToMedia($media, $conf) {
		$content = '';
		// add to render
		$_mediaObj = t3lib_div::getUserObj($conf['userObj']);
		if( method_exists($_mediaObj, 'init') ) {
			$content = $_mediaObj->init($conf);
		}
		
		if( method_exists($_mediaObj, 'showConnect') ) {
			$content = $_mediaObj->showConnect();
		} else {
			$content = $media . ' -> showConnect function could not be initiated'; 
		}
		return '<div>'.$content.'</div>';
	}
	
	function finishConnect($media) {
		$enabledSocialMedia = $this->init_enabledSocialMedia();
		$mediaConf = $enabledSocialMedia[$media];
		if( is_array($mediaConf) ) {
			// add to render
			$_mediaObj = t3lib_div::getUserObj($mediaConf['userObj']);
			if( method_exists($_mediaObj, 'init') ) {
				$content = $_mediaObj->init($mediaConf);
			}
			
			if( method_exists($_mediaObj, 'finishConnect') ) {
				$content = $_mediaObj->finishConnect();
			} else {
				$content = $media . ' -> finishConnect function could not be initiated'; 
			}
		}
	}
}
?>