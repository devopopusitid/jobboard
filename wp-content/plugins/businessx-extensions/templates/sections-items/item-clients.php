<?php
/* ------------------------------------------------------------------------- *
 *  Clients Item
/* ------------------------------------------------------------------------- */

/**
 * All the options in an array, needed to create the widget output
 *
 * @since 1.0.4.3
 *
 * @var array $widget_options All the options needed to display this widget
 *     @param int     $widget_options['wid']    Widget ID
 *     @param string  $widget_options['title']  Client title
 *     @param string  $widget_options['logo']   Uploaded client logo
 *     @param string  $widget_options['url']    A link to the client's website, as a wrapper for the logo
 *     @param boolean $widget_options['target'] Open the link in a new window, true or false
 */
$widget_options = apply_filters( 'bx_ext_item___clients_options', array(
	'wid'    => $wid,
	'title'  => $title,
	'logo'   => $logo,
	'url'    => $url,
	'target' => $target
) );

/**
 * @since 1.0.4.3
 *
 * Hooked:
 * bx_ext_item__client   - 10
 *
 * @see ../inc/partials/items/clients-item.php
 */
do_action( 'bx_ext_item__clients', $widget_options );
