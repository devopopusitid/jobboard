<?php
/**
 * Map Section
 */
add_action( 'bx_ext_part__map', 'bx_ext_part__map_wrap_start', 10 );
add_action( 'bx_ext_part__map', 'bx_ext_part__map_overlay',    20 );
add_action( 'bx_ext_part__map', 'bx_ext_part__map_output',     30 );
add_action( 'bx_ext_part__map', 'bx_ext_part__map_wrap_end',  999 );

add_action( 'bx_ext_part__map_overlay', 'bx_ext_part__map_overlay_start',   10 );
add_action( 'bx_ext_part__map_overlay', 'bx_ext_part__map_overlay_content', 20 );
add_action( 'bx_ext_part__map_overlay', 'bx_ext_part__map_overlay_end',    999 );

add_action( 'bx_ext_part__map_overlay_content', 'bx_ext_part__map_overlay_content_start', 10 );
add_action( 'bx_ext_part__map_overlay_content', 'bx_ext_part__map_overlay_content_title', 20 );
add_action( 'bx_ext_part__map_overlay_content', 'bx_ext_part__map_overlay_content_icon',  30 );
add_action( 'bx_ext_part__map_overlay_content', 'bx_ext_part__map_overlay_content_end',  999 );


/**
 * Contact Section
 */
add_action( 'bx_ext_part__contact', 'bx_ext_part__contact_wrap_start', 10 );
add_action( 'bx_ext_part__contact', 'bx_ext_part__contact_overlay',    20 );
add_action( 'bx_ext_part__contact', 'bx_ext_part__contact_container',  30 );
add_action( 'bx_ext_part__contact', 'bx_ext_part__contact_wrap_end',  999 );

add_action( 'bx_ext_part__contact_container', 'bx_ext_part__contact_container_start', 10 );
add_action( 'bx_ext_part__contact_container', 'bx_ext_part__contact_items',           20 );
add_action( 'bx_ext_part__contact_container', 'bx_ext_part__contact_container_end',  999 );

add_action( 'bx_ext_part__contact_items', 'bx_ext_part__contact_items_start',   10 );
add_action( 'bx_ext_part__contact_items', 'bx_ext_part__contact_items_display', 20 );
add_action( 'bx_ext_part__contact_items', 'bx_ext_part__contact_items_end',    999 );

add_action( 'bx_ext_part__contact_items_display', 'bx_ext_part__contact_info',   10 );
add_action( 'bx_ext_part__contact_items_display', 'bx_ext_part__contact_form', 20 );

add_action( 'bx_ext_part__contact_info', 'bx_ext_part__contact_info_start',   10 );
add_action( 'bx_ext_part__contact_info', 'bx_ext_part__contact_info_output',  20 );
add_action( 'bx_ext_part__contact_info', 'bx_ext_part__contact_info_end',    999 );

add_action( 'bx_ext_part__contact_info_output', 'bx_ext_part__contact_info_output_title', 10 );
add_action( 'bx_ext_part__contact_info_output', 'bx_ext_part__contact_info_output_desc',  20 );
add_action( 'bx_ext_part__contact_info_output', 'bx_ext_part__contact_info_output_btns',  30 );

add_action( 'bx_ext_part__contact_form', 'bx_ext_part__contact_form_start',   10 );
add_action( 'bx_ext_part__contact_form', 'bx_ext_part__contact_form_output',  20 );
add_action( 'bx_ext_part__contact_form', 'bx_ext_part__contact_form_end',    999 );


/**
 * Blog Section
 */
add_action( 'bx_ext_part__blog', 'bx_ext_part__blog_wrap_start', 10 );
add_action( 'bx_ext_part__blog', 'bx_ext_part__blog_overlay',    20 );
add_action( 'bx_ext_part__blog', 'bx_ext_part__blog_container',  30 );
add_action( 'bx_ext_part__blog', 'bx_ext_part__blog_wrap_end',  999 );

