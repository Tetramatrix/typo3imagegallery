<?php

define('TYPO3_MOD_PATH', '../typo3conf/ext/ch_bildergalerie/mod_main/');
$BACK_PATH='../../../../typo3/';

$MCONF['name']='txchbildergalerieM1';

$MLANG['default']['tabs_images']['tab'] = 'moduleicon.gif';
$MLANG['default']['ll_ref']='LLL:EXT:ch_bildergalerie/mod_main/locallang_mod.php';

$MCONF['access']='user,group';

$MCONF['navFrameScript']='class.tx_ch1_navframe.php';
$MCONF['defaultMod']='object';

?>
