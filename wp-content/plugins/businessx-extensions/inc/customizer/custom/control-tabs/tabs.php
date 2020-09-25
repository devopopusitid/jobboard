<?php
/**
 * Tabs for front page section
 */
if( ! class_exists( 'BXEXT_Control_Tabs' ) ) {
	class BXEXT_Control_Tabs extends WP_Customize_Control {

		public $type      = 'section-tabs';
		public $title_colors = '';
		public $title_background = '';

		public function to_json() {
			parent::to_json();
			$this->json['title_colors']     = $this->title_colors;
			$this->json['title_background'] = $this->title_background;
		}

		protected function content_template() {
			?>
			<button data-bx-cz-tab-show="color" type="button" class="button bx-cz-tab-colors">
				<span class="dashicons bx-cz-tc"></span>{{ data.title_colors }}
			</button>

			<button data-bx-cz-tab-show="bg" type="button" class="button bx-cz-tab-background">
				<span class="dashicons bx-cz-tb"></span>{{ data.title_background }}
			</button>
			<?php
		}


	}
}
