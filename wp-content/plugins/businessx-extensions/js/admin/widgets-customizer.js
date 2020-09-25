/**
 * Customizer and Widgets page JS
 */

var $ = window.jQuery;

window.BxExtWidgets = {
	/**
	 * Initiazlie
	 *
	 * @since 1.0.4.3
	 * @return {Void}
	 */
	init : function() {
		var self = this;

		self.hideSidebars();
		self.events();
	},

	/**
	 * Repeater model
	 *
	 * @augments Backbone.Model
	 * @return   {Backbone} Backbone model
	 */
	repeaterModel : function() {
		var self = this;

		return Backbone.Model.extend({
			/**
			 * Initialize model
			 *
			 * @return {Function}
			 */
			initialize : function() {
				var widget   = this.get( 'widget' ),
				    fullId   = widget.id,
				    idNumber = widget.number,
				    base     = widget.base,
				    element  = widget.elem,
				    random   = self.randomID();

				this.set( 'key', random );
				this.set( 'name', 'widget-' + base + '[' + idNumber + '][' + element + ']');
				this.set( 'wid', 'widget-' + fullId + '-' + element );
				this.set( 'id', random );
			}
		});
	},

	/**
	 * Repeater view
	 *
	 * @augments Backbone.View
	 * @return   {Backbone} Backbone view
	 */
	repeaterView : function() {
		var self = this;

		return Backbone.View.extend({
			/**
			 * Setting up this view with our own wrapper tag
			 *
			 * @type {String}
			 */
			tagName : 'li',

			/**
			 * Initialize Backbone view
			 *
			 * @return {Function}
			 */
			initialize : function() {
				var widget = this.model.get( 'widget' ).object;

				this.displayElement( widget );
				this.actualize( widget );
			},

			/**
			 * Render template for this view
			 *
			 * @return {Function}
			 */
			render : function() {
				var tmpl = this.template( this.model.toJSON() );
				this.$el.html( tmpl );

				return this;
			},

			/**
			 * Display the created element
			 *
			 * @param  {Object} widget Widget selector
			 * @return {HTML}          Rendere element HTML
			 */
			displayElement : function( widget ) {
				widget.find( '.bx-widget-repeatable-items' ).append( this.render().el );
			},

			/**
			 * Actualize the widget based on events
			 * @param  {Object} widget Widget selector
			 * @return {Mixed}
			 */
			actualize : function( widget ) {
				var changeEvents = [
					'bx-widget-repeatable-el-added',
				];

				_.each( changeEvents, function( changeEvent ) {
					this.listenTo( this, changeEvent, function( e ) {
						widget.find( '.bx-widget-repeatable-change' ).trigger( 'change' );
					});
				}, this );
			}
		});
	},

	/**
	 * Make repeatable fields sortable
	 *
	 * @param  {String} widget Widget ID
	 * @return {jQuery.sortable}
	 */
	repeaterSortable : function( widget ) {
		var sel   = $( widget ),
		    items = sel.find( '.bx-widget-repeatable-items' );

		if( items.length === 0 ) return;

		/**
		 * Initialize jQuery UI Sortable module on our current elements
		 */
		items.sortable({

			// Sortable options
			helper : 'clone',
			items  : '> li',
			cursor : 'move',
			axis   : 'y',

			/**
			 * Trigger change if the sortable elment is in the right place
			 * at the end of sortable process. Also, make the "Apply" button
			 * trigger if it appears.
			 *
			 * @param  {Event}    event This sortable event, on stop
			 * @param  {Object}   ui    Current UI sortable object
			 * @return {Function}
			 */
			stop : function( event, ui ) {
				var widgetObj = ui.item.parents('.widget'),
				    saveBtn   = widgetObj.find('.widget-control-save');

				// Trigger change
				widgetObj.find( '.bx-widget-repeatable-change' ).trigger( 'change' );

				// Make "Apply" button disappear
				if( typeof saveBtn !== 'undefined' ) {
					saveBtn.click();
				}
			}

		});
	},

	/**
	 * Random id for repeater element
	 *
	 * @return {String} A random 6 letters/digits id, starting with a letter.
	 */
	randomID : function() {
		var retId,
		    alphabet     = "abcdefghijklmnopqrstuvwxyz";
		    randomLetter = alphabet[ Math.floor( Math.random() * alphabet.length ) ];
		    uniqidSeed   = Math.floor( Math.random() * 0x75bcd15 );

		var formatSeed = function( seed, reqWidth ) {
			seed = parseInt( seed, 10 ).toString( 16 );
			if ( reqWidth < seed.length ) {
				return seed.slice( seed.length - reqWidth );
			}
			if ( reqWidth > seed.length ) {
				return Array( 1 + ( reqWidth - seed.length ) )
					.join( '0' ) + seed;
			}
			return seed;
		};

		uniqidSeed++;

		retId = formatSeed( parseInt( new Date().getTime() / 1000, 10 ), 3 );
		retId += formatSeed( uniqidSeed, 2 );
		retId = randomLetter + retId;

		return retId;
	},

	/**
	 * Hide our section widgets and sidebars if we are on
	 * the Widgets page in the Administrator panel
	 *
	 * @return {Void}
	 */
	hideSidebars : function() {
		// Hide sidebars on the right page
		if( ! $( 'body' ).hasClass( 'widgets-php' ) ) return;

		// Hide the section sidebars
		$( 'div[id*=section-]' ).each( function( i, s ) {
			$( s ).parent( '.widgets-holder-wrap' ).hide();
		});

		/**
		 * Show the right sidebars to select from when a widget
		 * title is clicked
		 */
		$( '#available-widgets .widget .widget-top' ).on( 'click', function( e ) {
			var list = $( '.widgets-chooser > ul > li' ),
			    current = $( this ).parent( '.widget' ).find( list );

			current.each( function( i, element ) {
				var elm = $( element );
				if( elm.text().indexOf( 'Section' ) >= 0 ) { elm.remove(); }
			});

			var newlist = list;
			newlist.first().addClass( 'widgets-chooser-selected' );
		});

		// Remove our section widgets from the available widgets list.
		$( '#available-widgets .widget' ).each( function( i, w ) {
			var widget = $( w );
			    thisID = widget.attr( 'id' );

			if( thisID.indexOf( 'bx-item' ) >= 0 ) widget.remove();
		});
	},

	/**
	 * Tabs toggle
	 *
	 * @see    events()
	 * @param  {Object} selector Currently clicked item
	 * @return {Void}
	 */
	tabsInit : function( selector ) {
		var sel        = $( selector ),
		    widgetID   = sel.parents( '.widget' ).attr( 'id' ),
		    tabWrap    = sel.parents( 'div.bx-widget-tabs' ),
		    active     = tabWrap.find( '.bx-wt-active-link' ).length,
		    notActive  = 'bx-tab-not-active',
		    activeTab  = 'bx-wt-active-tab',
		    activeLink = 'bx-wt-active-link',
		    contents   = 'div.bx-wt-tab-contents',
		    toggle     = 'a.bx-wt-tab-toggle',
		    next       = 'div';


		tabWrap.find( toggle ).addClass( notActive );
		tabWrap.find( contents ).addClass( notActive );

		sel.removeClass( notActive );
		sel.next( next ).removeClass( notActive );

		if( active >= 1 ) {
			var notActiveClass = '.' + notActive;
			tabWrap.find( toggle + notActiveClass ).removeClass( activeLink );
			tabWrap.find( contents + notActiveClass ).removeClass( activeTab );
		}

		sel.toggleClass( activeLink );
		sel.next( next ).toggleClass( activeTab );
	},

	/**
	 * Select media type toggle
	 *
	 * @see    events()
	 * @param  {String} selector The current selector class name
	 * @return {Void}
	 */
	showOnSelect : function( selector ) {
		var sel      = $( selector ),
		    widget   = sel.parents( '.widget' ),
		    select   = widget.find( '[class*=' + sel.data( 'bx-select-class' ) + ']' ),
		    elements = $.makeArray( select ),
		    selected = sel.val();

		$.each( elements, function( i, element ) {
			if( element.className == selected ) {
				select.hide();
				widget.find( '.' + selected ).show();
			}
		});
	},

	/**
	 * Upload/Remove media button for widget
	 *
	 * @see    events()
	 * @param  {String}  selector       The current selector class name
	 * @param  {Boolean} [remove=false] If this is used to remove media, set to true if so
	 * @return {Void}
	 */
	mediaUpload : function( selector, remove ) {
		var sel       = $( selector ).closest( 'div' ),
		    upload    = wp.media({ multiple: false }),
		    img       = sel.find('.bx-iu-image'),
		    imgURL    = sel.find('.bx-iu-image-url'),
		    imgRemove = sel.find('.bx-iu-image-remove'),
		    imgUpload = sel.find('.bx-iu-image-upload'),
		    remove    = ( typeof remove === 'undefined' ) ? false : remove;

		if( remove === false ) {
			upload.on( 'select', function( ev ) {
				var attachment = upload.state().get( 'selection' ).first(),
				    sizes      = attachment.get( 'sizes' ),
				    thumbnail  = 'post-thumbnail',
				    size, full_size;

				if ( sizes ) {
					size      = sizes[ thumbnail ] || sizes.medium;
					full_size = sizes[ thumbnail ] || sizes.full;
				}

				size      = size || attachment.toJSON();
				full_size = full_size || attachment.toJSON();

				img.attr( 'src', size.url ).css( 'display', 'block' );
				imgURL.val( full_size.url ).trigger( 'change' );
				imgUpload.css( 'display', 'none' );
				imgRemove.css( 'display', 'inline-block' );
			})
			.open();
		} else {
			img.removeAttr( 'src' ).css( 'display', 'none' );
			imgURL.val( '' ).trigger( 'change' );
			imgRemove.css( 'display', 'none' );
			imgUpload.css( 'display', 'inline-block' );
		}
	},

	/**
	 * Initialise widget
	 *
	 * @see    events()
	 * @param  {Object} widget Widget instance
	 * @return {Void}
	 */
	widgetInit : function( widget ) {
		var self = this,
		    fieldAutoComplete = widget.find( 'input.bx-is-autocomplete' );

		// Make items sortable
		self.repeaterSortable( widget );

		// Add color picker fields
		widget.find( '.bx-widget-color-piker' ).wpColorPicker({
			change: _.throttle( function() {
				if( $( 'body' ).hasClass( 'wp-customizer' ) ) {
					$( this ).trigger( 'change' );
				}
			}, 200 ),
			palettes: false
		});

		// Add autocomplete for widgets icons fields
		fieldAutoComplete.autocomplete({
			source: bxext_widgets_customizer.icons,
			select: function( event, ui ) {
				var _this = $( this ),
				    icon  = _this.parent().find( '.bx-is-autocomplete-icon i' );

				icon.removeAttr( 'class' ).addClass( 'fa ' +  ui.item.value );
				_this.trigger( 'change' );
			}
		});
	},

	/**
	 * What to do when something is clicked :)
	 *
	 * @return {Void}
	 */
	events : function() {
		var self = this,
		    _doc = $( document );

		// Tabs toggle and init
		_doc.on( 'click', 'a.bx-wt-tab-toggle', function( e ) {
			self.tabsInit( this );
			e.preventDefault();
		});

		// Upload media
		_doc.on( 'click', '.bx-iu-image-upload', function( e ) {
			e.preventDefault();
			self.mediaUpload( this );
		});

		// Remove media
		_doc.on( 'click', '.bx-iu-image-remove', function( e ) {
			e.preventDefault();
			self.mediaUpload( this, true );
		});

		// Selec media type toggle
		_doc.on( 'change', '.bx-select-type', function( e ) {
			e.preventDefault();
			self.showOnSelect( this );
		});

		// Add repeating field
		_doc.on( 'click', '.bx-widget-repeater-add', function( e ) {
			var widgetObj = $( this ).parents( '.widget' ),
			    model     = self.repeaterModel(),
			    view      = self.repeaterView(),
			    idBase    = widgetObj.find( '.id_base' ).val(),
			    elType    = widgetObj.find( '.bx-widget-repeater-el' ).attr( 'data-acb-el' ),
			    thisModel, thisView, values;

			values = {
				widget : {
					id     : widgetObj.find( '.widget-id' ).val(),
					base   : idBase,
					number : widgetObj.find( '.widget_number' ).val(),
					object : widgetObj,
					elem   : elType,
				},
				value  : '',
			};

			// Add the new element
			view = view.extend({
				className : idBase + '-repeatable-item bx-bs bx-clearfix',
				template  : window.wp.template( idBase + '-repeater' ),
			})

			thisModel = new model( values );
			thisView  = new view({ model : thisModel });

			/**
			 * Trigger event when an element is being added
			 *
			 * @see repeaterView()->actualize()
			 */
			thisView.trigger( 'bx-widget-repeatable-el-added', this );

			e.preventDefault();
		});

		// Remove repeating field
		_doc.on( 'click', '.bx-widget-repeater-remove-item', function ( e ) {
			var widgetObj = $( this ).parents( '.widget' ),
			    idBase    = widgetObj.find( '.id_base' ).val()

			// Remove the element
			$( this ).parents( 'li.' + idBase + '-repeatable-item' ).remove();

			// Trigger change
			widgetObj.find( '.bx-widget-repeatable-change' ).trigger( 'change' );

			e.preventDefault();
		});

		// Initialise widget
		_doc.on( 'widget-added', function( e, widget ) {
			if ( widget.is( '[id*=bx-item]' ) ) {
				self.widgetInit( widget );
			}
			e.preventDefault();
		});
	},
}

$( document ).ready( function ( $ ) {
	var bxextwidgets = window.BxExtWidgets;

	/**
	 * Initialise BxExtWidgets
	 */
	bxextwidgets.init();
});
