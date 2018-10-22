<?php
/**
 * Виджет карты
 */
namespace Mihdan\Elementor\Tables\Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Widget extends \Elementor\Widget_Base {

	/**
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tables';
	}

	/**
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Tables', 'elementor' );
	}

	/**
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-google-maps';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'mihdan' ];
	}

	public function get_script_depends() {
		//return [ 'mihdan-elementor-yandex-maps-api', 'mihdan-elementor-yandex-maps' ];
	}


	/**
	 * Register yandex maps widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		/**
		 * Настройки карты
		 */
		$this->start_controls_section(
			'section_map_',
			[
				'label' => __( 'Map', 'elementor' ),
			]
		);

		$this->add_control(
			'map_notice__',
			[
				'label'       => __( 'Find Latitude & Longitude', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::RAW_HTML,
				'raw'         => '<form onsubmit="mihdan_elementor_yandex_maps_find_address( this );" action="javascript:void(0);"><input type="text" id="eb-map-find-address" class="eb-map-find-address" style="margin-top:10px; margin-bottom:10px;"><input type="submit" value="Search" class="elementor-button elementor-button-default" onclick="mihdan_elementor_yandex_maps_find_address( this )"></form><div id="eb-output-result" class="eb-output-result" style="margin-top:10px; line-height: 1.3; font-size: 12px;"></div>',
				'label_block' => true,
			]
		);



		$this->end_controls_section();


	}

	/**
	 * Render yandex maps widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
	}

	/**
	 * Render yandex maps widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		?>
		<div id="eb-map-<?php echo esc_attr( $this->get_id() ); ?>">Tables was where</div>
		<?php
	}
}

// eof;
