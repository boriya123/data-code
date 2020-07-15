<?php
/*
 * @link              http://wpthemespace.com
 * @since             1.0.0
 * @package           Magical Posts Display
 *
 * @wordpress-plugin
 * Plugin Name:       Magical Posts Display
 * Plugin URI:        http://wpthemespace.com
 * Description:       Show your site posts in a great way.
 * Version:           1.1.2.1
 * Author:            Noor alam
 * Author URI:        https://profiles.wordpress.org/nalam-1
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       magical-posts-display
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


function mgpd_plugin_homego($plugin){
        if(plugin_basename( __FILE__ ) == $plugin  ){
            wp_redirect( admin_url( 'edit.php?post_type=mp-display&page=mgpd-welcome' ) );
            die();
        }
    }
add_action( 'activated_plugin', 'mgpd_plugin_homego' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

require_once( 'lib/custom-template/pagetemplater.php' );


final class magicalPostDisplay {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const version = '1.0.8';

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
	 * @var magicalPostDisplay The single instance of the class.
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
	 * @return magicalPostDisplay An instance of the class.
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
		define('MAGICAL_POSTS_DISPLAY_VERSION', self::version);
		define('MAGICAL_POSTS_DISPLAY_FILE', __FILE__);
		define('MAGICAL_POSTS_DISPLAY_DIR', plugin_dir_path( __FILE__ ));
		define('MAGICAL_POSTS_DISPLAY_URL', plugins_url( '', MAGICAL_POSTS_DISPLAY_FILE ));
		define('MAGICAL_POSTS_DISPLAY_ASSETS', MAGICAL_POSTS_DISPLAY_URL.'/assets/');
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

		load_plugin_textdomain( 'magical-posts-display' );

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

		require_once( 'file-include.php' );


		require_once( 'lib/carbon-fields/vendor/autoload.php' );
		\Carbon_Fields\Carbon_Fields::boot();
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}
/*		add_action( 'wp_enqueue_scripts', [ $this, 'mgpost_display_scripts' ] );
*/		add_action( 'admin_enqueue_scripts', [ $this, 'mgpost_display_editor_scripts' ] );
		add_action( 'enqueue_block_assets', [ $this, 'mgpblock_scripts' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'mgpblock_editor_scripts' ] );

		// Add image size
		add_image_size( 'slider-bg', 1600, 600, true );
		add_image_size( 'card-grid', 600, 900, true );
		add_image_size( 'card-list', 600, 700, true );

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
	public function mgpblock_scripts(){

	wp_enqueue_style( 'animate', plugins_url( '/assets/css/animate.css', __FILE__ ), array(), '1.0', 'all');
	wp_enqueue_style( 'bootstrap', plugins_url( '/assets/css/bootstrap.min.css', __FILE__ ), array(), '4.4.1', 'all');
	wp_enqueue_style( 'font-awesome-five-all', plugins_url( '/assets/css/all.min.css', __FILE__ ), array(), '5.13.0', 'all');
	wp_enqueue_style( 'swiper.min', plugins_url( '/assets/css/swiper.min.css', __FILE__ ), array(), '5.3.8', 'all');
	wp_enqueue_style( 'mpd-style', plugins_url( '/assets/css/mp-style.css', __FILE__ ), array(), '1.1.2', 'all');

	wp_enqueue_script('masonry');
	wp_enqueue_script( 'bootstrap', plugins_url( '/assets/js/bootstrap.min.js', __FILE__ ), array( 'jquery' ), '4.4.1', true);
	wp_enqueue_script( 'swiper.min', plugins_url( '/assets/js/swiper.min.js', __FILE__ ), array( 'jquery' ), '5.3.8', false);
	wp_enqueue_script( 'jquery.easy-ticker', plugins_url( '/assets/js/jquery.easy-ticker.min.js', __FILE__ ), array( 'jquery' ), '3.1.0', false);
	wp_enqueue_script( 'mpd-main', plugins_url( '/assets/js/main.js', __FILE__ ), array( 'jquery' ), '1.0', true);


	}

	/**
	 * Add style and scripts for gutenburg editor
	 *
	 * Add the plugin style and scripts for gutenburg editor
	 *
	 * @since 1.0.4
	 *
	 * @access public
	 */
	public function mgpblock_editor_scripts(){
		   wp_enqueue_style('mp-admin-block', plugins_url('/assets/css/mgblock-admin.css', __FILE__), array(), '1.0.0', 'all' );
		   

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
	public function mgpost_display_editor_scripts(){
		global $pagenow;

    if( in_array($pagenow, array('post-new.php', 'post.php'))) {
    	wp_enqueue_style('mp-admin-style', plugins_url('/assets/css/admin-style.css', __FILE__), array(), '1.0.0', 'all' );

	wp_enqueue_script( 'cmb2-conditional-logic', plugins_url( '/assets/js/cmb2-conditional-logic.js', __FILE__ ), array( 'jquery' ), '2.5.1', true);
    }
    if(isset($_GET['page']) && $_GET['page'] == 'mgpd-welcome' ){
    wp_enqueue_style('mp-admin-page', plugins_url('/assets/css/mgadmin-page.css', __FILE__), array(), '1.0.0', 'all' );
    wp_enqueue_style('venobox.min', plugins_url('/assets/css/venobox.min.css', __FILE__), array(), '1.0.0', 'all' );
	wp_enqueue_script( 'venobox-js', plugins_url( '/assets/js/venobox.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true);
	}
		
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

magicalPostDisplay::instance();