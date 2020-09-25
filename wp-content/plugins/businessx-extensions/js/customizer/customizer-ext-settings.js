/* Customizer Settings Manager */
( function( $, api ) {

	var api = wp.customize;

	/**
	 * Drag & Drop section title
	 *
	 * @since 1.0.4.3
	 * @type  {Object}
	 */
	api.sectionConstructor['dragdrop'] = api.Section.extend( {
		/**
		 * No events for this type of section
		 *
		 * @return {Void}
		 */
		attachEvents: function () {},

		/**
		 * Always make the section active.
		 *
		 * @return {Boolean}
		 */
		isContextuallyActive: function () {
			return true;
		}
	} );

	/**
	 * Add edit items button control
	 *
	 * @since 1.0.4.3
	 * @type  {Object}
	 */
	api.controlConstructor['add-edit-items'] = api.Control.extend( {
		/**
		 * When the control is ready, initialize it
		 *
		 * @return {Void}
		 */
		ready: function() {
			var control = this,
			    type    = control.id.replace( '-addedititems', '' );

			/**
			 * When the button is clicked focus the sidebar
			 *
			 * @todo check .bx-display-important in older version.
			 */
			control.container.on( 'click', '.bx-add-items', function( e ) {
				api.section( 'sidebar-widgets-section-' + type ).focus();
				e.preventDefault();
			});
		}
	});

	/**
	 * Tabs for color and background controls
	 *
	 * @since 1.0.4.3
	 * @type  {Object}
	 */
	api.controlConstructor['section-tabs'] = api.Control.extend( {
		/**
		 * When the control is ready, initialize it
		 *
		 * @return {Void}
		 */
		ready: function() {
			var control = this;
			control.tabsInit();
		},

		/**
		 * Hide or show tab items on click
		 *
		 * @return {Void}
		 */
		tabsInit: function() {
			var control = this,
			    items = api.section( control.section() );
			    bg = '_bg_', color = '_color_'

			control.container.on( 'click', '.bx-cz-tab-colors', function( e ) {
				control.tabsItemsDisplay( items, [ color, bg ] );
				e.preventDefault();
			});

			control.container.on( 'click', '.bx-cz-tab-background', function( e ) {
				control.tabsItemsDisplay( items, [ bg, color ] );
				e.preventDefault();
			});
		},

		/**
		 * Show or hide tab items based on type
		 *
		 * @param  {Object} items All the controls associated with this section
		 * @param  {Array}  types Control types, only background and color for now
		 * @return {Void}
		 */
		tabsItemsDisplay: function( items, types ) {
			_.each( items.controls(), function( item, i ) {
				/**
				 * Because item.activate() and item.deactivate() reset each time the previewer refreshes,
				 * we use some CSS to do our dirty work.
				 */
				if( item.id.indexOf( types[ 0 ] ) >= 0 ) {
					$( item.selector ).addClass( 'bx-show' ).removeClass( 'bx-hide' );
				}
				if( item.id.indexOf( types[ 1 ] ) >= 0 ) {
					$( item.selector ).addClass( 'bx-hide' ).removeClass( 'bx-show' );
				}
			}, items );
		}
	} );

	/**
	 * Assign/create a custom section for Front Page sections
	 *
	 * @since 1.0.4.3
	 * @type  {Object}
	 */
	api.sectionConstructor['front-page'] = api.Section.extend({
		/**
		 * When ready, initialize section
		 *
		 * @return {Void}
		 */
		ready: function() {
			var section = this,
			    panel   = api.panel( section.panel() );

			/**
			 * Show hide controls based on expanded/collapsed state
			 * of section
			 *
			 * @type {Event}
			 */
			section.expanded.bind( 'toggleSectionExpansion', function( e, c ) {
				/**
				 * e = expanded
				 * c = collapsed
				 */
				if( e || c ) {
					_.each( section.controls(), function( control, i ) {
						/**
						 * Because control.activate() and control.deactivate() reset each time the previewer refreshes,
						 * we use some CSS to do our dirty work.
						 */
						if( control.id.indexOf( '_bg_' ) >= 0 || control.id.indexOf( '_color_' ) >= 0 ) {
							$( control.selector ).addClass( 'bx-hide').removeClass( 'bx-show' );
						}
					}, section );

					section.changeHiddenOnExpand();
				}

				section.changeHiddenOnExpand( true );
			});
		},

		/**
		 * Disable the "Add items" button and add a hidden acction to
		 * the section container if the "Hide Section" checkbox is true.
		 * Also, remove the styles if it's false.
		 *
		 * @since  1.0.4.3
		 * @see    controlHideShowSection()
		 * @param  {Boolean} clicked Do this only if clicked checkbox, not on expanded section.
		 * @return {Void}
		 */
		changeHiddenOnExpand: function( clicked ) {
			var section    = this,
			    type       = section.id.replace( 'businessx_section__', '' ),
			    hideBtn    = api.control( type + '_section_hide' ),
			    hideState  = hideBtn.setting(),
			    elements   = [ section, type ],
			    clicked    = ( typeof clicked === 'undefined' ) ? false : clicked;

			if( clicked === false ) {
				if( hideState ) {
					section.controlHideShowSection( 'hide', elements );
				} else {
					section.controlHideShowSection( 'show', elements );
				}
			} else  {
				$( hideBtn.selector ).on( 'change', 'input[type=checkbox]', function( e ) {
					if( $( this ).is( ':checked' )  ) {
						section.controlHideShowSection( 'hide', elements );
					} else {
						section.controlHideShowSection( 'show', elements );
					}
				});
			}
		},

		/**
		 * Used in changeHiddenOnExpand() to change styles/state When
		 * the "Hide Section" is checked
		 *
		 * @since  1.0.4.3
		 * @see    changeHiddenOnExpand()
		 * @param  {String} state    Hide or show section
		 * @param  {Array}  elements An array of: current section object, section type.
		 * @return {Void}
		 */
		controlHideShowSection: function( state, elements ) {
			var addEditBtn = api.control( elements[1] + '-addedititems' ),
			    c = elements[0].container,
			    s = ( typeof addEditBtn !== 'undefined' ) ? $( addEditBtn.selector ).find( 'button' ) : $( '#not-found' ),
			    hiddenClss = 'bx-hidden-section';

			if( state === 'show' ) {
				c.removeClass( hiddenClss );
				s.attr( 'disabled', false );
			} else if( state === 'hide' ) {
				c.addClass( hiddenClss );
				s.attr( 'disabled', true );
			} else {
				return;
			}
		}
	});

	api.panel( 'businessx_panel__sections_items' );

	/**
	 * On document ready
	 *
	 * @since 1.0.4.3
	 */
	$( document ).ready( function( $ ) {

		/**
		 * Show the right sidebars & widgets if related
		 * to a front page section.
		 *
		 * @since  1.0.4.3
		 * @return {Void}
		 */
		var bxShowRightSidebars = function() {
			var panel         = api.panel( 'businessx_panel__sections_items' ),
			    sections      = panel.sections(),
			    searchWidgets = 'bx-search-change',
			    displayWidget = 'bx-display-block',
			    panelWidgets  = 'bx-display-widgets',
			    btnAttr       = 'data-bx-anw-new-title',
			    options       = bxext_widgets_customizer;

			_.each( sections, function( section ) {
				var type = section.id.replace( 'sidebar-widgets-section-', '' );

				/**
				 * Get back to the Front Page section instead of sidebar, when the
				 * back button is clicked.
				 */
				section.container.find( '.accordion-section-title, .customize-section-back' ).on( 'click keydown', function( e ) {
					if ( api.utils.isKeydownButNotEnterEvent( e ) ) {
						return;
					}
					e.preventDefault();

					if( api.panel( 'businessx_panel__sections' ).active() ) {
						api.section( 'businessx_section__' + type ).focus();
					} else {
						alert( options.msgs.wrong_page );
						api.section( 'title_tagline' ).focus();
					}
				});

				/**
				 * Display the right widgets and sidebar
				 */
				section.expanded.bind( 'toggleSidebarSectionExpansion', function( e, c ) {
					var widgetsFilter  = $( '#available-widgets-filter' ),
					    sectionWidgets = $( '#available-widgets-list' ),
					    widgetTmpl     = $( 'div[id*=widget-tpl-bx-item-' + type +'-]' ),
					    addWidget      = $( '.add-new-widget' );

					if( e ) {
						widgetsFilter.addClass( searchWidgets ).find( 'input' ).attr( 'disabled', true );
						sectionWidgets.addClass( panelWidgets );
						widgetTmpl.show().addClass( displayWidget );
						addWidget.attr( btnAttr, options.add_widget[ type ] );
					}
					if( c ) {
						widgetsFilter.removeClass( searchWidgets ).find( 'input' ).attr( 'disabled', false );
						sectionWidgets.removeClass( panelWidgets );
						widgetTmpl.hide().removeClass( displayWidget );
						addWidget.removeAttr( btnAttr );
					}
				});
			}, panel );
		}();

		/**
		 * Add some CSS classes/states to sections on the first time the "Front Page Sections"
		 * panel is expanded.
		 *
		 * @since  1.0.4.3
		 * @return {Void}
		 */
		var bxPanelExpandedOnce = function() {
			var expanded = 'notyet',
			    panel    = api.panel( 'businessx_panel__sections' );
			    sections = panel.sections();

			panel.expanded.bind( 'toggleFirstPanelExpansion', function( e, c ) {
				if( expanded === 'finished' ) return;

				if( e && expanded === 'notyet' ) { expanded = 'expanded' };

				if( expanded === 'expanded' ) {
					_.each( sections, function( section, i ) {
						var type = section.id.replace( 'businessx_section__', '' ),
						    hidden = 'bx-hidden-section';

						if( type !== 'dragdrop' ) {
							var control = api.control( type + '_section_hide' ),
							    state   = control.setting();

							if( state ) {
								section.container.addClass( hidden );
							} else {
								section.container.removeClass( hidden );
							}
						}
					});
				}

				expanded = 'finished';

			}, sections );
		}();
	});

	/**
	 * Live previewing colors and other settngs
	 *
	 * @since 1.0.0
	 * @type  {Mixed}
	 */
	var bx_ext_styles_template = wp.template( 'businessx-ext-czr-settings-output' ),
	    bx_ext_simple_settings = _.map( bx_ext_customizer_settings, function( element, index ) { return index } ),
	    bx_ext_settings_keys   = bx_ext_simple_settings,
	    bx_ext_settings_values = bx_ext_simple_settings;

	// Update function
	function bx_ext_update_css() {
		var new_settings,
		    settings = _.object( bx_ext_settings_keys, bx_ext_customizer_settings );

		_.each( bx_ext_settings_values, function( new_value ) {
			settings[ new_value ] = api( new_value )();
		} );

		new_settings = bx_ext_styles_template( settings );

		api.previewer.send( 'bx-ext-update-settings', new_settings );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( bx_ext_settings_values, function( new_value ) {
		api( new_value, function( new_value ) {
			new_value.bind( bx_ext_update_css );
		} );
	} );

} )( jQuery, wp.customize );
