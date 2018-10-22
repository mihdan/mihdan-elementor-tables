<?php
/**
 * Виджет карты
 */
namespace Mihdan\Elementor\Tables;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Tables extends \Elementor\Widget_Base {

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
	protected function _register_controls() {}
	protected function _____register_controls() {

		/**
		 * Настройки карты
		 */
		$this->start_controls_section(
			'section_map',
			[
				'label' => __( 'Map', 'elementor' ),
			]
		);

		$this->add_control(
			'map_notice',
			[
				'label'       => __( 'Find Latitude & Longitude', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::RAW_HTML,
				'raw'         => '<form onsubmit="mihdan_elementor_yandex_maps_find_address( this );" action="javascript:void(0);"><input type="text" id="eb-map-find-address" class="eb-map-find-address" style="margin-top:10px; margin-bottom:10px;"><input type="submit" value="Search" class="elementor-button elementor-button-default" onclick="mihdan_elementor_yandex_maps_find_address( this )"></form><div id="eb-output-result" class="eb-output-result" style="margin-top:10px; line-height: 1.3; font-size: 12px;"></div>',
				'label_block' => true,
			]
		);

		$this->add_control(
			'map_lat',
			[
				'label'       => __( 'Latitude', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '55.7522200',
				'default'     => '55.7522200',
			]
		);

		$this->add_control(
			'map_lng',
			[
				'label'       => __( 'Longitude', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '37.6155600',
				'default'     => '37.6155600',
				'separator'   => true,
			]
		);

		$this->add_control(
			'zoom',
			[
				'label'   => __( 'Zoom Level', 'elementor' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range'   => [
					'px' => [
						'min' => 1,
						'max' => 19,
					],
				],
			]
		);

		$this->add_control(
			'height',
			[
				'label'   => __( 'Height', 'elementor' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 100,
						'max' => 1440,
					],
				],
				'default' => [
					'size' => 300,
				],
			]
		);

		$this->add_control(
			'map_type',
			[
				'label'   => __( 'Map Type', 'elementor' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'map'       => __( 'Road Map', 'elementor' ),
					'satellite' => __( 'Satellite', 'elementor' ),
					'hybrid'    => __( 'Hybrid', 'elementor' ),
				],
				'default' => 'map',
			]
		);

		$this->add_control(
			'view',
			[
				'label'   => __( 'View', 'elementor' ),
				'type'    => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		/**
		 * Контроллы карты
		 */
		$this->start_controls_section(
			'map_controls',
			[
				'label' => __( 'Map Controls', 'elementor' ),
			]
		);

		$this->add_control(
			'ruler_control',
			[
				'label'       => __( 'Ruler Control', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Линейка и масштабный отрезок', 'elementor' ),
			]
		);

		$this->add_control(
			'search_control',
			[
				'label'       => __( 'Search Control', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Поиск на карте', 'elementor' ),
			]
		);

		$this->add_control(
			'traffic_control',
			[
				'label'       => __( 'Traffic Control', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Панель пробок', 'elementor' ),
			]
		);

		$this->add_control(
			'type_selector',
			[
				'label'       => __( 'Type Selector', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'description' => __( 'Панель переключения типа карт', 'elementor' ),
			]
		);

		$this->add_control(
			'zoom_control',
			[
				'label'       => __( 'Zoom Control', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'description' => __( 'Ползунок масштаба', 'elementor' ),
			]
		);

		$this->add_control(
			'geolocation_control',
			[
				'label'       => __( 'Geolocation Control', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Элемент управления геолокацией', 'elementor' ),
			]
		);

		$this->add_control(
			'route_editor',
			[
				'label'       => __( 'Route Editor', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Редактор маршрутов', 'elementor' ),
			]
		);

		$this->add_control(
			'fullscreen_control',
			[
				'label'       => __( 'Fullscreen Control', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Элемент управления «полноэкранным режимом»', 'elementor' ),
			]
		);

		$this->add_control(
			'route_button_control',
			[
				'label'       => __( 'Route Button Control', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Панель для построения маршрутов', 'elementor' ),
			]
		);

		$this->add_control(
			'route_panel_control',
			[
				'label'       => __( 'Route Panel Control', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Панель маршрутизации', 'elementor' ),
			]
		);

		$this->end_controls_section();

		/**
		 * Поведение карты
		 */
		$this->start_controls_section(
			'map_behavior',
			[
				'label' => __( 'Map Behavior', 'elementor' ),
			]
		);

		$this->add_control(
			'disable_scroll_zoom',
			[
				'label'       => __( 'Disable Scroll Zoom', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Отключить прокрутку карты колесом мыши', 'elementor' ),
			]
		);

		$this->add_control(
			'disable_dbl_click_zoom',
			[
				'label'       => __( 'Disable Dbl Click Zoom', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Отключить масштабирование карты двойным щелчком кнопки мыши', 'elementor' ),
			]
		);

		$this->add_control(
			'disable_drag',
			[
				'label'       => __( 'Disable Drag', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Отключить перетаскивание карты с помощью мыши либо одиночного касания', 'elementor' ),
			]
		);

		$this->add_control(
			'disable_left_mouse_button_magnifier',
			[
				'label'       => __( 'Disable Left Mouse Button Magnifier', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Отключить масштабирование карты при выделении области левой кнопкой мыши', 'elementor' ),
			]
		);

		$this->add_control(
			'disable_right_mouse_button_magnifier',
			[
				'label'       => __( 'Disable Right Mouse Button Magnifier', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Отключить масштабирование карты при выделении области правой кнопкой мыши', 'elementor' ),
			]
		);

		$this->add_control(
			'disable_multi_touch',
			[
				'label'       => __( 'Disable Multi Touch', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Отключить масштабирование карты мультисенсорным касанием', 'elementor' ),
			]
		);

		$this->add_control(
			'disable_route_editor',
			[
				'label'       => __( 'Disable Route Editor', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Отключить редактор маршрутов', 'elementor' ),
			]
		);

		$this->add_control(
			'disable_ruler',
			[
				'label'       => __( 'Disable Ruler', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::SWITCHER,
				'default'     => 'no',
				'description' => __( 'Отключить линейку', 'elementor' ),
			]
		);

		$this->end_controls_section();

		/*Pins Option*/
		$this->start_controls_section(
			'map_marker_pin',
			[
				'label' => __( 'Marker Pins', 'elementor' ),
			]
		);

		$this->add_control(
			'infowindow_max_width',
			[
				'label'       => __( 'InfoWindow Max Width', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '300',
				'default'     => '300',
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'       => __( 'Pin Item', 'elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'default'     => [
					[
						'pin_title'   => __( 'Pin #1', 'elementor' ),
						'pin_notice'  => __( 'Find Latitude & Longitude', 'elementor' ),
						'pin_lat'     => __( '55.7522200', 'elementor' ),
						'pin_lng'     => __( '37.6155600', 'elementor' ),
						'pin_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ),
					],
				],
				'fields'      => [
					[
						'name'        => 'pin_notice',
						'label'       => __( 'Find Latitude & Longitude', 'elementor' ),
						'type'        => \Elementor\Controls_Manager::RAW_HTML,
						'raw'         => '<form onsubmit="mihdan_elementor_yandex_maps_find_pin_address( this );" action="javascript:void(0);"><input type="text" id="eb-map-find-address" class="eb-map-find-address" style="margin-top:10px; margin-bottom:10px;"><input type="submit" value="Search" class="elementor-button elementor-button-default" onclick="mihdan_elementor_yandex_maps_find_pin_address( this )"></form><div id="eb-output-result" class="eb-output-result" style="margin-top:10px; line-height: 1.3; font-size: 12px;"></div>',
						'label_block' => true,
					],
					[
						'name'        => 'pin_lat',
						'label'       => __( 'Latitude', 'elementor' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => '55.7522200',
						'placeholder' => '55.7522200',
					],
					[
						'name'        => 'pin_lng',
						'label'       => __( 'Longitude', 'elementor' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => '37.6155600',
						'placeholder' => '37.6155600',
					],
					[
						'name'    => 'pin_icon',
						'label'   => __( 'Marker Icon', 'elementor' ),
						'type'    => \Elementor\Controls_Manager::SELECT,
						'options' => [
							// @link https://tech.yandex.ru/maps/doc/jsapi/2.1/ref/reference/option.presetStorage-docpage/
							'blue'       => __( 'Blue', 'elementor' ),
							'red'        => __( 'Red', 'elementor' ),
							'darkOrange' => __( 'Dark Orange', 'elementor' ),
							'darkBlue'   => __( 'Dark Blue', 'elementor' ),
							'pink'       => __( 'Pink', 'elementor' ),
							'grey'       => __( 'Grey', 'elementor' ),
							'brown'      => __( 'Brown', 'elementor' ),
							'purple'     => __( 'Purple', 'elementor' ),
							'darkGreen'  => __( 'Dark Green', 'elementor' ),
							'violet'     => __( 'Violet', 'elementor' ),
							'black'      => __( 'Black', 'elementor' ),
							'yellow'     => __( 'Yellow', 'elementor' ),
							'green'      => __( 'Green', 'elementor' ),
							'orange'     => __( 'Orange', 'elementor' ),
							'lightBlue'  => __( 'Light Blue', 'elementor' ),
							'olive'      => __( 'Olive', 'elementor' ),
						],
						'default' => 'blue',
					],
					[
						'name'        => 'pin_title',
						'label'       => __( 'Title', 'elementor' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => __( 'Pin Title', 'elementor' ),
						'label_block' => true,
					],
					[
						'name'    => 'pin_content',
						'label'   => __( 'Content', 'elementor' ),
						'type'    => \Elementor\Controls_Manager::WYSIWYG,
						'default' => __( 'Pin Content', 'elementor' ),
					],
				],
				'title_field' => '{{{ pin_title }}}',
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
		$settings = $this->get_settings();// print_r($settings);

		if ( 0 === absint( $settings['zoom']['size'] ) ) {
			$settings['zoom']['size'] = 10;
		}

		$mapmarkers = array();

		foreach ( $settings['tabs'] as $index => $item ) :
			$tab_count    = $index + 1;
			$mapmarkers[] = array(
				'lat'      => $item['pin_lat'],
				'lng'      => $item['pin_lng'],
				'title'    => $item['pin_title'],
				'content'  => htmlspecialchars( $item['pin_content'], ENT_QUOTES & ~ENT_COMPAT ),
				'pin_icon' => $item['pin_icon'],
			);
		endforeach;
		?>

		<div id="eb-map-<?php echo esc_attr( $this->get_id() ); ?>">Tables was where</div>
	<?php
	}
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Tables() );

// eof;
