<?php
/**
 * Drag & drop info section
 */
if( ! class_exists( 'BXEXT_Section_DragAndDrop' ) ) {
	class BXEXT_Section_DragAndDrop extends WP_Customize_Section {

		/**
		 * The type of customize section being rendered.
		 */
		public $type = 'dragdrop';

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 */
		public function json() {
			$json = parent::json();
			return $json;
		}

		/**
		 * Outputs the Underscore.js template.
		 */
		protected function render_template() { ?>
			<li id="accordion-section-{{ data.id }}" class="bx_drag_and accordion-section control-section control-section-{{ data.type }} cannot-expand">
				<img class="bx_drag_and_spinner" src="<?php echo esc_url( admin_url() ) ?>images/spinner.gif" />
				{{ data.title }}
			</li>
		<?php }
	}
}
