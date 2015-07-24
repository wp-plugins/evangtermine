<?php
// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function et_veranstalter( $et_defaults ) {
	// Parameter aus Shortcodes und Widget einlesen
	if( $et_defaults[ 'vid' ] || $et_defaults[ 'region' ] ) {
		$encoding = get_option( 'encoding' ) ? get_option( 'encoding' ) : ET_DEFAULT_CHARSET;
/*
		if( get_option( 'css' ) ) {
			$css = get_option( 'css' );
		} else {
			$css = plugins_url( 'assets/css/evangtermine.css', EVANGTERMINE_PLUGIN_PATH . 'evangtermine' );
		}
*/
		$css = 'nocss';

		// Session für Evangelischen Termine aufbauen
		if( !session_id() ) {
			session_start();
		}
		
		if( !isset ( $_SESSION[ 'session' ] ) ) {
			$session = new stdClass;
			$_SESSION[ 'session' ] = $session;
		} else {
			$session = $_SESSION[ 'session' ];
		}
		
		// Sessionvariable setzen
		function et_setsessionvar( $key, $sess, $default = NULL ) {
			if( '' != $_REQUEST[ $key ] ) {
				$sess->{ $key } = $_REQUEST[ $key ];
				if( 'pageID' != $key ) {
					$sess->pageID = 1;
				}
			}
			if( '' == $sess->{ $key } ) {
				$sess->{ $key } = $default;
			}
		}
		
		// Filter zurücksetzen
		function et_resetsessionvars( $sess, $defaults ) {
			$sess->vid = $defaults[ 'vid' ];
			$sess->region = $defaults[ 'region' ];
			$sess->eventtype = $defaults[ 'eventtype' ];
			$sess->highlight = $defaults[ 'highlight' ];
			$sess->people = $defaults[ 'people' ];
			$sess->pagID = 1;
			$sess->et_q = '';
			$sess->itemsPerPage = $defaults[ 'itemsPerPage' ];
			$sess->date = '';
		}
		
		if( '1' == $_REQUEST[ 'reset' ] ) {
			et_resetsessionvars( $session, $et_defaults );
		} else {
			et_setsessionvar( 'vid', $session, $et_defaults[ 'vid' ] );
			et_setsessionvar( 'region', $session, $et_defaults[ 'region' ] );
			// et_setsessionvar( 'aid', $session, $et_defaults[ 'aid' ] );
			et_setsessionvar( 'date', $session, '' );
			et_setsessionvar( 'eventtype', $session, $et_defaults[ 'eventtype' ] );
			et_setsessionvar( 'highlight', $session, $et_defaults[ 'highlight' ] );
			et_setsessionvar( 'people', $session, $et_defaults[ 'people' ] );
			et_setsessionvar( 'itemsPerPage', $session, $et_defaults[ 'itemsPerPage' ] );
			et_setsessionvar( 'pageID', $session, '1' );
			
			if( '' != $_REQUEST[ 'et_q' ] ) {
				$session->et_q = $_REQUEST[ 'et_q' ];
				if( '1' == $_REQUEST[ 'reset' ] ) {
					$session->et_q = '';
				}
			} else {
				if( 'search' == $_REQUEST[ 'action' ] ) {
					$session->et_q = '';
				}
			}
		}
			
		$querystring = 'vid='		. $session->vid .
						'&'.'region='	. $session->region .
						'&aid='			. $session->aid .
						'&date='			. $session->date .
						'&highlight='	. $session->highlight .
						'&eventtype='	. $session->eventtype .
						'&people='		. $session->people .
						'&et_q='			. $session->et_q .
						'&place='		. $et_defaults[ 'place' ] .
						'&person='		. $et_defaults[ 'person' ] .
						'&ipm='			. $et_defaults[ 'ipm' ] .
						'&cha='			. $et_defaults[ 'cha' ] .
						'&until='		. $et_defaults[ 'until' ] .
						'&itemsPerPage=' . $session->itemsPerPage .
						'&pageID='		. $session->pageID .
						'&encoding='	. $encoding .
						'&css='			. $css;
						
		$et_vars = array( 'vid', 'region', 'aid', 'date', 'highlight', 'eventtype', 'people', 'et_q', 'place',
					'person', 'ipm', 'cha', 'until', 'itemsPerPage', 'pageID', 'encoding', 'css', 'etID', 'Suche', 'action', session_name(), '_token', 'reset' );
		foreach( $_REQUEST as $key => $value ) {
			if( !in_array( $key, $et_vars ) ) {
				$querystring .= '&' . $key . '=' . $value;
			}
		} 
		
		$filename='veranstaltungen-php';
		if( $_REQUEST[ 'etID' ] != '' ) {
			$querystring .= '&ID=' . $_REQUEST[ 'etID' ];
			$filename = 'detail-php';
		}
		
		$host = 'www.evangelische-termine.de';
		$url = 'http://' . $host . '/'. $filename . '?' . $querystring;

		if( function_exists( 'curl_init' ) ) {
			$sobl = curl_init( $url );
			curl_setopt( $sobl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $sobl, CURLOPT_USERAGENT, 'Veranstalter-Script 2.0' );
			curl_setopt( $sobl, CURLOPT_REFERER, $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'PHP_SELF' ] );
			curl_setopt( $sobl, CURLOPT_CONNECTTIMEOUT, 2 );
			$pagecontent = curl_exec( $sobl );
			$sobl_info = curl_getinfo( $sobl );
			if( '200' == $sobl_info['http_code'] ){	
				$pagecontent = str_replace( '<div id="et_headline"><h1>Veranstaltungen</h1></div>', '', $pagecontent );
				$pagecontent = str_replace( '<h1>', '<h2>', $pagecontent );
				$pagecontent = str_replace( '</h1>', '</h2>', $pagecontent );
				$pagecontent = str_replace( '<h1 id="et_detail_title">', '<h2 id="et_detail_title">', $pagecontent );
				$pagecontent = str_replace( '/Upload/', 'http://' . $host . '/Upload/', $pagecontent );
				$pagecontent = str_replace( 'http://_HOST_/?', get_permalink( $post->ID ).'?'.$querystring.'&amp;', $pagecontent ); // 'https://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'PHP_SELF' ]
				$pagecontent = str_replace( '<link rel="stylesheet" type="text/css" href="http://www.evangelische-termine.de/bundles/vket/css/publicintegration.css"  />', '', $pagecontent); // Diese Stylesheets liefern im Veranstalter-Script 2.0 weitere CSS-Dateien, die allerdings nicht benötigt werden.
				$pagecontent = str_replace( '<link rel="stylesheet" type="text/css" href="http://www.evangelische-termine.de/bundles/vket/js/jquery/css/smoothness/jquery-ui-1.10.3.custom.min.css"  />', '', $pagecontent); // Diese Stylesheets liefern im Veranstalter-Script 2.0 weitere CSS-Dateien, die allerdings nicht benötigt werden.
				$pagecontent = str_replace( '<link rel="stylesheet" type="text/css" href="nocss"  />', '', $pagecontent); // Mit der Angabe nocss wird verhindert, dass das CSS der Evangelischen Termine geladen wird. Durch diese Zeile wird der Code aus dem HTML gelöscht.
				
				if( 'veranstaltungen-php' == $filename ) {
					$pagecontent = str_replace( '<script type="text/javascript" src="http://www.evangelische-termine.de/js/e19e663.js"></script>', '', $pagecontent);
/*
					$pagecontent = str_replace( '<script language="javascript" type="text/javascript">', '', $pagecontent);
					$pagecontent = str_replace( '$(function() {', '', $pagecontent);
					$pagecontent = str_replace( 'dateoptions[\'changeMonth\'] = true;', '', $pagecontent);
					$pagecontent = str_replace( 'dateoptions[\'changeYear\'] = true;', '', $pagecontent);
					$pagecontent = str_replace( 'dateoptions[\'showButtonPanel\'] = true;', '', $pagecontent);
					$pagecontent = str_replace( 'dateoptions[\'minDate\'] = -0;', '', $pagecontent);
					$pagecontent = str_replace( '$(\'#date\').datepicker(dateoptions);', '', $pagecontent);
					$pagecontent = str_replace( '});', '', $pagecontent);
					$pagecontent = str_replace( 'function ET_openWindow(etURL,windowName,features) { window.open(etURL,windowName,features);}', '', $pagecontent);
					$pagecontent = str_replace( '</script>', '', $pagecontent);
*/
				}
				if( 'detail-php' == $filename ) {
					$pagecontent = str_replace( '<script type="text/javascript" src="http://www.evangelische-termine.de/js/fa34c0d.js"></script><script language="javascript" type="text/javascript">', '', $pagecontent);
					$pagecontent = str_replace( '$(function() {', '', $pagecontent);
					$pagecontent = str_replace( '$(\'#et_place_image_th\').livequery(function(){', '', $pagecontent);
					$pagecontent = str_replace( '$(this)', '', $pagecontent);
					$pagecontent = str_replace( '.mouseover(function() {', '', $pagecontent);
					$pagecontent = str_replace( '$(this).hide();', '', $pagecontent);
					$pagecontent = str_replace( '$(\'#et_place_image\').slideDown();', '', $pagecontent);
					$pagecontent = str_replace( '});', '', $pagecontent); 
					$pagecontent = str_replace( '$(\'#et_place_image\').livequery(function(){', '', $pagecontent);
					$pagecontent = str_replace( '$(this)', '', $pagecontent); 
					$pagecontent = str_replace( '.mouseout(function() {', '', $pagecontent); 
					$pagecontent = str_replace( '$(this).slideUp();', '', $pagecontent);
					$pagecontent = str_replace( '$(\'#et_place_image_th\').show();', '', $pagecontent);
					$pagecontent = str_replace( 'function ET_openWindow(etURL,windowName,features) { window.open(etURL,windowName,features);}', '', $pagecontent);
					$pagecontent = str_replace( '</script>', '', $pagecontent);
					$pagecontent = str_replace( '.hide();', '', $pagecontent);
					$pagecontent = str_replace( '.slideUp();', '', $pagecontent);
				}
				$content = $pagecontent;
			} else {
				$content = 'Der Terminkalender ist derzeit nicht erreichbar!';
			}
			curl_close( $sobl );
		} else {
			$content = "Das Plugin benötigt das PHP-Modul curl.";
		}
	} else {
		$content = 'Veranstalter-ID ist nicht definiert. Einstellungen -> Evangelische Termine';
	}
	return $content;
}

