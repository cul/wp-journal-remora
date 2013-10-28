<?php

function vox($utterance, $args = array('format' => "html")){

	switch($args['format']) {

		case 'html': 
		$before = '<pre>';
		$after = '</pre>';
		break;

		default:
		break;
	}

	$articulation = $before.var_export($utterance, 1).$after;

	echo $articulation;
	return $articulation;
}

function truncate_string($string, $args){
	$length = (is_int($args)) ? $args : (int) $args['length'];
	$collapse = (bool) $args['collapse'];
	$strip_tags = (bool) $args['strip_tags'];
	$no_escape = (bool) $args['no_escape'];

	// Truncate the excerpt to the proper length
	$words = explode(' ', $string);

	foreach($words as $word){
		static $i;
		$i++;
		if($i > $length) { $i = 0; break; }
		$truncated .= $word.' ';
	}

	if($collapse) $truncated = preg_replace('#[\n\r]#', " ", $truncated);
	if($strip_tags) $truncated = strip_tags($truncated);
	if($no_escape) $truncated = stripcslashes($truncated);

	return $truncated;
}