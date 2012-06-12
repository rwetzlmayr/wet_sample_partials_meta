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
	// Override the categories dropdown
	$partials['wet_category_1'] = array('mode' => PARTIAL_VOLATILE, 'selector' => '#category-1');
	$partials['wet_category_2'] = array('mode' => PARTIAL_VOLATILE, 'selector' => '#category-2');
}

/**
 * Fiddle with the article's category selects
 */
function article_partial_wet_category_1($rs) {
	static $cats = null;
	if ($cats == null) {
		$cats = getTree('root', 'article');
	}
	// Make radio buttons, not drop-downs
	$out = array();
	if ($cats) {
		foreach ($cats as $c) {
			$c = doSpecial($c);
			$id = 'wet_cat-'.$c['name'];
			$out[] = radio('Category1', $c['name'], $rs['Category1'] == $c['name'] ? '1' : '', 'cat-'.$c['name'] ).
				"<label for='$id'>{$c['title']}</label>";
		}
	}
	return '<ul class="plain-list"><li>'.join('</li><li>', $out).'</li></ul>';
}

function article_partial_wet_category_2($rs) {
	// Render the same markup as core and make some noise about it.
	return category_popup('Category2', $rs['Category2'], 'category-2').script_js('alert("Woot!")');
}

if (txpinterface == 'admin') new wet_sample_partials_meta;
