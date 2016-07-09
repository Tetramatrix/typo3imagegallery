<?php
/***************************************************************
*
*  (c) 2010-2012 Chi Hoang (info@chihoang.de)
*  All rights reserved
*  
***************************************************************/
require_once ( PATH_tslib.'class.tslib_pibase.php' );
require_once ( "JSON.php" );
require_once ( "simpleImage.php" );

class bildergalerie extends tslib_pibase
{
	function main()
	{
		session_start();
		
		tslib_eidtools::connectDB(); //Connect to database
		
		if ( empty ( $_GET[ "uid" ] ) )
		{	
			$res = $GLOBALS [ 'TYPO3_DB' ]->exec_SELECTquery (
				'V.image VI, V.title VT, V.uid UID',
				'tx_chbildergalerie V',
				'pid='.$_SESSION [ "sysfolder" ].' AND parent_id=0 AND V.deleted=0 AND V.hidden=0',
				'',
				'sorting ASC'
			);
			
			$_SESSION [ "counter" ] ++;
		} else if ( ! empty ( $_GET[ "uid" ] ) ) 
		{
			$res = $GLOBALS [ 'TYPO3_DB' ]->exec_SELECTquery (
				'V.image VI, V.title VT, V.uid UID',
				'tx_chbildergalerie V',
				'UID='.mysql_real_escape_string($_GET[ "uid" ]). ' AND pid='.$_SESSION [ "sysfolder" ].' AND parent_id=0 AND V.deleted=0 AND V.hidden=0',
				'',
				'sorting ASC LIMIT 1 '
			);
		}

		while ( $record = $GLOBALS [ 'TYPO3_DB' ]->sql_fetch_assoc ( $res ) )
		{
			$m [ "screen" ] [ ] = array ( "title" => $record [ "VT" ],
						      "image" =>  $_SESSION [ 'uploadPath' ] . '/' . reset ( explode ( ",", $record [ "VI"] ) ),
						      "uid" => $record [ "UID" ]
						    );

			$array = explode ( ",", $record [ "VI"] );
			$addr = substr(md5($timestamp),0,4);
			
			if ( empty ( $_GET[ "uid" ] ) )
			{
				$v = reset ( $array );
				$image = new SimpleImage();
				$image->load( $_SESSION [ 'uploadPath' ] . '/' . $v );
				$image->resizeToWidth(200);
				
				$fx = $_SESSION [ 'uploadPath' ] . '/' . "fx_" . $addr . "_". $record [ "VT" ] . "_" . $v;
				$image->save( $fx );
				//list( $width, $height, $type, $attr) = getimagesize( $fx );
				list( $width, $height, $type, $attr) = array ( 200, 79, 0, 0 );
				$m [ "fx_" ] [ ] = array ( "image" => $fx,
							   "width" => $width,
							   "height" => $height,
							   "bwidth" => $width+13,
							   "bheight" => $height+20+30,
							   "uid" => $record [ "UID" ],
							   "title" => $record [ "VT" ]
							 );
			
			} else
			{
				foreach ( $array as $k => $v )
				{
					$image = new SimpleImage();
					$image->load( $_SESSION [ 'uploadPath' ] . '/' . $v );
					$image->resizeToWidth(200);
					
					$fx = $_SESSION [ 'uploadPath' ] . '/' . "fx_" . $addr . "_". $record [ "VT" ] . "_" . $v;
					$image->save( $fx );
					//list( $width, $height, $type, $attr) = getimagesize( $fx );
					list( $width, $height, $type, $attr) = array ( 200, 79, 0, 0 );
					$m [ "fx_" ] [ ] = array (
				  				   "image" => $_SESSION [ 'uploadPath' ] . '/' . $v,
								   "thumbnail" => $fx,
								   "width" => $width,
								   "height" => $height,
								   "bwidth" => $width+13,
								   "bheight" => $height+20,
								   "uid" => $record [ "UID" ],	
								 );
				}
				
				$m [ "screen" ] = array ();
				
				$res = $GLOBALS [ 'TYPO3_DB' ]->exec_SELECTquery (
					'V.image VI, V.title VT, V.uid UID',
					'tx_chbildergalerie V',
					'pid='.$_SESSION [ "sysfolder" ].' AND parent_id=0 AND V.deleted=0 AND V.hidden=0',
					'',
					'sorting ASC'
				);
				
				while ( $record = $GLOBALS [ 'TYPO3_DB' ]->sql_fetch_assoc ( $res ) )
				{
						$m [ "screen" ] [ ] = array ( "title" => $record [ "VT" ],
									      "image" =>  $_SESSION [ 'uploadPath' ] . '/' . reset ( explode ( ",", $record [ "VI"] ) ),
									      "uid" => $record [ "UID" ]
									    );
				}
				
			}
		}
		echo json_encode ( $m );	
	}
}

header('content-type: text/html; charset=utf-8');
header("Expires: Sat, 1 Jan 2005 00:00:00 GMT");
header("Last-Modified: ".gmdate( "D, d M Y H:i:s")."GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
	
$output = t3lib_div::makeInstance('bildergalerie');
$output->main();
?>