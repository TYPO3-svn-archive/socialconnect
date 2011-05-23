<?php
//error_reporting(E_ALL ^ E_NOTICE);
require_once t3lib_extMgm::extPath('socialconnect')."userFunc/class.user_socialconnect_connect.php";

$media = $_GET['media'];
$socialconnect = new user_socialconnect_connect();
$socialconnect->finishConnect($media);


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