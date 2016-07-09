<?php

########################################################################
# Extension Manager/Repository config file for ext "ch_bildergalerie".
#
# Auto generated 27-06-2012 13:08
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'ch_bildergalerie',
	'description' => 'Typo3 Extension zur Darstellung von Bildergalerien',
	'category' => 'plugin',
	'author' => 'Chi Hoang',
	'author_email' => 'info@chihoang.de',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => 'uploads/tx_chbildergalerie/',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'0' => '',
	'_md5_values_when_last_written' => 'a:83:{s:9:"ChangeLog";s:4:"28b2";s:10:"README.txt";s:4:"ee2d";s:13:"designer.html";s:4:"f9bb";s:21:"ext_conf_template.txt";s:4:"6d27";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"5a8d";s:14:"ext_tables.php";s:4:"34a8";s:14:"ext_tables.sql";s:4:"7b01";s:19:"flexform_ds_pi1.xml";s:4:"b12b";s:27:"icon_tx_chbildergalerie.gif";s:4:"475a";s:13:"locallang.xml";s:4:"016d";s:16:"locallang_db.xml";s:4:"623b";s:7:"tca.php";s:4:"fe1f";s:16:"classes/JSON.php";s:4:"df26";s:16:"classes/ajax.php";s:4:"6819";s:38:"classes/class.tx_ch1_scriptclasses.php";s:4:"9519";s:31:"classes/class.tx_ch1_tested.php";s:4:"e39b";s:23:"classes/simpleImage.php";s:4:"27de";s:19:"doc/wizard_form.dat";s:4:"3008";s:20:"doc/wizard_form.html";s:4:"5eba";s:26:"images/arrows-metallic.png";s:4:"9f9e";s:28:"images/arrows-minimalist.png";s:4:"1f16";s:23:"images/construction.gif";s:4:"d845";s:23:"images/cs-portfolio.png";s:4:"8680";s:18:"images/default.png";s:4:"c2b6";s:25:"images/lightbox-blank.gif";s:4:"fc94";s:29:"images/lightbox-btn-close.gif";s:4:"2c38";s:28:"images/lightbox-btn-next.gif";s:4:"2341";s:28:"images/lightbox-btn-prev.gif";s:4:"5a91";s:31:"images/lightbox-ico-loading.gif";s:4:"b5fe";s:36:"interfaces/class.tx_ch1_treeView.php";s:4:"b3d4";s:32:"mod_main/class.tx_ch1_beform.php";s:4:"4c76";s:36:"mod_main/class.tx_ch1_browseTree.php";s:4:"68f8";s:34:"mod_main/class.tx_ch1_navframe.php";s:4:"e2d4";s:36:"mod_main/class.tx_ch1_treeConfig.php";s:4:"b1a2";s:17:"mod_main/conf.php";s:4:"0b3f";s:22:"mod_main/locallang.php";s:4:"09dc";s:26:"mod_main/locallang_mod.php";s:4:"0b8d";s:23:"mod_main/moduleicon.gif";s:4:"3833";s:20:"mod_object/clear.gif";s:4:"cc11";s:19:"mod_object/conf.php";s:4:"5ea8";s:20:"mod_object/index.php";s:4:"6b9d";s:24:"mod_object/locallang.php";s:4:"62e9";s:28:"mod_object/locallang_mod.php";s:4:"861d";s:25:"mod_object/moduleicon.gif";s:4:"adc5";s:14:"pi1/ce_wiz.gif";s:4:"02b6";s:36:"pi1/class.tx_chbildergalerie_pi1.php";s:4:"668d";s:44:"pi1/class.tx_chbildergalerie_pi1_wizicon.php";s:4:"72c1";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.xml";s:4:"d1b1";s:22:"res/anythingslider.css";s:4:"738b";s:11:"res/cat.gif";s:4:"0e9a";s:12:"res/cat2.gif";s:4:"89a7";s:18:"res/cat2folder.gif";s:4:"b7f4";s:12:"res/cat3.gif";s:4:"2ed1";s:18:"res/cat3folder.gif";s:4:"2797";s:17:"res/catfolder.gif";s:4:"a16b";s:23:"res/darumosnabrueck.css";s:4:"0a13";s:18:"res/iconsprite.png";s:4:"75e8";s:23:"res/jquery-1.6.4.min.js";s:4:"9118";s:38:"res/jquery.anythingslider.1.8.4.min.js";s:4:"c5c6";s:32:"res/jquery.anythingslider.min.js";s:4:"565a";s:24:"res/jquery.easing.1.3.js";s:4:"6516";s:26:"res/jquery.imagesloaded.js";s:4:"244d";s:27:"res/jquery.lightbox-0.5.css";s:4:"7788";s:30:"res/jquery.lightbox-0.5.min.js";s:4:"a079";s:25:"res/jquery.masonry.min.js";s:4:"aa3b";s:22:"res/jquery.tmpl.min.js";s:4:"805c";s:14:"res/masonry.js";s:4:"6751";s:29:"res/modernizr.custom.94949.js";s:4:"62a3";s:14:"res/system.css";s:4:"905a";s:13:"res/system.js";s:4:"9c65";s:31:"res/theme-minimalist-square.css";s:4:"4b4c";s:30:"res/images/arrows-metallic.png";s:4:"9f9e";s:32:"res/images/arrows-minimalist.png";s:4:"1f16";s:27:"res/images/construction.gif";s:4:"d845";s:27:"res/images/cs-portfolio.png";s:4:"8680";s:22:"res/images/default.png";s:4:"c2b6";s:29:"res/images/lightbox-blank.gif";s:4:"fc94";s:33:"res/images/lightbox-btn-close.gif";s:4:"2c38";s:32:"res/images/lightbox-btn-next.gif";s:4:"2341";s:32:"res/images/lightbox-btn-prev.gif";s:4:"5a91";s:35:"res/images/lightbox-ico-loading.gif";s:4:"b5fe";}',
);

?>