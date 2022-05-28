<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('strtotitle')) {
	function strtotitle($str = '') {
		$smallwordsarray = array( 'of','a','the','and','an','or','nor','but','is','if','then','else','when', 'at','from','by','on','off', 'for','in','out','over','to','into','with','upon' );
		
		$words = explode(' ', $str);

		foreach ($words as $key => $word) { 
			if ($key == 0 or !in_array($word, $smallwordsarray)){ 
				$words[$key] = ucwords($word); 
			}
		}
		
		$result = implode(' ', $words);
		
		return $result;
	}
}