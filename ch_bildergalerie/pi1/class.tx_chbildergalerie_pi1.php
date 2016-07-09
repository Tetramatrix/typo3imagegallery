<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011-2012 Chi Hoang <info@chihoang.de>
*  All rights reserved
*
***************************************************************/
require_once ( t3lib_extMgm::extPath ( 'ch_bildergalerie' ) . 'classes/class.tx_ch1_tested.php');

/**
 * Plugin 'ch_bildergalerie' for the 'ch_bildergalerie' extension.
 *
 * @author	Chi Hoang <info@chihoang.de>
 * @package	TYPO3
 * @subpackage	tx_chbildergalerie
 */
class tx_chbildergalerie_pi1 extends tx_ch1_tested
{
	var $prefixId      = 'tx_chbildergalerie_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_chbildergalerie_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'ch_bildergalerie';	// The extension key.
	
	// Meine Variablen
	var $lConf;
		
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
	
		session_start();
		
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_USER_INT_obj = 1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
	
			// Conf
		$this->confArray = unserialize ( $GLOBALS [ 'TYPO3_CONF_VARS' ][ 'EXT' ][ 'extConf' ] [ $this->extKey ] );	
		$this->pi_initPIflexForm ( );			// Init and get the flexform data of the plugin

			// Assign the flexform data to a local variable for easier access
		$piFlexForm = $this->cObj->data [ 'pi_flexform' ];
		$index = $this->lang [ $GLOBALS [ 'TSFE' ]->sys_language_uid ] == null ? 0 : $this->lang [ $GLOBALS [ 'TSFE' ]->sys_language_uid ];
		$sDef = current ( $piFlexForm [ 'data' ] );
		$lDef = array_keys ( $sDef );
        
		foreach ( $piFlexForm [ 'data' ] as $sheet => $data )
		{
			foreach ( $data [ $lDef [ $index ] ] as $key => $val )
			{
				$this->lConf [ $key ] = $this->pi_getFFvalue ( $piFlexForm, $key, $sheet,
									      $lDef[$index] );
			}
		}

		$_SESSION [ "sysfolder" ] = $this->lConf [ "sysfolder" ];
		$_SESSION [ "uploadPath" ] = "uploads/tx_chbildergalerie";
		
		$js .= $this->getCSSInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) . 'res/',
					     'darumosnabrueck.css' );
		$js .= $this->getCSSInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) . 'res/',
					     'system.css' );
		$js .= $this->getCSSInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) . 'res/',
					     'jquery.lightbox-0.5.css' );
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) .
						    'res/', 'jquery-1.6.4.min.js' );
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) .
						    'res/', 'jquery.masonry.min.js' );
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) .
						    'res/', 'modernizr.custom.94949.js' );
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) .
						    'res/', 'jquery.tmpl.min.js' );
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) .
						     'res/', 'jquery.imagesloaded.js' );
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) .
						    'res/', 'jquery.anythingslider.min.js' );
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie' ) .
						    'res/', 'jquery.easing.1.3.js' );
		//$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie') .
		//				    'res/', 'system.js');
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie') .
						    'res/', 'masonry.js');
		$js .= $this->getJavascriptInclude ( t3lib_extMgm::siteRelPath ( 'ch_bildergalerie') .
						    'res/', 'jquery.lightbox-0.5.min.js');

				
		$GLOBALS [ 'TSFE' ]->additionalHeaderData [ $this->prefixId ] = $js;

			// Get the template
 		$this->templateCode = $this->cObj->fileResource ( $_SESSION [ "uploadPath" ] . '/' .
								$this->lConf [ 'template_file' ] );
	
		$this->template [ 'galerie' ] = $this->cObj->getSubpart ( $this->templateCode, '###BILDERGALERIE###' );
		
		/*
		$this->template [ 'slider' ] = $this->cObj->getSubpart ( $this->templateCode, '###SLIDER###' );
		$this->template [ 'slider_item' ] = $this->cObj->getSubpart ( $this->template [ 'slider' ], '###ITEM_NO###' );
		
		$res = $GLOBALS [ 'TYPO3_DB' ]->exec_SELECTquery (
			'V.image VI, V.title VT, V.uid UID',
			'tx_chbildergalerie V',
			'pid='.$_SESSION [ "sysfolder" ].' AND parent_id=0 AND V.deleted=0 AND V.hidden=0',
			'',
			'sorting ASC'
		);

		while ( $record = $GLOBALS [ 'TYPO3_DB' ]->sql_fetch_assoc ( $res ) )
		{
			$m [ "###TITLE###" ] = $record [ "VT" ];
			$preview = explode (",", $record [ "VI"] );
			$m [ "###IMAGE###" ] = $this->confArray [ 'uploadPath' ] . '/' . $preview [ 0 ];
			$t [ ] = $this->cObj->substituteMarkerArray ( $this->template [ 'slider_item' ], $m );
		}

		unset ( $s );
		$s ["###ITEM_NO###"] = is_array ( $t ) ? implode ( '', $t ) : 'Fehler. Bitte Seite neuladen. Danke!';
		*/

		unset ( $m );
		$m ["###SLIDERMENU###"] = $this->cObj->substituteMarkerArrayCached ( $this->template [ "slider" ], array(), $s );
		
		
		
		$m ["###FORM###"] = $this->pi_getPageLink ( $GLOBALS [ 'TSFE' ]->id, '', array () );
		
		
		
		
		
		
		$content = $this->cObj->substituteMarkerArray ( $this->template [ 'galerie' ], $m );
		
		
		return $this->pi_wrapInBaseClass($content);
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ch_bildergalerie/pi1/class.tx_chbildergalerie_pi1.php'])
{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ch_bildergalerie/pi1/class.tx_chbildergalerie_pi1.php']);
}

?>
