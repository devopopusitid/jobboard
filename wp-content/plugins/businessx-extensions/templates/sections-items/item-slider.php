<?php
/* ------------------------------------------------------------------------- *
 *  Slider Item
/* ------------------------------------------------------------------------- */

/**
 * All the options in an array, needed to create the widget output
 *
 * @since 1.0.4.3
 *
 * @var array $widget_options All the options needed to display this widget
 *     @param int     $widget_options['wid']          Widget ID
 *     @param string  $widget_options['title']        Slide heading
 *     @param string  $widget_options['overlay']      Overlay
 *     @param string  $widget_options['paragraph']    Slide paragraph
 *     @param boolean $widget_options['btn_show']     Show buttons
 *     @param string  $widget_options['btn_type']     Button type
 *     @param string  $widget_options['btn_between']  Between buttons text
 *     @param string  $widget_options['btn_1_text']   Button #1 text
 *     @param string  $widget_options['btn_1_url']    Button #1 URL
 *     @param string  $widget_options['btn_1_target'] Button #1 target
 *     @param string  $widget_options['btn_2_text']   Button #2 text
 *     @param string  $widget_options['btn_2_url']    Button #2 URL
 *     @param string  $widget_options['btn_2_target'] Button #2 target
 */
$widget_options = apply_filters( 'bx_ext_item___slider_options', array(
	'wid'          => $wid,
	'title'        => $title,
	'overlay'      => $overlay,
	'paragraph'    => $paragraph,
	'btn_show'     => $btn_show,
	'btn_type'     => $btn_type,
	'btn_between'  => $btn_between,
	'btn_1_text'   => $btn_1_text,
	'btn_1_url'    => $btn_1_url,
	'btn_1_target' => $btn_1_target,
	'btn_2_text'   => $btn_2_text,
	'btn_2_url'    => $btn_2_url,
	'btn_2_target' => $btn_2_target,
) );

/**
 * @since 1.0.4.3
 *
 * Hooked:
 * bx_ext_item__slider_overlay - 10
 *
 * @see ../inc/partials/items/slider-item.php
 */
do_action( 'bx_ext_item__slider', $widget_options );
