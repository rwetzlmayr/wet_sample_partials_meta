<?php
class wet_sample_partials_meta
{
	function __construct()
	{
		register_callback(__CLASS__.'_fix', 'article_ui', 'partials_meta');
	}
}

/**
 * Fiddle with the article tab's partials meta record
 */
function wet_sample_partials_meta_fix($event, $step, &$rs, &$partials)
{
	$partials['title'] = array ('html' => PARTIAL_VOLATILE, 'selector' => 'p.title');
}

if (txpinterface == 'admin') new wet_sample_partials_meta;
