<?php
/**
 * Plugin Name: Mihdan: Elementor Tables
 * Description: Elementor Yandex Maps Widget - Easily add multiple address pins onto the same map with support for different map types (Road Map/Satellite/Hybrid/Terrain) and custom map style. Freely edit info window content of your pins with the standard Elementor text editor. And many more custom map options.
 * Plugin URI:  https://github.com/mihdan/mihdan-elementor-tables
 * Version:     1.0.0
 * Author:      Mikhail Kobzarev
 * Author URI:  https://www.kobzarev.com/
 * Text Domain: mihdan-elementor-tables
 * GitHub Plugin URI: https://github.com/mihdan/mihdan-elementor-tables
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'EB_TABLES_FILE', __FILE__ );
define( 'EB_TABLES_VERSION', '1.0.0' );

/**
 * Загрузка плагина
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function mihdan_elementor_tables() {
	// Load localization file
	load_plugin_textdomain( 'mihdan-elementor-tables' );
	// Notice if the Elementor is not active
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'mihdan_elementor_tables_fail_load' );
		return;
	}
	// Check required version
	$elementor_version_required = '1.8.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'mihdan_elementor_tables_load_out_of_date' );
		return;
	}
	add_action( 'elementor/widgets/widgets_registered', function () {
		require_once __DIR__ . '/widgets/tables-widget.php';
	} );
}
add_action( 'plugins_loaded', 'mihdan_elementor_tables' );
/**
 * Уведомление админу, что плагин зависит от Elementor
 */
function mihdan_elementor_tables_fail_load() {
	$message = '<p>' . __( 'You do not have Elementor Page Builder on your WordPress. Mihdan: Elementor Yandex Maps require Elementor in order to work.', 'mihdan-elementor-tables' ) . '</p>';
	echo '<div class="error">' . $message . '</div>';
}
/**
 * Уведомление админу, что пора бы обновить Elementor
 */
function mihdan_elementor_tables_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}
	$file_path    = 'elementor/elementor.php';
	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	// Текст сообщения
	$message  = '<p>' . __( 'Elementor Google Map Extended may not work or is not compatible because you are using an old version of Elementor.', 'mihdan-elementor-tables' ) . '</p>';
	$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'mihdan-elementor-tables' ) ) . '</p>';
	echo '<div class="error">' . $message . '</div>';
}
/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 *
 * @return mixed
 */
function mihdan_elementor_tables_get_option( $option, $section, $default = '' ) {
	$options = get_option( $section );
	if ( isset( $options[ $option ] ) ) {
		return $options[ $option ];
	}
	return $default;
}
/**
 * Register and enqueue a custom stylesheet in the Elementor.
 */
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'mihdan-elementor-tables-admin', plugins_url( '/assets/css/mihdan-elementor-tables-admin.css', EB_TABLES_FILE ) );
	wp_enqueue_script( 'mihdan-elementor-tables-api-admin', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&source=admin', [ 'jquery' ], EB_TABLES_VERSION, true );
	wp_localize_script( 'mihdan-elementor-tables-api-admin', 'EB_WP_URL', array( 'plugin_url' => plugin_dir_url( __FILE__ ) ) );
	wp_enqueue_script( 'mihdan-elementor-tables-admin', plugins_url( '/assets/js/mihdan-elementor-tables-admin.js', EB_TABLES_FILE ), [ 'mihdan-elementor-tables-api-admin' ], EB_TABLES_VERSION, true );
} );
add_action( 'elementor/frontend/after_enqueue_styles', function() {
	wp_enqueue_style( 'mihdan-elementor-tables', plugins_url( '/assets/css/mihdan-elementor-tables.css', EB_TABLES_FILE ) );
} );
add_action( 'elementor/frontend/after_register_scripts', function() {
	wp_register_script( 'mihdan-elementor-tables-api', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU&source=frontend', [], EB_TABLES_VERSION, true );
	wp_localize_script( 'mihdan-elementor-tables-api', 'EB_WP_URL', array( 'plugin_url' => plugin_dir_url( __FILE__ ) ) );
	wp_register_script( 'mihdan-elementor-tables', plugins_url( '/assets/js/mihdan-elementor-tables.js', EB_TABLES_FILE ), [ 'mihdan-elementor-tables-api' ], EB_TABLES_VERSION, true );
} );

add_action( 'elementor/elements/categories_registered', function() {
	Elementor\Plugin::$instance->elements_manager->add_category(
		'mihdan', array(
			'title' => 'Mihdan Widgets',
			'icon'  => 'font',
		)
	);
});
// eof;
