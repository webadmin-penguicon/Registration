<?php
date_default_timezone_set('America/Detroit');

session_start();
$hybrid_config = dirname(__FILE__) . '/hybridauth/config.php';
define("HYBRID_CONFIG",$hybrid_config);

require_once('hybridauth/Hybrid/Auth.php');

?>
