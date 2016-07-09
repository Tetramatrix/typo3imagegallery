<?php
/***************************************************************
*
*  (c) 2006-2012 Chi Hoang (info@chihoang.de)
*  All rights reserved
*
***************************************************************/
if (!defined ('PATH_txchbildergalerie_hard'))
{
	define('PATH_txchbildergalerie_hard', t3lib_extMgm::extPath('ch_bildergalerie'));
}
require_once(PATH_t3lib.'class.t3lib_foldertree.php');
require_once(PATH_txchbildergalerie_hard.'mod_main/class.tx_ch1_browseTree.php');

class tx_ch1_treeConfigObject extends tx_ch1_browseTree
{
	var $isTCEFormsSelectClass = true;
	var $supportMounts = true;

	function tx_ch1_treeConfigObject()
	{
		global $LANG, $BACK_PATH;

		$this->title = $LANG->sL('LLL:EXT:ch_bildergalerie/mod_main/locallang.php:object',1);
		$this->treeName = 'txchvaObject';
		$this->domIdPrefix = $this->treeName;
		$this->stdselection = 'tree=object';
		$this->mode = 'elbrowser';

		$this->table='tx_chbildergalerie';
		$this->parentField = 'parent_id';
		$this->typeField = $GLOBALS['TCA'][$this->table]['ctrl']['type'];

		$this->iconName = 'cat.gif';
		$this->iconPath = '../res/';
		$this->rootIcon = '../res/catfolder.gif';

		$this->fieldArray = Array ( 'uid', 'title' );
		if($this->parentField) $this->fieldArray[] = $this->parentField;
		if($this->typeField) $this->fieldArray[] = $this->typeField;
		$this->defaultList = 'uid,pid,tstamp';

		$this->clause = ' AND deleted=0 AND hidden=0';
		$this->orderByFields = 'title';

		$this->ext_IconMode = '0'; // no context menu on icons
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ch_bildergalerie/mod_main/class.tx_ch1_treeConfig.php'])
{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ch_bildergalerie/mod_main/class.tx_ch1_treeConfig.php']);
}
?>
