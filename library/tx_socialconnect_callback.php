<?php
//error_reporting(E_ALL ^ E_NOTICE);

include_once(t3lib_extMgm::extPath('socialconnect').'classes/user_connect_twitter.php');
$conf = array (
	'userObj' => 'EXT:socialconnect/classes/user_connect_twitter.php:user_connect_twitter',
	'value' => 'twitter'
);

// initiate plugin for callback
$obj = new user_connect_twitter();
$obj->init($conf);
$content = $obj->finishConnect();

echo $content;

// refresh the parent page and exit the current
echo '
<script type="text/javascript">
	window.opener.location.reload();
	window.close();
</script>
';
// close window..
?>
Loading..