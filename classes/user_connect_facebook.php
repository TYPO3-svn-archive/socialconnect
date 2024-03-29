<?php

include_once t3lib_extMgm::extPath('socialconnect')."library/tx_socialconnect_lib.php";

class user_connect_facebook {
	var $prefixId      = 'user_connect_facebook';		// Same as class name
	var $scriptRelPath = 'classes/user_connect_facebook.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'socialconnect';	// The extension key.
	
	var $mediaconf = array();
	var $consumer_key = '';
	var $consumer_secret = '';
	var $s_callbackUrl = '';
	
	var $pObj;
	var $oUser = array();
	
	function SC_enabledSocialMedia(&$enabledConf, $parentObj) {
		$this->pObj = $parentObj;
		$enabledConf['facebook'] = array (
			'userObj' => 'EXT:socialconnect/classes/user_connect_facebook.php:user_connect_facebook',
			'value' => 'facebook'
		);
	}
	
	function init($mediaconf) {
		$content = '';
		$pid = $_REQUEST['id'] ? $_REQUEST['id'] : 2;
		$this->buildTSFE($pid);
		$this->mediaconf = $mediaconf;
		$this->s_callbackUrl = 'http://'.$GLOBALS['_SERVER']['HTTP_HOST'].'/index.php?eID=socialconnect&media=facebook';
		return $content;
	}
	
	function buildTSFE($pid = 2) {
		//first check if its already build..
		if(empty($GLOBALS['TSFE'])) {
			//needed for TSFE
			require_once(PATH_t3lib.'class.t3lib_timetrack.php');
			require_once(PATH_t3lib.'class.t3lib_tsparser_ext.php');
			require_once(PATH_t3lib.'class.t3lib_page.php');
			require_once(PATH_t3lib.'class.t3lib_stdgraphic.php');
			//if(empty($BACK_PATH)) {$BACK_PATH = '/home/benjamin.nl/www/typo3/';}
			require_once(PATH_typo3.'sysext/cms/tslib/class.tslib_fe.php');
			require_once(PATH_typo3.'sysext/cms/tslib/class.tslib_content.php');
			require_once(PATH_typo3.'sysext/cms/tslib/class.tslib_gifbuilder.php');
			
			/* Declare */
			$temp_TSFEclassName = t3lib_div::makeInstanceClassName('tslib_fe');
		
			/* Begin */
			if (!is_object($GLOBALS['TT'])) {
				$GLOBALS['TT'] = new t3lib_timeTrack;
				$GLOBALS['TT']->start();
			}
		
			if (!is_object($GLOBALS['TSFE']) && $pid) {
				//*** Builds TSFE object
				$GLOBALS['TSFE'] = new $temp_TSFEclassName($GLOBALS['TYPO3_CONF_VARS'],$pid,0,0,0,0,0,0);
		
				//*** Builds sub objects
				$GLOBALS['TSFE']->tmpl = t3lib_div::makeInstance('t3lib_tsparser_ext');
				$GLOBALS['TSFE']->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');
				$GLOBALS['TSFE']->fe_user = t3lib_div::makeInstance('tslib_feUserAuth');
		
				//*** init template
				$GLOBALS['TSFE']->tmpl->tt_track = 0;// Do not log time-performance information
				$GLOBALS['TSFE']->tmpl->init();
		
				$rootLine = $GLOBALS['TSFE']->sys_page->getRootLine($pid);
				
				// initiate fe_user objects
				$GLOBALS['TSFE']->fe_user->name = 'fe_typo_user';
				$GLOBALS['TSFE']->fe_user->id = isset($_COOKIE['fe_typo_user']) ? stripslashes($_COOKIE['fe_typo_user']) : '';
				$GLOBALS['TSFE']->fe_user->fetchSessionData();
		
				//*** Builds a cObj
				$GLOBALS['TSFE']->newCObj();
			}
		} else {
			// dont overwrite object if already loaded..
		}
	}
	
	function showConnect() {
		global $GLOBALS; $content = '';
		
		$connectimg = '/typo3conf/ext/socialconnect/res/images/connect-with-facebook.gif';
		
		$content = 'facebook connect';
		return $content;
	}
	
	
	function finishConnect() {
		$content = ''; $here = $this->s_callbackUrl;
		
		return $content;
	}
	
	function postToNetwork($token, $secret, $message) {
		$this->buildTSFE();
		
		// get message
		$debug = array (
			'token' => $token,
			'secret' => $secret,
			'message' => $message
		);
		
		$postMessage = array();
		if( is_array($message) ) {
			if( is_array($message['lookUpTable']) ) {
				$query = $message['lookUpTable'];
				if( is_array($query['where']) ) {
					foreach($query['where'] as $key => $value) {
						$whereparts[] = $key . '="' . $value.'"';
					}
					$query['where'] = implode(' AND ', $whereparts);
				}
				
				$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
					$query['alias'] .' as message',
					$query['table'],
					$query['where'],
					'',
					'',
					1
				);
				$row = $row[0];
				$postMessage['message'] = $row['message'];
			}
			
			if( is_array($message['linkToPage']) ) {
				$linkToPage = $message['linkToPage'];
				if( is_array($linkToPage['typolink']) ) {
					// get URL made by realurl
					$link = $this->getURL($linkToPage['typolink']);
				}
				$postMessage['link'] = $link;
			}
			
		}
		$s_postMessage = implode(' ', $postMessage);
		// if length is longer than the maximum 140 chars, create an tinyurl
		if(strlen($s_postMessage) > 140) {
			$postMessage['link'] = $this->get_tiny_url($postMessage['link']);
			$s_postMessage = implode(' ', $postMessage);
		}
		
		// title news -> url -> possible hashtags
		
		// post message to facebook!
		
		return;
	}
	
	/**
  * This function will generate RealURLs
  * All thanks goes out to Sebastiaan de Jonge!
  */
	function getUrl($a_linkConfig){
		$cObj = t3lib_div::makeInstance('tslib_cObj');
		$o_realUrl = t3lib_div::makeInstance('tx_realurl');
		$GLOBALS['TSFE']->config['config']['tx_realurl_enable'] = 1;
		
		$i_pageUid = intval($a_linkConfig['parameter']);
		$s_additionalParams = $a_linkConfig['additionalParams'];
		$a_page = $GLOBALS['TSFE']->sys_page->checkRecord('pages', $i_pageUid, 0);
		$a_conf['LD'] = $GLOBALS['TSFE']->tmpl->linkData($a_page, '', 0, 'index.php', '', $s_additionalParams);
		$o_realUrl->encodeSpURL($a_conf, $this);
		$s_url = $a_conf['LD']['totalURL'];
		
		if (strstr($s_url, "http://") != $s_url) {
			// append http..
			$s_url = 'http://'.$GLOBALS['_SERVER']['HTTP_HOST'].'/'.$s_url;
		}
		
		return $s_url;
	}
	
	function get_tiny_url($url)  {  
		$ch = curl_init();  
		$timeout = 5;  
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
		$data = curl_exec($ch);  
		curl_close($ch);  
		return $data;  
	}
	
}

?>