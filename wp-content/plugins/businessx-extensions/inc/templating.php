<?php
/* ------------------------------------------------------------------------- *
 *  Handle the templating system
/* ------------------------------------------------------------------------- */



/*
	Display sections in our theme via an action
	businessx_frontpage_sections();
*/
if( ! function_exists( 'businessx_extensions_display_sections' ) ) {
	function businessx_extensions_display_sections() {
		$names = get_theme_mod( 'businessx_sections_position' );

		if( $names === false ) return; // @since 1.0.6
		
		if( ! is_array( $names ) ) {
			$names = json_decode( $names ); // @since 1.0.6
		}

		if( ! empty( $names ) ) {

			foreach( (array) $names as $key => $name ) {
				$new_name = str_replace( 'businessx_section__', '', $name );
				businessx_extensions_get_template_part( 'sections/section', $new_name );
			}

		}
	}
}
add_action( 'businessx_frontpage_sections', 'businessx_extensions_display_sections' );



/*
	Returns the path to the plugin templates directory
*/
if( ! function_exists( 'businessx_extensions_get_templates_dir' ) ) {
	function businessx_extensions_get_templates_dir() {
		return BUSINESSX_EXTS_PATH . 'templates';
	}
}



/*
	Returns the URL to the plugin templates directory
*/
if( ! function_exists( 'businessx_extensions_get_templates_url' ) ) {
	function businessx_extensions_get_templates_url() {
		return BUSINESSX_EXTS_URL . 'templates';
	}
}



/*
	Retrieves a template part
*/
if( ! function_exists( 'businessx_extensions_get_template_part' ) ) {
	function businessx_extensions_get_template_part( $slug, $name = null, $load = true ) {
		// Execute code for this part
		do_action( 'get_template_part_' . $slug, $slug, $name );

		// Setup possible parts
		$templates = array();
		if ( isset( $name ) )
			$templates[] = $slug . '-' . $name . '.php';
		$templates[] = $slug . '.php';

		// Allow template parts to be filtered
		$templates = apply_filters( 'businessx_extensions___get_template_part', $templates, $slug, $name );

		// Return the part that is found
		return businessx_extensions_locate_template( $templates, $load, false );
	}
}



/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
 * inherit from a parent theme can just overload one file. If the template is
 * not found in either of those, it looks in the theme-compat folder last.
 *
 * Taken from bbPress
*/
if( ! function_exists( 'businessx_extensions_locate_template' ) ) {
	function businessx_extensions_locate_template( $template_names, $load = false, $require_once = true ) {
		// No file found yet
		$located = false;

		// Try to find a template file
		foreach ( (array) $template_names as $template_name ) {

			// Continue if template is empty
			if ( empty( $template_name ) )
				continue;

			// Trim off any slashes from the template name
			$template_name = ltrim( $template_name, '/' );

			// try locating this template file by looping through the template paths
			foreach( businessx_extensions_get_theme_template_paths() as $template_path ) {

				if( file_exists( $template_path . $template_name ) ) {
					$located = $template_path . $template_name;
					break;
				}
			}

			if( $located ) {
				break;
			}
		}

		if ( ( true == $load ) && ! empty( $located ) )
			load_template( $located, $require_once );

		return $located;
	}
}



/*
	Returns a list of paths to check for template locations
*/
if( ! function_exists( 'businessx_extensions_get_theme_template_paths' ) ) {
	function businessx_extensions_get_theme_template_paths() {

		$template_dir = businessx_extensions_get_theme_template_dir_name();

		$file_paths = array(
			1 => trailingslashit( get_stylesheet_directory() ) . $template_dir,
			10 => trailingslashit( get_template_directory() ) . $template_dir,
			100 => businessx_extensions_get_templates_dir()
		);

		$file_paths = apply_filters( 'businessx_extensions___template_paths', $file_paths );

		// sort the file paths based on priority
		ksort( $file_paths, SORT_NUMERIC );

		return array_map( 'trailingslashit', $file_paths );
	}
}



/*
	Returns the template directory name.
	Themes can filter this by using the businessx_extensions___templates_dir filter.
*/
if( ! function_exists( 'businessx_extensions_get_theme_template_dir_name' ) ) {
	function businessx_extensions_get_theme_template_dir_name() {
		return trailingslashit( apply_filters( 'businessx_extensions___templates_dir', 'businessx_templates' ) );
	}
}
