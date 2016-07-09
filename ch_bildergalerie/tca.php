<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_chbildergalerie'] = array (
	'ctrl' => $TCA['tx_chbildergalerie']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,title,image'
	),
	'feInterface' => $TCA['tx_chbildergalerie']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'title' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ch_bildergalerie/locallang_db.xml:tx_chbildergalerie.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
                'image' => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ch_bildergalerie/locallang_db.xml:tx_chbildergalerie.image",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "gif,png,jpeg,jpg",	
				"max_size" => 100000,	
				"uploadfolder" => "uploads/tx_chbildergalerie",
                                "show_thumbs" => 1,
				"size" => 20,	
				"minitems" => 1,
				"maxitems" => 30,
			)
		),
                'parent_id' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:ch_bildergalerie/locallang_db.xml:tx_chbildergalerie.parent_id',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'title;;;;2-2-2, image')
	),
	'palettes' => array (
                '1' => array('showitem' => '')
	)
);
?>