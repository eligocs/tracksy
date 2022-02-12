<?php
/**
 * CodeIgniter helper for generate share url and buttons (Twitter, Facebook, Google Plus)
 *
 * @author Prem Thakur
 */

if( !function_exists('share_check') ){
	function share_check( $type='' ){
		$url = array(
			'twitter'	=> 'https://twitter.com/share',
			'facebook'	=> 'https://facebook.com/sharer.php',
			'google'	=> 'https://plus.google.com/share',
		);
		return (isset($url[$type])) ? $url[$type] : FALSE;
	}
}
if( !function_exists('share_url') ){
	function share_url( $type='', $args=array() ){
		$url = share_check( $type );
		if( $url === FALSE ){
			log_message( 'debug', 'Please check your type share_url('.$type.')' );
			return "#ERROR-check_share_url_type";
		}
		$params = array();
		if( $type == 'twitter' ){
			foreach( explode(' ', 'url via text related count lang counturl') as $v ){
				if( isset($args[$v]) ) $params[$v] = $args[$v];
			}
		}elseif( $type == 'facebook' ){
			$params['u']		= $args['url'];
			$params['t']		= $args['text'];
			$params['description']		= $args['description'];
			
		}elseif( $type == 'google'){
			$params['url']	= $args['url'];
		}
		$param = '';
		foreach( $params as $k=>$v ) $param .= '&'.$k.'='.urlencode($v);
		return $url.'?'.trim($param, '&');
	}
}
?>