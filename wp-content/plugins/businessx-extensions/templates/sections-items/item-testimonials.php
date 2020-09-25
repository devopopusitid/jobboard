<?php
/* ------------------------------------------------------------------------- *
 *  Testimonials Item
/* ------------------------------------------------------------------------- */

/**
 * All the options in an array, needed to create the widget output
 *
 * @since 1.0.4.3
 *
 * @var array $widget_options All the options needed to display this widget
 *     @param int    $widget_options['wid']         Widget ID
 *     @param string $widget_options['title']       Testimonial author
 *     @param string $widget_options['avatar']      Client avatar
 *     @param string $widget_options['testimonial'] Testimonial content
 *     @param string $widget_options['btn_text']    Button anchor text
 *     @param string $widget_options['btn_url']     Button link
 *     @param string $widget_options['target']      Button target
 */
$widget_options = apply_filters( 'bx_ext_item___testimonials_options', array(
	'wid'          => $wid,
	'title'        => $title,
	'avatar'       => $avatar,
	'testimonial'  => $testimonial,
	'btn_text'     => $btn_text,
	'btn_url'      => $btn_url,
	'target'       => $target,
) );

/**
 * @since 1.0.4.3
 *
 * Hooked:
 * bx_ext_item__testimonials_avatar   - 10
 * bx_ext_item__testimonials_contents - 20
 *
 * @see ../inc/partials/items/testimonials-item.php
 */
do_action( 'bx_ext_item__testimonials', $widget_options );