add_action( 'bx_ext_part__blog_container', 'bx_ext_part__blog_container_start', 10 );
add_action( 'bx_ext_part__blog_container', 'bx_ext_part__blog_items',           20 );
add_action( 'bx_ext_part__blog_container', 'bx_ext_part__blog_container_end',  999 );

add_action( 'bx_ext_part__blog_items', 'bx_ext_part__blog_items_header', 10 );
add_action( 'bx_ext_part__blog_items', 'bx_ext_part__blog_items_posts',  20 );

add_action( 'bx_ext_part__blog_items_header', 'bx_ext_part__blog_items_header_start',          10 );
add_action( 'bx_ext_part__blog_items_header', 'bx_ext_part__blog_items_header_title',          20 );
add_action( 'bx_ext_part__blog_items_header', 'bx_ext_part__blog_items_header_description',    30 );
add_action( 'bx_ext_part__blog_items_header', 'bx_ext_part__blog_items_header_end',           999 );

add_action( 'bx_ext_part__blog_items_posts', 'bx_ext_part__blog_items_posts_start',    10 );
add_action( 'bx_ext_part__blog_items_posts', 'bx_ext_part__blog_items_posts_sizers',   20 );
add_action( 'bx_ext_part__blog_items_posts', 'bx_ext_part__blog_items_posts_loop',     30 );
add_action( 'bx_ext_part__blog_items_posts', 'bx_ext_part__blog_items_posts_end',     999 );
add_action( 'bx_ext_part__blog_items_posts', 'bx_ext_part__blog_items_posts_js',     1010 );
add_action( 'bx_ext_part__blog_items_posts', 'bx_ext_part__blog_items_posts_action', 1020 );

add_action( 'bx_ext_part__blog_items_posts_loop_post', 'bx_ext_part__blog_items_posts_loop_post_start',   10 );
add_action( 'bx_ext_part__blog_items_posts_loop_post', 'bx_ext_part__blog_items_posts_loop_post_thumb',   20 );
add_action( 'bx_ext_part__blog_items_posts_loop_post', 'bx_ext_part__blog_items_posts_loop_post_title',   30 );
add_action( 'bx_ext_part__blog_items_posts_loop_post', 'bx_ext_part__blog_items_posts_loop_post_excerpt', 40 );
add_action( 'bx_ext_part__blog_items_posts_loop_post', 'bx_ext_part__blog_items_posts_loop_post_meta',    50 );
add_action( 'bx_ext_part__blog_items_posts_loop_post', 'bx_ext_part__blog_items_posts_loop_post_end',    999 );


/**
 * Team Section
 */
add_action( 'bx_ext_part__team', 'bx_ext_part__team_wrap_start', 10 );
add_action( 'bx_ext_part__team', 'bx_ext_part__team_overlay',    20 );
add_action( 'bx_ext_part__team', 'bx_ext_part__team_container',  30 );
add_action( 'bx_ext_part__team', 'bx_ext_part__team_wrap_end',  999 );

add_action( 'bx_ext_part__team_container', 'bx_ext_part__team_container_start', 10 );
add_action( 'bx_ext_part__team_container', 'bx_ext_part__team_items',           20 );
add_action( 'bx_ext_part__team_container', 'bx_ext_part__team_container_end',  999 );

add_action( 'bx_ext_part__team_items', 'bx_ext_part__team_items_header',  10 );
add_action( 'bx_ext_part__team_items', 'bx_ext_part__team_items_members', 20 );

add_action( 'bx_ext_part__team_items_header', 'bx_ext_part__team_items_header_start',          10 );
add_action( 'bx_ext_part__team_items_header', 'bx_ext_part__team_items_header_title',          20 );
add_action( 'bx_ext_part__team_items_header', 'bx_ext_part__team_items_header_description',    30 );
add_action( 'bx_ext_part__team_items_header', 'bx_ext_part__team_items_header_end',           999 );

add_action( 'bx_ext_part__team_items_members', 'bx_ext_part__team_items_members_start',     10 );
add_action( 'bx_ext_part__team_items_members', 'bx_ext_part__team_items_members_display',   20 );
add_action( 'bx_ext_part__team_items_members', 'bx_ext_part__team_items_members_end',      999 );


