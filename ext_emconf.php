<?php

########################################################################
# Extension Manager/Repository config file for ext "socialconnect".
#
# Auto generated 20-05-2011 16:46
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Connect to Social Network',
	'description' => 'An library which enables it to easy post to an social network.',
	'category' => 'misc',
	'author' => 'Benjamin Serfhos',
	'author_email' => 'benjamin@out2game.com',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:83:{s:9:"ChangeLog";s:4:"4ec3";s:10:"README.txt";s:4:"ee2d";s:21:"ext_conf_template.txt";s:4:"ad5e";s:12:"ext_icon.gif";s:4:"3f45";s:17:"ext_localconf.php";s:4:"bacf";s:14:"ext_tables.sql";s:4:"dc2b";s:16:"locallang_db.xml";s:4:"a19c";s:32:"classes/user_connect_twitter.php";s:4:"3748";s:20:"library/tmhOAuth.php";s:4:"92cc";s:37:"library/tx_socialconnect_callback.php";s:4:"32b6";s:32:"library/tx_socialconnect_lib.php";s:4:"ea81";s:32:"library/oauth/OAuthDiscovery.php";s:4:"39ce";s:33:"library/oauth/OAuthException2.php";s:4:"fbc7";s:30:"library/oauth/OAuthRequest.php";s:4:"0a3a";s:36:"library/oauth/OAuthRequestLogger.php";s:4:"c286";s:36:"library/oauth/OAuthRequestSigner.php";s:4:"df8d";s:38:"library/oauth/OAuthRequestVerifier.php";s:4:"0ee6";s:32:"library/oauth/OAuthRequester.php";s:4:"164b";s:29:"library/oauth/OAuthServer.php";s:4:"56d4";s:30:"library/oauth/OAuthSession.php";s:4:"492c";s:28:"library/oauth/OAuthStore.php";s:4:"408a";s:50:"library/oauth/body/OAuthBodyContentDisposition.php";s:4:"9acb";s:49:"library/oauth/body/OAuthBodyMultipartFormdata.php";s:4:"faaa";s:38:"library/oauth/discovery/xrds_parse.php";s:4:"93a9";s:38:"library/oauth/discovery/xrds_parse.txt";s:4:"ca45";s:52:"library/oauth/session/OAuthSessionAbstract.class.php";s:4:"d573";s:45:"library/oauth/session/OAuthSessionSESSION.php";s:4:"75e6";s:61:"library/oauth/signature_method/OAuthSignatureMethod.class.php";s:4:"6e79";s:65:"library/oauth/signature_method/OAuthSignatureMethod_HMAC_SHA1.php";s:4:"0c8c";s:59:"library/oauth/signature_method/OAuthSignatureMethod_MD5.php";s:4:"3708";s:65:"library/oauth/signature_method/OAuthSignatureMethod_PLAINTEXT.php";s:4:"44ad";s:64:"library/oauth/signature_method/OAuthSignatureMethod_RSA_SHA1.php";s:4:"3a78";s:38:"library/oauth/store/OAuthStore2Leg.php";s:4:"2dc1";s:48:"library/oauth/store/OAuthStoreAbstract.class.php";s:4:"24f2";s:41:"library/oauth/store/OAuthStoreAnyMeta.php";s:4:"dd35";s:39:"library/oauth/store/OAuthStoreMySQL.php";s:4:"a7ab";s:40:"library/oauth/store/OAuthStoreMySQLi.php";s:4:"601c";s:40:"library/oauth/store/OAuthStoreOracle.php";s:4:"4599";s:37:"library/oauth/store/OAuthStorePDO.php";s:4:"d144";s:44:"library/oauth/store/OAuthStorePostgreSQL.php";s:4:"448b";s:37:"library/oauth/store/OAuthStoreSQL.php";s:4:"cab0";s:41:"library/oauth/store/OAuthStoreSession.php";s:4:"2244";s:37:"library/oauth/store/mysql/install.php";s:4:"0ea5";s:35:"library/oauth/store/mysql/mysql.sql";s:4:"fe10";s:38:"library/oauth/store/oracle/install.php";s:4:"c8d7";s:55:"library/oauth/store/oracle/OracleDB/1_Tables/TABLES.sql";s:4:"89a1";s:61:"library/oauth/store/oracle/OracleDB/2_Sequences/SEQUENCES.sql";s:4:"5729";s:82:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_ADD_CONSUMER_REQUEST_TOKEN.prc";s:4:"a362";s:63:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_ADD_LOG.prc";s:4:"875a";s:72:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_ADD_SERVER_TOKEN.prc";s:4:"9c40";s:79:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_AUTH_CONSUMER_REQ_TOKEN.prc";s:4:"2a54";s:74:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_CHECK_SERVER_NONCE.prc";s:4:"a5bd";s:76:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_CONSUMER_STATIC_SAVE.prc";s:4:"3317";s:83:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_COUNT_CONSUMER_ACCESS_TOKEN.prc";s:4:"8ff0";s:76:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_COUNT_SERVICE_TOKENS.prc";s:4:"f4a2";s:71:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_DELETE_CONSUMER.prc";s:4:"ee1a";s:69:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_DELETE_SERVER.prc";s:4:"7814";s:75:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_DELETE_SERVER_TOKEN.prc";s:4:"0ee6";s:81:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_DEL_CONSUMER_ACCESS_TOKEN.prc";s:4:"bf81";s:82:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_DEL_CONSUMER_REQUEST_TOKEN.prc";s:4:"aded";s:83:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_EXCH_CONS_REQ_FOR_ACC_TOKEN.prc";s:4:"881f";s:68:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_CONSUMER.prc";s:4:"b182";s:81:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_CONSUMER_ACCESS_TOKEN.prc";s:4:"b172";s:82:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_CONSUMER_REQUEST_TOKEN.prc";s:4:"4be8";s:82:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_CONSUMER_STATIC_SELECT.prc";s:4:"2efd";s:81:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_SECRETS_FOR_SIGNATURE.prc";s:4:"0d0c";s:78:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_SECRETS_FOR_VERIFY.prc";s:4:"3ed4";s:66:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_SERVER.prc";s:4:"1269";s:74:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_SERVER_FOR_URI.prc";s:4:"33a3";s:72:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_SERVER_TOKEN.prc";s:4:"5db3";s:80:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_GET_SERVER_TOKEN_SECRETS.prc";s:4:"8b32";s:70:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_LIST_CONSUMERS.prc";s:4:"46cc";s:76:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_LIST_CONSUMER_TOKENS.prc";s:4:"e1c1";s:64:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_LIST_LOG.prc";s:4:"1ba6";s:68:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_LIST_SERVERS.prc";s:4:"13ab";s:74:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_LIST_SERVER_TOKENS.prc";s:4:"23e7";s:82:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_SET_CONSUMER_ACC_TOKEN_TTL.prc";s:4:"b2fe";s:76:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_SET_SERVER_TOKEN_TTL.prc";s:4:"0ccc";s:71:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_UPDATE_CONSUMER.prc";s:4:"a2aa";s:69:"library/oauth/store/oracle/OracleDB/3_Procedures/SP_UPDATE_SERVER.prc";s:4:"8689";s:40:"library/oauth/store/postgresql/pgsql.sql";s:4:"2591";s:35:"res/images/connect-with-twitter.gif";s:4:"719e";s:45:"userFunc/class.user_socialconnect_connect.php";s:4:"fa7d";}',
	'suggests' => array(
	),
);

?>