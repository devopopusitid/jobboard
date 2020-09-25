<?php
/* ------------------------------------------------------------------------- *
 *  Features Item
/* ------------------------------------------------------------------------- */

/**
 * All the options in an array, needed to create the widget output
 *
 * @since 1.0.4.3
 *
 * @var array $widget_options All the options needed to display this widget
 *     @param int     $widget_options['wid']          Widget ID
 *     @param string  $widget_options['title']        Action title
 *     @param string  $widget_options['title_output'] Action title output
 *     @param string  $widget_options['excerpt']      Item text
 *     @param array   $widget_options['allowed_html'] Allowed HTML tags in item text
 *     @param boolean $widget_options['show_figure']  Show item image or icon
 *     @param string  $widget_options['figure_type']  Image or icon
 *     @param string  $widget_options['figure_icon']  Selected icon
 *     @param string  $widget_options['figure_image'] Selected image - URL
 *     @param string  $widget_options['btn_anchor']   Anchor text
 *     @param string  $widget_options['btn_target']   Button target
 *     @param string  $widget_options['btn_url']      Button URL
 */
$widget_options = apply_filters( 'bx_ext_item___features_options', array(
	'wid'          => $wid,
	'title'        => $title,
	'title_output' => $title_output,
	'excerpt'      => $excerpt,
	'allowed_html' => $allowed_html,
	'show_figure'  => $show_figure,
	'figure_type'  => $figure_type,
	'figure_icon'  => $figure_icon,
	'figure_image' => $figure_image,
	'btn_anchor'   => $btn_anchor,
	'btn_target'   => $btn_target,
	'btn_url'      => $btn_url,
) );

/**
 * @since 1.0.4.3
 *
 * Hooked:
 * bx_ext_item__features_figure   - 10
 * bx_ext_item__features_contents - 20
 *
 * @see ../inc/partials/items/features-item.php
 */
do_action( 'bx_ext_item__features', $widget_options );
