<?php
/***************************************************************
*
*  (c) 2010-2012 Chi Hoang (info@chihoang.de)
*  All rights reserved
*
***************************************************************/
if (!defined ('PATH_txchbildergalerie')) {
	define('PATH_txchbildergalerie', t3lib_extMgm::extPath('ch_bildergalerie'));
}
require_once(PATH_txchbildergalerie.'mod_main/class.tx_ch1_treeConfig.php');

class tx_ch1_treeView {

	/**
	 * initialize the browsable trees
	 * 
	 * @param	string		script name to link to
	 * @param	boolean		Element browser mode
	 * @return	void		
	 */
	function init($thisScript, $mode='browse')
	{
		global $BE_USER,$LANG,$BACK_PATH,$TYPO3_CONF_VARS;

		$TYPO3_CONF_VARS['EXTCONF']['ch_1']['selectionClasses'] = array();
		$temp=preg_replace('/\?.+/','',t3lib_div::_GP('tree'));
		
		if ($temp == 'object')
		{			
			$TYPO3_CONF_VARS['EXTCONF']['ch_1']['selectionClasses']['txchvaObject'] = 'EXT:ch_1/mod_main/class.tx_ch1_treeConfig.php:&tx_ch1_treeConfigObject';
		}
		
    		$this->initSelectionClasses($TYPO3_CONF_VARS['EXTCONF']['ch_1']['selectionClasses'], $thisScript, $mode);
	}

	/**
	 * initialize the browsable trees
	 * 
	 * @param	array		$TYPO3_CONF_VARS['EXTCONF']['dam']['selectionClasses']
	 * @param	string		script name to link to
	 * @param	boolean		Element browser mode
	 * @return	void		
	 */
	function initSelectionClasses($selectionClassesArr, $thisScript, $mode='browse')
	{
		global $BE_USER,$LANG,$BACK_PATH;

		if (is_array($selectionClassesArr))	{
			foreach($selectionClassesArr as $classKey => $classRef)
			{
				if (is_object($obj = &t3lib_div::getUserObj($classRef)))
				{
					if (!$obj->isPureSelectionClass)
					{
						if ($obj->isTreeViewClass)
						{	
								// object is a treeview class itself or just no tree class
							$this->arrayTree[$classKey] = &$obj;
							$this->arrayTree[$classKey]->init();

						} else
						{
								// object does not include treeview functionality. Therefore the standard browsetree is used with setup from the object
							$this->arrayTree[$classKey] = &t3lib_div::makeInstance('tx_ch1_browseTree');
							$this->arrayTree[$classKey]->init();
							$this->arrayTree[$classKey]->title = $obj->dam_treeTitle();
							$this->arrayTree[$classKey]->treeName = $obj->dam_treeName();
							$this->arrayTree[$classKey]->iconName = basename($obj->dam_defaultIcon());
							$this->arrayTree[$classKey]->iconPath = dirname($obj->dam_defaultIcon()).'/';
							$this->arrayTree[$classKey]->setDataFromArray($obj->getTreeArray());

						}

						$this->arrayTree[$classKey]->thisScript = $thisScript;
						$this->arrayTree[$classKey]->BE_USER = $BE_USER;
						$this->arrayTree[$classKey]->mode = $mode;
						//$this->arrayTree[$classKey]->ext_IconMode = '1'; // no context menu on icons
					}

					if ($this->arrayTree[$classKey]->supportMounts)
					{
						$mounts = $this->getMountsForTreeClass($classKey, $this->arrayTree[$classKey]->dam_treeName());
						if (count($mounts))
						{
							$this->arrayTree[$classKey]->setMounts($mounts);
						} else
						{
							unset($this->arrayTree[$classKey]);
						}
					}
				}
			}
		}
	}

	/**
	 * rendering the browsable trees
	 * 
	 * @return	string		tree HTML content
	 */
	function getTrees()
	{
		global $LANG,$BACK_PATH;

		$tree = '';
		if (is_array($this->arrayTree))
		{
			foreach($this->arrayTree as $treeName => $treeObj)
			{
				$res = $GLOBALS [ 'TYPO3_DB' ] -> sql_query (
					'SELECT V.pid, U.uid, U.title title 
					 FROM 
					tx_chbildergalerie V
					LEFT JOIN pages U ON U.uid=V.pid
					 WHERE V.deleted=0 AND V.hidden=0 
					GROUP BY V.pid'
				);
				
				while ( $row = $GLOBALS [ 'TYPO3_DB' ]->sql_fetch_assoc ( $res ) )
				{
					$treeObj->title = $row [ "title" ];
					
					$treeObj->clause = ' AND deleted=0 AND hidden=0 AND pid=' . $row [ "pid" ];
					$tree .= $treeObj->getBrowsableTree();
				}	
			}
		}
		return $tree;
	}

	function getMountsForTreeClass($classKey, $treeName='')
	{
		global $BE_USER, $TYPO3_CONF_VARS;

		if(!$treeName)
		{
			if (is_object($obj = &t3lib_div::getUserObj($TYPO3_CONF_VARS['EXTCONF']['ch_1']['selectionClasses'][$classKey])))	 {
				$treeName = $obj->dam_treeName();
			}
		}


		$mounts = array();
		if($GLOBALS['BE_USER']->user['admin'])
		{
			$mounts = array(0 => 0);
			return $mounts;
		}

		if ($GLOBALS['BE_USER']->user['tx_dam_mountpoints'])
		{
			 $values = explode(',',$GLOBALS['BE_USER']->user['tx_dam_mountpoints']);
			 foreach($values as $mount)
			 {
			 	list($k,$id) = explode(':', $mount);
			 	if ($k == $treeName)
				{
					$mounts[$id] = $id;
			 	}
			 }
		}

		if(is_array($GLOBALS['BE_USER']->userGroups))
		{
			foreach($GLOBALS['BE_USER']->userGroups as $group)
			{
				if ($group['tx_dam_mountpoints'])
				{
					$values = explode(',',$group['tx_dam_mountpoints']);
					 foreach($values as $mount)
					 {
					 	list($k,$id) = explode(':', $mount);
					 	if ($k == $treeName)
						{
							$mounts[$id] = $id;
					 	}
					 }
				}
			}
		}

			// if root is mount just set it and remove all other mounts
		if(isset($mounts[0]))
		{
			$mounts = array(0 => 0);
		}

		return $mounts;
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ch_1/interfaces/class.tx_ch1_treeView.php'])
{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ch_1/interfaces/class.tx_ch1_treeView.php']);
}

?>