/**
 * Cliens Section
 */
add_action( 'bx_ext_part__clients', 'bx_ext_part__clients_wrap_start', 10 );
add_action( 'bx_ext_part__clients', 'bx_ext_part__clients_overlay',    20 );
add_action( 'bx_ext_part__clients', 'bx_ext_part__clients_container',  30 );
add_action( 'bx_ext_part__clients', 'bx_ext_part__clients_js',         40 );
add_action( 'bx_ext_part__clients', 'bx_ext_part__clients_wrap_end',  999 );

add_action( 'bx_ext_part__clients_container', 'bx_ext_part__clients_container_start', 10 );
add_action( 'bx_ext_part__clients_container', 'bx_ext_part__clients_items',           20 );
add_action( 'bx_ext_part__clients_container', 'bx_ext_part__clients_container_end',  999 );

add_action( 'bx_ext_part__clients_items', 'bx_ext_part__clients_items_header',  10 );
add_action( 'bx_ext_part__clients_items', 'bx_ext_part__clients_items_helper',  20 );
add_action( 'bx_ext_part__clients_items', 'bx_ext_part__clients_items_display', 30 );

add_action( 'bx_ext_part__clients_items_header', 'bx_ext_part__clients_items_header_start',          10 );
add_action( 'bx_ext_part__clients_items_header', 'bx_ext_part__clients_items_header_title',          20 );
add_action( 'bx_ext_part__clients_items_header', 'bx_ext_part__clients_items_header_description',    30 );
add_action( 'bx_ext_part__clients_items_header', 'bx_ext_part__clients_items_header_end',           999 );

add_action( 'bx_ext_part__clients_items_display', 'bx_ext_part__clients_items_display_start',     10 );
add_action( 'bx_ext_part__clients_items_display', 'bx_ext_part__clients_items_display_carousel',  20 );
add_action( 'bx_ext_part__clients_items_display', 'bx_ext_part__clients_items_display_arrows',    30 );
add_action( 'bx_ext_part__clients_items_display', 'bx_ext_part__clients_items_display_end',      999 );


/**
 * Portfolio Section
 */
add_action( 'bx_ext_part__portfolio', 'bx_ext_part__portfolio_wrap_start', 10 );
add_action( 'bx_ext_part__portfolio', 'bx_ext_part__portfolio_overlay',    20 );
add_action( 'bx_ext_part__portfolio', 'bx_ext_part__portfolio_container',  30 );
add_action( 'bx_ext_part__portfolio', 'bx_ext_part__portfolio_wrap_end',  999 );

add_action( 'bx_ext_part__portfolio_container', 'bx_ext_part__portfolio_container_start', 10 );
add_action( 'bx_ext_part__portfolio_container', 'bx_ext_part__portfolio_items',           20 );
add_action( 'bx_ext_part__portfolio_container', 'bx_ext_part__portfolio_container_end',  999 );

add_action( 'bx_ext_part__portfolio_items', 'bx_ext_part__portfolio_items_header',   10 );
add_action( 'bx_ext_part__portfolio_items', 'bx_ext_part__portfolio_items_projects', 20 );
add_action( 'bx_ext_part__portfolio_items', 'bx_ext_part__portfolio_items_action',   30 );
add_action( 'bx_ext_part__portfolio_items', 'bx_ext_part__portfolio_items_js',       40 );

add_action( 'bx_ext_part__portfolio_items_header', 'bx_ext_part__portfolio_items_header_start',          10 );
add_action( 'bx_ext_part__portfolio_items_header', 'bx_ext_part__portfolio_items_header_title',          20 );
add_action( 'bx_ext_part__portfolio_items_header', 'bx_ext_part__portfolio_items_header_description',    30 );
add_action( 'bx_ext_part__portfolio_items_header', 'bx_ext_part__portfolio_items_header_end',           999 );

