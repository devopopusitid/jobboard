<?php
/* ------------------------------------------------------------------------- *
 *  FAQ Item
/* ------------------------------------------------------------------------- */

/**
 * All the options in an array, needed to create the widget output
 *
 * @since 1.0.4.3
 *
 * @var array $widget_options All the options needed to display this widget
 *     @param int    $widget_options['wid']          Widget ID
 *     @param string $widget_options['title']        Question title
 *     @param string $widget_options['excerpt']      Question answer
 *     @param string $widget_options['title_output'] Question title output
 *     @param array  $widget_options['allowed_html'] Allowed html tags for excerpt
 */
$widget_options = apply_filters( 'bx_ext_item___faq_options', array(
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
 * bx_ext_item__faq_title   - 10
 * bx_ext_item__faq_excerpt - 20
 *
 * @see ../inc/partials/items/faq-item.php
 */
do_action( 'bx_ext_item__faq', $widget_options );
