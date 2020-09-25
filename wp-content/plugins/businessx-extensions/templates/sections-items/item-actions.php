<?php
/* ------------------------------------------------------------------------- *
 *  About Section Item
/* ------------------------------------------------------------------------- */

/**
 * All the options in an array, needed to create the widget output
 *
 * @since 1.0.4.3
 *
 * @var array $widget_options All the options needed to display this widget
 *     @param int     $widget_options['wid']          Widget ID
 *     @param string  $widget_options['title']        Action title
 *     @param boolean $widget_options['overlay']      Show overlay
 *     @param string  $widget_options['opacity']      Overlay opacity
 *     @param string  $widget_options['image']        Image URL
 *     @param string  $widget_options['alignment']    Image alignment
 *     @param string  $widget_options['excerpt']      Action text
 *     @param array   $widget_options['allowed_html'] Allowed HTML for excerpt
 *     @param boolean $widget_options['show_btn_1']   Show button #1
 *     @param boolean $widget_options['show_btn_2']   Show button #2
 *     @param string  $widget_options['btn_1_title']  Button #1 anchor text
 *     @param string  $widget_options['btn_2_title']  Button #2 anchor text
 *     @param string  $widget_options['btn_1_url']    Button #1 url
 *     @param string  $widget_options['btn_2_url']    Button #2 url
 *     @param string  $widget_options['btn_1_target'] Button #1 link target
 *     @param string  $widget_options['btn_2_target'] Button #2 link target
 *     @param string  $widget_options['or']           Text between buttons
 */
$widget_options = apply_filters( 'bx_ext_item___actions_options', array(
	'wid'          => $wid,
	'title'        => $title,
	'overlay'      => $overlay,
	'opacity'      => $overlay_opacity,
	'image'        => $image,
	'alignment'    => $alignment,
	'excerpt'      => $excerpt,
	'allowed_html' => $allowed_html,
	'show_btn_1'   => $show_btn_1,
	'show_btn_2'   => $show_btn_2,
	'btn_1_title'  => $btn_1_title,
	'btn_2_title'  => $btn_2_title,
	'btn_1_url'    => $btn_1_url,
	'btn_2_url'    => $btn_2_url,
	'btn_1_target' => $btn_1_target,
	'btn_2_target' => $btn_2_target,
	'or'           => $or,
) );

/**
 * @since 1.0.4.3
 *
 * Hooked:
 * bx_ext_item__actions_overlay  - 10
 * bx_ext_item__actions_container - 20
 *
 * @see ../inc/partials/items/actions-item.php
 */
do_action( 'bx_ext_item__actions', $widget_options );