add_action( 'bx_ext_part__portfolio_items_projects', 'bx_ext_part__portfolio_items_projects_start',     10 );
add_action( 'bx_ext_part__portfolio_items_projects', 'bx_ext_part__portfolio_items_projects_sizers',    20 );
add_action( 'bx_ext_part__portfolio_items_projects', 'bx_ext_part__portfolio_items_projects_display',   30 );
add_action( 'bx_ext_part__portfolio_items_projects', 'bx_ext_part__portfolio_items_projects_end',      999 );


/**
 * Testimonials Section
 */
add_action( 'bx_ext_part__testimonials', 'bx_ext_part__testimonials_wrap_start', 10 );
add_action( 'bx_ext_part__testimonials', 'bx_ext_part__testimonials_overlay',    20 );
add_action( 'bx_ext_part__testimonials', 'bx_ext_part__testimonials_container',  30 );
add_action( 'bx_ext_part__testimonials', 'bx_ext_part__testimonials_helper',     40 );
add_action( 'bx_ext_part__testimonials', 'bx_ext_part__testimonials_items',      50 );
add_action( 'bx_ext_part__testimonials', 'bx_ext_part__testimonials_nav',        60 );
add_action( 'bx_ext_part__testimonials', 'bx_ext_part__testimonials_js',         70 );
add_action( 'bx_ext_part__testimonials', 'bx_ext_part__testimonials_wrap_end',  999 );

add_action( 'bx_ext_part__testimonials_container', 'bx_ext_part__testimonials_container_start', 10 );
add_action( 'bx_ext_part__testimonials_container', 'bx_ext_part__testimonials_header',          20 );
add_action( 'bx_ext_part__testimonials_container', 'bx_ext_part__testimonials_container_end',  999 );

add_action( 'bx_ext_part__testimonials_header', 'bx_ext_part__testimonials_header_start',  10 );
add_action( 'bx_ext_part__testimonials_header', 'bx_ext_part__testimonials_header_title',  20 );
add_action( 'bx_ext_part__testimonials_header', 'bx_ext_part__testimonials_header_end',   999 );

add_action( 'bx_ext_part__testimonials_items', 'bx_ext_part__testimonials_items_start',    10 );
add_action( 'bx_ext_part__testimonials_items', 'bx_ext_part__testimonials_items_display',  20 );
add_action( 'bx_ext_part__testimonials_items', 'bx_ext_part__testimonials_items_end',     999 );

add_action( 'bx_ext_part__testimonials_nav', 'bx_ext_part__testimonials_nav_start',    10 );
add_action( 'bx_ext_part__testimonials_nav', 'bx_ext_part__testimonials_nav_prev',     20 );
add_action( 'bx_ext_part__testimonials_nav', 'bx_ext_part__testimonials_nav_next',     30 );
add_action( 'bx_ext_part__testimonials_nav', 'bx_ext_part__testimonials_nav_end',     999 );


/**
 * Hero Section
 */
add_action( 'bx_ext_part__hero', 'bx_ext_part__hero_wrap_start',   10 );
add_action( 'bx_ext_part__hero', 'bx_ext_part__hero_overlay',      20 );
add_action( 'bx_ext_part__hero', 'bx_ext_part__hero_wrap_end',    999 );

add_action( 'bx_ext_part__hero_overlay', 'bx_ext_part__hero_overlay_start',   10 );
add_action( 'bx_ext_part__hero_overlay', 'bx_ext_part__hero_elements',        20 );
add_action( 'bx_ext_part__hero_overlay', 'bx_ext_part__hero_overlay_end',    999 );

add_action( 'bx_ext_part__hero_elements', 'bx_ext_part__hero_elements_start',         10 );
add_action( 'bx_ext_part__hero_elements', 'bx_ext_part__hero_elements_title',         20 );
add_action( 'bx_ext_part__hero_elements', 'bx_ext_part__hero_elements_description',   30 );
add_action( 'bx_ext_part__hero_elements', 'bx_ext_part__hero_elements_buttons',       40 );
add_action( 'bx_ext_part__hero_elements', 'bx_ext_part__hero_elements_end',          999 );


