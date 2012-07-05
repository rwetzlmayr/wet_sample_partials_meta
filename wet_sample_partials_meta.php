<?php
class wet_sample_partials_meta
{
	function __construct()
	{
		register_callback(__CLASS__.'_fix', 'article_ui', 'partials_meta');
	}

	function category_2($rs) {
		// Render the same markup as core and make some noise about it.
		return category_popup('Category2', $rs['Category2'], 'category-2').script_js('alert("Woot!")');
	}

	function title($rs) {
		if (mb_strlen($rs['Title']) > 5) {
			return mb_substr($rs['Title'], 0, 5).'&hellip;';
		}
	}
}

/**
 * Fiddle with the article tab's partials meta record
 */
function wet_sample_partials_meta_fix($event, $step, &$rs, &$partials)
{
	// #1 Create own new partial (hash syntax)
	// Override the categories dropdown
	$partials['wet_category_1']['mode'] = PARTIAL_VOLATILE;
	$partials['wet_category_1']['selector'] = '#category-1';
	$partials['wet_category_1']['cb'] = 'wet_article_partial_category_1';

	// Create own new partial (array syntax)
	$partials['wet_category_2'] = array('mode' => PARTIAL_VOLATILE, 'selector' => '#category-2', 'cb' => array('wet_sample_partials_meta', 'category_2'));

	// Modify existing core partial by specifying an own callback
	$partials['title_value']['cb'] = array('wet_sample_partials_meta', 'title');
}

/**
 * Fiddle with the article's category selects
 */
function wet_article_partial_category_1($rs) {
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

if (txpinterface == 'admin') new wet_sample_partials_meta;