function et_teaser( $et_defaults ) {
	// Parameter aus Shortcodes und Widget einlesen
	if( $et_defaults[ 'vid' ] ) {
		$encoding = get_option( 'encoding' ) ? get_option( 'encoding' ) : ET_DEFAULT_CHARSET;
/*
		if( get_option( 'css' ) ) {
			$css = get_option( 'css' );
		} else {
			$css = plugins_url( 'assets/css/evangtermine.css', EVANGTERMINE_PLUGIN_PATH . 'evangtermine' );
		}
*/
		$css = 'nocss';
		
		$querystring = '';
		foreach( $et_defaults as $key => $value ) {
			if( 'title' != $key ) {
				if( 'region' != $key ) {
					$querystring .= '&' . $key . '=' . $value;
				} else {
					$querystring .= '&'.'region' . '=' . $value;
				}
			}
		}
		$querystring .= '&encoding=' . $encoding . '&css=' . $css;
		$querystring = substr( $querystring, 1, strlen( $querystring) - 1 );  

		$url = 'http://www.evangelische-termine.de/teaser?' . $querystring;

		if( function_exists( 'curl_init' ) ) {
			$sobl = curl_init( $url );
			curl_setopt( $sobl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $sobl, CURLOPT_USERAGENT, 'TeaserScript' );
			curl_setopt( $sobl, CURLOPT_REFERER, $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] );
			curl_setopt( $sobl, CURLOPT_CONNECTTIMEOUT, 5 );
			$pagecontent = curl_exec( $sobl );
			$sobl_info = curl_getinfo( $sobl );
			if( '200' == $sobl_info['http_code'] ){
				$content = $pagecontent;
			} else {
				$content = 'Der Terminkalender ist derzeit nicht erreichbar!';
			}
			curl_close( $sobl );
		} else {
			$content = "Das Plugin benöt das PHP-Modul curl.";
		}
	} else {
		$content = 'Veranstalter-ID ist nicht definiert. Einstellungen -> Evangelische Termine';
	}
	return $content;
}
?>