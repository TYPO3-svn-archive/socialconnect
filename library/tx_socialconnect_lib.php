<?php
class lib_socialconnect_be {
	public static $extKey = 'socialconnect';	// The extension key.
	
	function createJSPopup($uid, $str, $url) {
		$content = '';
		$content .= self::getWindowHTML($uid, $str);
		$content .= self::getIframePopupJS($uid, $url);
		
		return $content;
	}
	
	function init_enabledSocialMedia() {
		$enabledSocialMedia = array();
		// add hook
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][self::$extKey]['SC_enabledSocialMedia'])) { // Adds hook for multiple media
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][self::$extKey]['SC_enabledSocialMedia'] as $_classRef) {
				$_procObj = & t3lib_div::getUserObj($_classRef);
				$_procObj->SC_enabledSocialMedia($enabledSocialMedia, $this); // Get enabled social media Array from other extensions
			}
		}
		return $enabledSocialMedia;
	}
	
	static function getIframePopupJS($uid, $url, $width = 600, $height = 520) {
		$content = "
<script type=\"text/javascript\">
	function openPopup() {
		// open the url in new window
		window.open('".$url."', 'twitterconnect', 'width=600,height=530');
	}
	if (typeof Ext == 'undefined') {  
	    // ExtJS is not loaded
	    
	    
	    // just open the window.
	} else {
	    // ExtJS is loaded
		Ext.select('#tx-socialconnect-uid-".$uid."').on('click', function(){
			/**
			 * Generate and render the panel
			 */
			var filterPanel = new Ext.FormPanel({
				title: 'Message Form',
				id: 'rkMessagingForm',
				header: false,
				defaultType: 'textfield',
				scope: this,
				bodyStyle: 'padding: 5px 5px 3px 5px; border-width: 0; margin-bottom: 7px;',
				labelAlign: 'right',
		
				items: [{
						xtype: 'panel',
						bodyStyle: 'margin-bottom: 7px; border: none;',
						html: '<div id=\"tx-rkmessaging-options\"></div>'
					}
				],
				keys:({
					key: Ext.EventObject.ENTER,
					fn: this.triggerSubmitForm,
					scope: this
				}),
				buttons: [{
					text: 'Afronden',
					formBind: true,
					handler: function(){
						Ext.getCmp('socialconnectWindow').close();
						window.location.reload()
					},
				},
				{
					text: 'Cancel',
					formBind: true,
					handler: function(){
						Ext.getCmp('socialconnectWindow').close();
					},
				}] 
			});
			
			var filterDialog = new Ext.Window({
					id: 'socialconnectWindow',
					title: 'Message',
					width: 300,
					height: 200,
					closable: true,
					resizable: false,
					plain: true,
					border: false,
					//modal: true,
					draggable: true,
					items: [filterPanel]
				});
			
			Ext.getCmp('socialconnectWindow').show();
			
			/*
			Ext.Ajax.request({
				url: 'ajax.php',
				params: {
					'ajaxID': 'tx_rkmessaging::remove',
					'tx-rkmessaging-uid': Ext.get('tx-rkmessaging-uid').dom.value
				},
				method: 'GET',
				success: function(response) {
					parentNode = Ext.get('tx-rkmessaging-uid').dom.parentNode.parentNode.parentNode;
					Ext.get(parentNode).fadeOut({useDisplay: true});
				},
				scope: this
			});*/
			
			/**
			 * Generate the flag lists, this is done through ajax since it might change if we
			 * have multiple instances of the back-end opened. Next to that we won't have to 
			 * reload the entire back-end. 
			 */
			Ext.Element.get('tx-rkmessaging-options').insertHtml('afterBegin','<p>Follow the steps of the popup..</p><p>After authorisation, press finish.</p>');
		});
	}
</script>
		";
		return $content;
	}
	
	function getWindowHTML($uid, $str) {
		// wrap in an div with identifierid
		$content = '<div id="tx-socialconnect-uid-'.$uid.'" style="cursor: pointer;"><a onclick="javascript: openPopup(); return false;">'.$str.'</a></div>';
		return $content;
	}
	
	function getConnectedMedia() {
		$confArray = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][self::$extKey]);
		$networks = array();
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			'uid, network, name',
			'tx_socialconnect_networks',
			'1=1 AND deleted=0'
		);
		
		while( $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res) ) {
			$networks[$row['network']][$row['uid']] = $row['name'];
		}
		
		$compare_1 = serialize($confArray['connectedMedia']);
		$compare_2 = serialize($networks);
		if($compare_1 !== $compare_2) {
			self :: setToLocalConf(array('connectedMedia' => $networks));
		}
		
		return $networks;
	}
	
	/*
	 *
	 *
	 * Variable should look like:
	 * $params = array (
	 *	'network' => '',
	 *	'networkid' => '',
	 *	'screenname' => '',
	 *	'token' => '',
	 *	'secret' => ''
	 *);
	 *
	 */
	function createAccount($params) {
		// check fields if nothing is empty
		$fields = array('network','networkid','screenname','token','secret');
		$noerrors = true;
		foreach($fields as $field) {
			if(empty($params[$field])) $noerrors = false;
		}
		
		if($noerrors) {
			$tstamp = time();
			$whereConf = array(
				'network="'.$params['network'].'"',
				'networkid='.$params['networkid'],
			);
			$where = implode(' AND ', $whereConf);
			// check if user exists -> execSelectGetSingleRow does not work for earlier versions..
			$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid','tx_socialconnect_networks',$where, '', '', 1);
			$row = $row[0];
			// if user exists, update
			if(!empty($row)) { 
				$updateValues = array (
					'tstamp' => $tstamp,
					'name' => $params['screenname'],
				);				
				
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery(
					'tx_socialconnect_networks',
					$where,
					$updateValues
				);
			} else {
			// else insert..
				$insertValues = array (
					'tstamp' => $tstamp,
					'crdate' => $tstamp,
					'cruser_id' => '',
					'network' => $params['network'],
					'networkid' => $params['networkid'],
					'name' => $params['screenname'],
					'userkey' => $params['token'],
					'secret' => $params['secret']
				);
				$GLOBALS['TYPO3_DB']->exec_INSERTquery(
					'tx_socialconnect_networks',
					$insertValues
				);
			}
						
			self::getConnectedMedia();
			
			return true;
		}	
		
		return false;
	}
	
	function setToLocalConf($a_socialMedia) {
		// write the new configuration at localconf.php
		// stolen from core =)
		
		// Instance of install tool
		$instObj = new t3lib_install;
		$instObj->allowUpdateLocalConf = 1;
		$instObj->updateIdentity = 'TYPO3 Social Connect Extension';
		
		// Get lines from localconf file
		$lines = $instObj->writeToLocalconf_control();
		$serializedData = serialize($a_socialMedia);
		$instObj->setValueInLocalconfFile($lines, '$TYPO3_CONF_VARS[\'EXT\'][\'extConf\'][\''.self :: $extKey.'\']', $serializedData);
		$instObj->writeToLocalconf_control($lines);
		t3lib_extMgm::removeCacheFiles();
	}
	
	function postToMedia($media, $conf, $message) {
		$content = '';
		$enabledSocialMedia = self :: init_enabledSocialMedia();
		// add to render
		$_mediaObj = t3lib_div::getUserObj($enabledSocialMedia[$media]['userObj']);
		if( method_exists($_mediaObj, 'init') ) {
			$content .= $_mediaObj->init($conf);
		}
		// get token and secret
		if( !empty($conf['socialconnectid']) ) {
			$uid = intval($conf['socialconnectid']);
 
			$row = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'name, userkey, secret',
				'tx_socialconnect_networks',
				'uid = ' .$uid,
				'',
				'',
				1
			);
			$row = $row[0];
			
			$token = $row['userkey'];
			$secret = $row['secret'];
			
			$username = $row['name'];
		}
		
		if( method_exists($_mediaObj, 'postToNetwork') ) {
			$s_message = self :: renderOutputMessage($message);
			$posted = $_mediaObj->postToNetwork($token, $secret, $s_message);
			if($posted === true) {
				$title = 'Succesfull posted to network';
				$text = 'The message has been posted on '. $media .' with the account: '.$username;
				$flashType = t3lib_FlashMessage::OK;	
			} else {
				$title = 'Error while posting';
				$flashType = t3lib_FlashMessage::ERROR;
				$text = 'There went something wrong when posting to the '. $media .' network with the account: '.$username;
				if(is_string($posted)) {
					$text .= '<br /> Reason: '. $posted;
				}
			}
			$message = t3lib_div::makeInstance(
				    't3lib_FlashMessage',
				    $text,
				    $title,
				    $flashType,
				    1
				);
			t3lib_FlashMessageQueue::addMessage($message);	    
		} else {
			$content .= $media . ' -> postToNetwork function could not be initiated'; 
		}
		return '<div>'.$content.'</div>';
	}
	
	function renderOutputMessage($config) {
		$postMessage = array();
		if( is_array($config) ) {
			$postMessage['message'] = '';
			
			if( isset($config['prepend']) ) {
				$postMessage['message'] .= $config['prepend'];
			}
			
			if( is_array($config['lookUpTable']) ) {
				$query = $config['lookUpTable'];
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
				$postMessage['message'] .= $row['message'];
			}
			
			if( isset($config['append']) ) {
				$postMessage['message'] .= $config['append'];
			}
			
			if( is_array($config['linkToPage']) ) {
				$linkToPage = $config['linkToPage'];
				if( is_array($linkToPage['typolink']) ) {
					// get URL made by realurl
					$link = self :: getURL($linkToPage['typolink']);
				}
				$postMessage['link'] = $link;
			}
			
		}
		$s_postMessage = implode(' ', $postMessage);
		// if length is longer than the maximum 140 chars, create an tinyurl
		if(strlen($s_postMessage) > 140) {
			$postMessage['link'] = self :: get_tiny_url($postMessage['link']);
			$s_postMessage = implode(' ', $postMessage);
		}
		
		return $s_postMessage;
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