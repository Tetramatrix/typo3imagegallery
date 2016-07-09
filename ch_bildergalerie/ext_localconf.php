<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_chbildergalerie=1
');

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_chbildergalerie_pi1.php', '_pi1', 'list_type', 0);

$TYPO3_CONF_VARS['FE']['eID_include']['ch_bildergalerie'] = 'EXT:ch_bildergalerie/classes/ajax.php';
?>