/**
 * Slider Section
 */
add_action( 'bx_ext_part__slider', 'bx_ext_part__slider_wrap_start',   10 );
add_action( 'bx_ext_part__slider', 'bx_ext_part__slider_arrows',       20 );
add_action( 'bx_ext_part__slider', 'bx_ext_part__slider_items',        30 );
add_action( 'bx_ext_part__slider', 'bx_ext_part__slider_js',           40 );
add_action( 'bx_ext_part__slider', 'bx_ext_part__slider_wrap_end',    999 );

add_action( 'bx_ext_part__slider_items', 'bx_ext_part__slider_items_start',    10 );
add_action( 'bx_ext_part__slider_items', 'bx_ext_part__slider_items_display',  20 );
add_action( 'bx_ext_part__slider_items', 'bx_ext_part__slider_items_helper',   30 );
add_action( 'bx_ext_part__slider_items', 'bx_ext_part__slider_items_end',     999 );


/**
 * Actions Section
 */
add_action( 'bx_ext_part__actions', 'bx_ext_part__actions_display', 10 );
add_action( 'bx_ext_part__actions', 'bx_ext_part__actions_helper',  20 );


/**
 * About Section
 */
add_action( 'bx_ext_part__about', 'bx_ext_part__about_wrap_start', 10 );
add_action( 'bx_ext_part__about', 'bx_ext_part__about_overlay',    20 );
add_action( 'bx_ext_part__about', 'bx_ext_part__about_container',  30 );
add_action( 'bx_ext_part__about', 'bx_ext_part__about_wrap_end',  999 );

add_action( 'bx_ext_part__about_container', 'bx_ext_part__about_container_start',  10 );
add_action( 'bx_ext_part__about_container', 'bx_ext_part__about_header',           20 );
add_action( 'bx_ext_part__about_container', 'bx_ext_part__about_items',            30 );
add_action( 'bx_ext_part__about_container', 'bx_ext_part__about_button',           40 );
add_action( 'bx_ext_part__about_container', 'bx_ext_part__about_container_end',   999 );

add_action( 'bx_ext_part__about_header', 'bx_ext_part__about_header_start',        10 );
add_action( 'bx_ext_part__about_header', 'bx_ext_part__about_header_title',        20 );
add_action( 'bx_ext_part__about_header', 'bx_ext_part__about_header_description',  30 );
add_action( 'bx_ext_part__about_header', 'bx_ext_part__about_header_end',         999 );

add_action( 'bx_ext_part__about_items', 'bx_ext_part__about_items_start',    10 );
add_action( 'bx_ext_part__about_items', 'bx_ext_part__about_items_display',  20 );
add_action( 'bx_ext_part__about_items', 'bx_ext_part__about_items_helper',   30 );
add_action( 'bx_ext_part__about_items', 'bx_ext_part__about_items_end',     999 );


/**
 * FAQ Section
 */
add_action( 'bx_ext_part__faq', 'bx_ext_part__faq_wrap_start',  10 );
add_action( 'bx_ext_part__faq', 'bx_ext_part__faq_overlay',     20 );
add_action( 'bx_ext_part__faq', 'bx_ext_part__faq_container',   30 );
add_action( 'bx_ext_part__faq', 'bx_ext_part__faq_js',          40 );
add_action( 'bx_ext_part__faq', 'bx_ext_part__faq_wrap_end',   999 );

add_action( 'bx_ext_part__faq_container', 'bx_ext_part__faq_container_start',  10 );
add_action( 'bx_ext_part__faq_container', 'bx_ext_part__faq_header',           20 );
add_action( 'bx_ext_part__faq_container', 'bx_ext_part__faq_helper',           30 );
add_action( 'bx_ext_part__faq_container', 'bx_ext_part__faq_items',            40 );
add_action( 'bx_ext_part__faq_container', 'bx_ext_part__faq_container_end',   999 );

