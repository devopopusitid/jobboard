<?php
/* ------------------------------------------------------------------------- *
 *  Actions Item
/* ------------------------------------------------------------------------- */

/**
 * All the options in an array, needed to create the widget output
 *
 * @since 1.0.4.3
 *
 * @var array $widget_options All the options needed to display this widget
 *     @param int     $widget_options['wid']          Widget ID
 *     @param string  $widget_options['title']        About title
 *     @param string  $widget_options['excerpt']      About box text
 *     @param string  $widget_options['title_output'] Title output
 *     @param boolean $widget_options['allowed_html'] Allowed html tags for excerpt
 */
$widget_options = apply_filters( 'bx_ext_item___about_options', array(
	'wid'          => $wid,
	'title'        => $title,
	'excerpt'      => $excerpt,
	'title_output' => $title_output,
	'allowed_html' => $allowed_html
) );

/**
 * @since 1.0.4.3
 *
 * Hooked:
 * bx_ext_item__about_title   - 10
 * bx_ext_item__about_excerpt - 20
 *
 * @see ../inc/partials/items/about-item.php
 */
do_action( 'bx_ext_item__about', $widget_options );
