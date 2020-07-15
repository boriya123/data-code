<?php
/**
 * @link              
 * @since             1.0.0
 * @package           Magical Blocks
 *
 * @wordpress-plugin
 * Plugin Name:       Magical Blocks
 * Plugin URI:        
 * Description:       One of the best block addons for Gutenberg editor
 * Version:           1.0.2
 * Author:            Noor alam
 * Author URI:        
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       magical-blocks
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
require_once( 'lib/pagetemplater.php' );
require_once( 'includes/block-accordion.php' );
require_once( 'includes/block-hvr-card.php' );
require_once( 'includes/block-infobox.php' );
require_once( 'includes/block-card.php' );
require_once( 'includes/block-banner.php' );
require_once( 'includes/block-carousel.php' );


final class magicalBlocks {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const version = '1.0.2';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';
	

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var magicalBlocks The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return magicalBlocks An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->define_constants();
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	public function define_constants() {
		define('MGBLOCKS_VERSION', self::version);
		define('MGBLOCKS_FILE', __FILE__);
		define('MGBLOCKS_PATH', __DIR__);
		define('MGBLOCKS_URL', plugins_url( '', MGBLOCKS_FILE ));
		define('MGBLOCKS_ASSETS', MGBLOCKS_URL.'/assets/');
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'magical-blocks' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// add image size
		add_image_size( 'mgb-medium', 600, 600, true );
		add_image_size( 'mgb-vertical', 600, 900, true );
		add_image_size( 'mgb-banner', 1600, 800, true );

		require_once( 'lib/carbon-fields/vendor/autoload.php' );
		\Carbon_Fields\Carbon_Fields::boot();
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}
		add_action( 'enqueue_block_assets', [ $this, 'mgblock_scripts' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'mgblock_editor_scripts' ] );

	}




	/**
	 * Add style and scripts
	 *
	 * Add the plugin style and scripts for this
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function mgblock_scripts(){
		wp_enqueue_style( 'font-awesome-five-all', MGBLOCKS_ASSETS.'css/all.min.css' , array(), '5.13.0', 'all');
		wp_enqueue_style( 'bootstrap', MGBLOCKS_ASSETS.'css/bootstrap.min.css' , array(), '4.4.1', 'all');
		wp_enqueue_style( 'mgb-hover-img', MGBLOCKS_ASSETS.'css/img-hvr-card/imagehover.min.css' , array(), '1.0.0', 'all');
		wp_enqueue_style( 'swiper', MGBLOCKS_ASSETS.'css/swiper.min.css' , array(), '5.3.8', 'all');
		wp_enqueue_style( 'magical-blocks-style', MGBLOCKS_ASSETS.'css/mg-blocks.css' , array(), '1.0.2', 'all');

		// js file enqueue
		wp_enqueue_script( 'bootstrap', MGBLOCKS_ASSETS.'js/bootstrap.min.js', array( 'jquery' ), '4.4.1', true);
		wp_enqueue_script( 'swiper', MGBLOCKS_ASSETS.'js/swiper.min.js', array( 'jquery' ), '5.3.8', false);
		wp_enqueue_script( 'magical-blocks-script', MGBLOCKS_ASSETS.'js/mg-blocks.js', array( 'jquery' ), '1.0.2', true);


	}

	/**
	 * Add style and scripts for editor
	 *
	 * Add the plugin style and scripts for editor only
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function mgblock_editor_scripts(){
		wp_enqueue_style( 'mg-editor', MGBLOCKS_ASSETS.'css/mg-editor' , array(), '1.0.0', 'all');
		
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'magical-blocks' ),
			'<strong>' . esc_html__( 'Magical Blocks', 'magical-blocks' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'magical-blocks' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}






}

magicalBlocks::instance();




	function icon_options_class($valueq) {
		$options = [];

		$icons = json_decode( file_get_contents( \Carbon_Field_Icon\DIR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'fontawesome.json' ), true );


		foreach ( $icons as $icon ) {
			$value = $icon['id'];

			if ( $icon['styles'][0] === 'brands' ) {
				$icon_class = 'fab';
			} else if ( $icon['styles'][0] === 'solid' ) {
				$icon_class = 'fas';
			}

			$options[ $value ] = array(
				'value'        => $value,
				'name'         => $icon['name'],
				'class'        => "{$icon_class} fa-" . $icon['id'],
				'search_terms' => $icon['search_terms'],
				'provider'     => 'fontawesome',
			);
		}
		$keys = array_search($valueq,$icons,true);


		return $keys;
	}