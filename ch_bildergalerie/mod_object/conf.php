<?php

	// DO NOT REMOVE OR CHANGE THESE 3 LINES:
define('TYPO3_MOD_PATH', '../typo3conf/ext/ch_bildergalerie/mod_object/');
$BACK_PATH='../../../../typo3/';

$MCONF["name"]="txchbildergalerieM1_object";
	
$MCONF["access"]="user,group";
$MCONF["script"]="index.php";

$MLANG["default"]["tabs_images"]["tab"] = "moduleicon.gif";
$MLANG["default"]["ll_ref"]="LLL:EXT:ch_bildergalerie/mod_object/locallang_mod.php";

$MCONF['navFrameScript']='tx_chdummy.php';
$MCONF['navFrameScriptParam']='&tree=object';
?>
