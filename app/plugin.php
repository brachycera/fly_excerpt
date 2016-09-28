<?php
/**
 *
 * Textpattern CMS Plugin <www.textpattern.com>
 *
 * fly_excerpt.php
 * Flyweb Article Excerpt Plugin
 *
 * This Plugin provides the <txp:fly_excerpt /> Tag for the Textpattern Frontend. It will output the
 * Article-Excerpt words truncated to the given Attribute number.
 *
 * @author flyweb productions <www.flyweb.at>
 * @copyright 2015 flyweb productions
 * @license http://opensource.org/licenses/MIT - MIT License (MIT)
 * @version 1.02 <https://github.com/brachycera/fly_excerpt>
 *
 */

if (class_exists('\Textpattern\Tag\Registry')) {
    Txp::get('\Textpattern\Tag\Registry')
	->register('fly_excerpt');
}

/*
 *
 * fly_excerpt - Trim article excerpt to given words
 *
 * @param array $atts - num     $truncate - How many words should be truncated - Default: 10
 *                    	boolean $link - Show $more as HTML Link Values 0(no) or 1(yes) Default: 0
 *                     	string  $more - String to show User there is more content. Default: ...
 *                      string  $class - Optional HTML Class Name for $more Link
 * @return string $excerpt
 *
 */
function fly_excerpt($atts){

	global $thisarticle;

	extract(
		lAtts(
			array(
				'truncate' => '',
				'class'      => '',
				'more'       => '',
				'link'       => ''
	      	),
	      	$atts
		)
	);


	( empty($truncate) ? $truncate = 10 : $truncate );

	( empty($class) ? $class : $class = ' class="' . $class . '"' );

	( empty($more) ? $more = '...' : $more );

    ( ($link) ? $more = href( $more, permlinkurl($thisarticle), $class) : $more );

	$excerpt = strip_tags( $thisarticle['excerpt'] );

	$matches = preg_split( "/\s+/", $excerpt, $truncate + 1 );

	$words = count( $matches );

	if ( $words > $truncate ) {

		unset( $matches[$words - 1] );

		return implode(' ', $matches) . ' ' . $more;

	}

	return $excerpt;

}
?>