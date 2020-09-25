<?php
/* ------------------------------------------------------------------------- *
 *  Pricing Item
/* ------------------------------------------------------------------------- */

/**
 * All the options in an array, needed to create the widget output
 *
 * @since 1.0.4.3
 *
 * @var array $widget_options All the options needed to display this widget
 *     @param int     $widget_options['wid']        Widget ID
 *     @param string  $widget_options['title']      Package title
 *     @param string  $widget_options['badge']      Package badge
 *     @param string  $widget_options['price']      Package price
 *     @param string  $widget_options['period']     Package period of time
 *     @param array   $widget_options['list']       A list of items included in the package
 *     @param boolean $widget_options['icos']       Show button
 *     @param string  $widget_options['btn_anchor'] Button text
 *     @param string  $widget_options['btn_url']    Button URL
 *     @param string  $widget_options['btn_target'] Button target
 */
$widget_options = apply_filters( 'bx_ext_item___pricing_options', array(
	'wid'        => $wid,
	'title'      => $title,
	'badge'      => $badge,
	'price'      => $price,
	'period'     => $period,
	'list'       => $list,
	'icos'       => $icos,
	'btn_anchor' => $btn_anchor,
	'btn_url'    => $btn_url,
	'btn_target' => $btn_target,
) );

/**
 * @since 1.0.4.3
 *
 * Hooked:
 * bx_ext_item__pricing_badge    - 10
 * bx_ext_item__pricing_info     - 20
 * bx_ext_item__pricing_contents - 30
 *
 * @see ../inc/partials/items/pricing-item.php
 */
do_action( 'bx_ext_item__pricing', $widget_options );
