<?php
/* ------------------------------------------------------------------------- *
 *  ______
 *
 *  Actions
 *  ________________
 *
 *	Panel, settings and controls options
 *	_____________________________
 *
 *	All the "businessx_controller_*" are located in the theme:
 *	../acosmin/customizer/customizer.php
 *
 *	They use $wp_customize->add_setting and $wp_customize->add_control to
 *	add settings and controls, all sanitized.
 *
/* ------------------------------------------------------------------------- */



	/*  Add section
	/* ------------------------------------ */
	$wp_customize->add_section( new BXEXT_Section_FrontPage( $wp_customize, 'businessx_section__actions', array(
		'title'				=> esc_html__( 'Actions Section', 'businessx-extensions' ),
		'panel'				=> 'businessx_panel__sections',
		'priority'			=> absint( businessx_extensions_sec_prio( 'businessx_section__actions' ) ),
	) ) );



		/*  Actions Section options
		/* ------------------------------------ */
		$wp_customize->add_setting( 'actions-addedititems', array() );

		$wp_customize->add_control( new BXEXT_Control_AddEditItems( $wp_customize, 'actions-addedititems', array(
			'section'      => 'businessx_section__actions',
			'type'         => 'add-edit-items',
			'section_type' => 'actions',
			'item_type'    => __( 'Add or edit actions', 'businessx-extensions' )
		) ) );

		// Hide section
		businessx_controller_checkbox(
			'actions_section_hide',
			'businessx_section__actions',
			esc_html__( 'Hide this section', 'businessx-extensions' ) );
		/*=====*/