add_action( 'bx_ext_part__faq_header', 'bx_ext_part__faq_header_start',        10 );
add_action( 'bx_ext_part__faq_header', 'bx_ext_part__faq_header_title',        20 );
add_action( 'bx_ext_part__faq_header', 'bx_ext_part__faq_header_description',  30 );
add_action( 'bx_ext_part__faq_header', 'bx_ext_part__faq_header_end',         999 );

add_action( 'bx_ext_part__faq_items', 'bx_ext_part__faq_items_start',    10 );
add_action( 'bx_ext_part__faq_items', 'bx_ext_part__faq_items_sizer',    20 );
add_action( 'bx_ext_part__faq_items', 'bx_ext_part__faq_items_display',  30 );
add_action( 'bx_ext_part__faq_items', 'bx_ext_part__faq_items_end',     999 );


/**
 * Features Section
 */
add_action( 'bx_ext_part__features', 'bx_ext_part__features_wrap_start',  10 );
add_action( 'bx_ext_part__features', 'bx_ext_part__features_overlay',     20 );
add_action( 'bx_ext_part__features', 'bx_ext_part__features_container',   30 );
add_action( 'bx_ext_part__features', 'bx_ext_part__features_wrap_end',   999 );

add_action( 'bx_ext_part__features_container', 'bx_ext_part__features_container_start',  10 );
add_action( 'bx_ext_part__features_container', 'bx_ext_part__features_header',           20 );
add_action( 'bx_ext_part__features_container', 'bx_ext_part__features_items',            30 );
add_action( 'bx_ext_part__features_container', 'bx_ext_part__features_container_end',   999 );

add_action( 'bx_ext_part__features_header', 'bx_ext_part__features_header_start',        10 );
add_action( 'bx_ext_part__features_header', 'bx_ext_part__features_header_title',        20 );
add_action( 'bx_ext_part__features_header', 'bx_ext_part__features_header_description',  30 );
add_action( 'bx_ext_part__features_header', 'bx_ext_part__features_header_end',         999 );

add_action( 'bx_ext_part__features_items', 'bx_ext_part__features_items_start',    10 );
add_action( 'bx_ext_part__features_items', 'bx_ext_part__features_items_display',  20 );
add_action( 'bx_ext_part__features_items', 'bx_ext_part__features_helper',         30 );
add_action( 'bx_ext_part__features_items', 'bx_ext_part__features_items_end',     999 );


/**
 * Pricing Section
 */
add_action( 'bx_ext_part__pricing', 'bx_ext_part__pricing_wrap_start',  10 );
add_action( 'bx_ext_part__pricing', 'bx_ext_part__pricing_overlay',     20 );
add_action( 'bx_ext_part__pricing', 'bx_ext_part__pricing_container',   30 );
add_action( 'bx_ext_part__pricing', 'bx_ext_part__pricing_wrap_end',   999 );

add_action( 'bx_ext_part__pricing_container', 'bx_ext_part__pricing_container_start',  10 );
add_action( 'bx_ext_part__pricing_container', 'bx_ext_part__pricing_header',           20 );
add_action( 'bx_ext_part__pricing_container', 'bx_ext_part__pricing_items',            30 );
add_action( 'bx_ext_part__pricing_container', 'bx_ext_part__pricing_container_end',   999 );

add_action( 'bx_ext_part__pricing_header', 'bx_ext_part__pricing_header_start',        10 );
add_action( 'bx_ext_part__pricing_header', 'bx_ext_part__pricing_header_title',        20 );
add_action( 'bx_ext_part__pricing_header', 'bx_ext_part__pricing_header_description',  30 );
add_action( 'bx_ext_part__pricing_header', 'bx_ext_part__pricing_header_end',         999 );

add_action( 'bx_ext_part__pricing_items', 'bx_ext_part__pricing_items_start',    10 );
add_action( 'bx_ext_part__pricing_items', 'bx_ext_part__pricing_items_display',  20 );
add_action( 'bx_ext_part__pricing_items', 'bx_ext_part__pricing_helper',         30 );
add_action( 'bx_ext_part__pricing_items', 'bx_ext_part__pricing_items_end',     999 );
