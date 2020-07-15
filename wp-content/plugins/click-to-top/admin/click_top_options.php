<?php
/**
 * @link              http://digitalkroy.com/click-to-top/
 * @since             1.0.0
 * @package           Click to top
 *
 * @author expert-wp
 */
if ( !class_exists('click_top_options' ) ):
class click_top_options {

    private $settings_api;

    function __construct() {
        $this->settings_api = new click_top_settings;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
		add_options_page( 
		 __( 'Click to top', 'click-top' ),
		__( 'Click to top', 'click-top' ), 
		'manage_options',
		'click-to-top.php',
		array($this, 'plugin_page')
	);
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'click_top_basic',
                'title' => __( 'Basic Settings', 'click-top' )
            ),
            array(
                'id' => 'click_top_style',
                'title' => __( 'Scroll style Settings', 'click-top' )
            )
          
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'click_top_basic' => array(
				 array(
                    'name'    => 'scroll_Distance',
                    'label'   => __( 'Scroll show distance', 'click-top' ),
                    'desc'    => __( 'Distance from top/bottom before showing element (px)', 'click-top' ),
                    'type'              => 'number',
                    'default'           => 300,
                    'sanitize_callback' => 'intval'
                    
                ),
				array(
                    'name'    => 'scroll_Speed',
                    'label'   => __( 'Set scroll speed','click-top' ),
                    'desc'    => __( 'Speed back to top (ms)','click-top' ),
                    'type'              => 'number',
                    'default'           => 300,
                    'sanitize_callback' => 'intval'
                ),
				array(
                    'name'    => 'easing_Type',
                    'label'   => __( 'Select your easing type', 'click-top' ),
                    'desc'    => __( 'Scroll to top easing style set as you choice', 'click-top' ),
                    'type'    => 'select',
					'default' => 'linear',
                    'options' => array(
                        'linear' =>'linear', 
                        'easeInSine' => 'easeInSine', 
                        'easeOutSine' => 'easeOutSine', 
                        'easeInOutSine' => 'easeInOutSine', 
                        'easeInQuad' => 'easeInQuad', 
                        'easeOutQuad' => 'easeOutQuad', 
                        'easeInOutQuad' => 'easeInOutQuad', 
                        'easeInCubic' => 'easeInCubic', 
                        'easeOutCubic' => 'easeOutCubic', 
                        'easeInOutCubic' => 'easeInOutCubic', 
                        'easeInQuart' => 'easeInQuart', 
                        'easeOutQuart' => 'easeOutQuart', 
                        'easeInOutQuart' => 'easeInOutQuart', 
                        'easeInQuint' => 'easeInQuint', 
                        'easeOutQuint' => 'easeOutQuint', 
                        'easeInOutQuint' => 'easeInOutQuint', 
                        'easeInExpo' => 'easeInExpo', 
                        'easeOutExpo' => 'easeOutExpo', 
                        'easeInOutExpo' => 'easeInOutExpo', 
                        'easeInCirc' => 'easeInCirc', 
                        'easeOutCirc' => 'easeOutCirc', 
                        'easeInOutCirc' => 'easeInOutCirc', 
                        'easeInBack' => 'easeInBack', 
                        'easeOutBack' => 'easeOutBack', 
                        'easeInOutBack' => 'easeInOutBack', 
                        'easeInElastic' => 'easeInElastic', 
                        'easeOutElastic' => 'easeOutElastic', 
                        'easeInOutElastic' => 'easeInOutElastic', 
                        'easeInBounce' => 'easeInBounce', 
                        'easeOutBounce' => 'easeOutBounce', 
                        'easeInOutBounce' => 'easeInOutBounce' 
                    )
                ),
				array(
                    'name'    => 'ani_mation',
                    'label'   => __( 'Select animation', 'click-top' ),
                    'desc'    => __( 'Select animation in this box.', 'click-top' ),
                    'type'    => 'radio',
					'default' => 'slide',
                    'options' => array(
                        'Fade' => __( 'Fade', 'click-top' ),
                        'slide' => __( 'slide', 'click-top' ),
                        'none' => __( 'none', 'click-top' ),
                    )
                ),
				array(
                    'name'    => 'animation_Speed',
                    'label'   => __( 'Set Animation speed','click-top' ),
                    'desc'    => __( 'Set Animation speed by (ms)','click-top' ),
                    'type'              => 'number',
                    'default'           => 200,
                    'sanitize_callback' => 'intval'
                ),
				array(
                    'name'    => 'scroll_position',
                    'label'   => __( 'scroll position', 'click-top' ),
                    'desc'    => __( 'Select scroll position left or right.', 'click-top' ),
                    'type'    => 'radio',
					'default' => 'right',
                    'options' => array(
                        'left' => __( 'Left side', 'click-top' ),
                        'right' => __( 'Right side', 'click-top' )
                    )
                ),
				array(
                    'name'    => 'selected_position',
                    'label'   => __( 'Set selected position margin', 'click-top' ),
                    'desc'    => __( 'If you select right side set right side margin and if you select left side set left side margin by %.Set 0 to 5 for better view.default is 5', 'click-top' ),
                    'type'              => 'number',
                    'default'           => 5,
                    'sanitize_callback' => 'intval'
                ),
				array(
                    'name'    => 'bottom_position',
                    'label'   => __( 'Bottom position', 'click-top' ),
                    'desc'    => __( 'Set scroll bottom position by %.Set 0 to 5 for better view.default is 5', 'click-top' ),
                    'type'              => 'number',
                    'default'           => 5,
                    'sanitize_callback' => 'intval'
                ),


            ),
            'click_top_style' => array(
				array(
                    'name'    => 'btn_style',
                    'label'   => __( 'Select scroll button style', 'click-top' ),
                    'desc'    => __( 'Select scroll button style square or round.', 'click-top' ),
                    'type'    => 'radio',
					'default' => 'square',
                    'options' => array(
                        'square' => __( 'Square', 'click-top' ),
                        'round' => __( 'Round', 'click-top' ),
                    )
                ),
                array(
                    'name'    => 'hover_affect',
                    'label'   => __( 'Select scroll hover style.', 'click-top' ),
                    'desc'    => __( 'Select scroll hover style on your choice.', 'click-top' ),
                    'type'    => 'select',
					'default' => 'bubble-top',
                    'options' => array(
                        'shrink' =>'Shrink',
                        'grow'  =>'Grow',
                        'pulse'  =>'Pulse',
                        'pulse-grow'  =>'Pulse grow',
                        'pulse-shrink'  =>'Pulse shrink',
                        'push'  =>'Push',
                        'pop'  =>'pop',
                        'bounce-in'  =>'Bounce in',
                        'bounce-out'  =>'Bounce out',
                        'float'  =>'Float',
                        'bob'  =>'Bob',
                        'buzz'  =>'Buzz',
                        'fade'  =>'Background fade',
                        'back-pulse'  =>'Background back-pulse',
                        'back-pulse'  =>'Background back-pulse',
                        'sweep-to-right'  =>'Background sweep-to-right',
                        'sweep-to-left'  =>'Background sweep-to-left',
                        'sweep-to-bottom'  =>'Background sweep-to-bottom',
                        'sweep-to-top'  =>'Background sweep-to-top',
                        'bounce-to-right'  =>'Background bounce-to-right',
                        'bounce-to-left'  =>'Background bounce-to-left',
                        'bounce-to-bottom'  =>'Background bounce-to-bottom',
                        'bounce-to-top'  =>'Background bounce-to-top',
                        'radial-out'  =>'Background radial-out',
                        'radial-in'  =>'Background radial-in',
                        'rectangle-in'  =>'Background rectangle-in',
                        'rectangle-out'  =>'Background rectangle-out',
                        'shutter-in-horizontal'  =>'Background shutter-in-horizontal',
                        'shutter-out-horizontal'  =>'Background shutter-out-horizontal',
                        'shutter-in-vertical'  =>'Background shutter-in-vertical',
                        'shutter-out-vertical'  =>'Background shutter-out-vertical',
                        'border-fade'  =>'Border fade',
                        'hollow'  =>'Border hollow',
                        'trim'  =>'Border trim',
                        'ripple-out'  =>'Border ripple-out',
                        'ripple-in'  =>'Border ripple-in',
                        'outline-out'  =>'Border outline-out',
                        'outline-in'  =>'Border outline-in',
                        'round-corners'  =>'Border round-corners',
                        'underline-from-left'  =>'Border underline-from-left',
                        'underline-from-center'  =>'Border underline-from-center',
                        'underline-from-right'  =>'Border underline-from-right',
                        'reveal'  =>'Border reveal',
                        'underline-reveal'  =>'Border underline-reveal',
                        'overline-reveal'  =>'Border overline-reveal',
                        'overline-from-left'  =>'Border overline-from-left',
                        'overline-from-center'  =>'Border overline-from-center',
                        'overline-from-right'  =>'Border overline-from-right',
                        'shadow'  =>'Shadow',
                        'grow-shadow'  =>'Grow-shadow',
                        'float-shadow'  =>'Float-shadow',
                        'glow'  =>'Glow-shadow',
                        'shadow-radial'  =>'Shadow-radial',
                        'box-shadow-outset'  =>'Box-shadow-outset',
                        'box-shadow-inset'  =>'Box-shadow-inset',
                        'bubble-top'  =>'Bubble-top',
                        'bubble-float-top'  =>'Bubble-float-top',
                    )
                ),
				array(
                    'name'    => 'btn_type',
                    'label'   => __( 'Select scroll button type', 'click-top' ),
                    'desc'    => __( 'Select scroll button type text or icon.', 'click-top' ),
                    'type'    => 'radio',
					'default' => 'icon',
                    'options' => array(
                        'icon' => __( 'Icon', 'click-top' ),
                        'text' => __( 'Text', 'click-top' ),
                    )
                ),
								array(
                    'name'    => 'select_icon',
                    'label'   => __( 'Select scroll icon', 'click-top' ),
                    'desc'    => __( 'First select button type icon then choice icon.', 'click-top' ),
                    'type'    => 'select',
                    'default' => 'angle-double-up',
                    'options' => array(
                        'angle-double-up' => 'icon angle-double-up',
                        'angle-up' => 'icon angle up',
                        'arrow-circle-o-up' => 'icon arrow circle o up',
                        'arrow-circle-up' => 'icon arrow circle up',
                        'arrow-up' => 'icon arrow-up',
                        'caret-square-o-up' => 'icon caret square o up',
                        'caret-up' => 'icon caret up',
                        'chevron-circle-up' => 'icon chevron circle up',
                        'chevron-up' => 'icon chevron up',
                        'hand-o-up' => 'icon hand up',
						'hand-pointer-o' => 'icon hand pointer',
                        'long-arrow-up' => 'icon long arrow up',
						'toggle-up' => 'icon toggle up',
                    )
                ),
				array(
                    'name'    => 'btn_text',
                    'label'   => __( 'Type scroll text', 'click-top' ),
                    'desc'    => __( 'First select button type text then type your text.', 'click-top' ),
                    'type'    => 'text',
					'default' => 'Click to top',
                  
                ),
				array(
                    'name'    => 'bg_color',
                    'label'   => __( 'Set background color', 'click-top' ),
                    'desc'    => __( 'Set scroll background color.', 'click-top' ),
                    'type'    => 'color',
					'default' => '#cccccc',
                  
                ),
				array(
                    'name'    => 'icon_color',
                    'label'   => __( 'Set icon or text color', 'click-top' ),
                    'desc'    => __( 'Set color text or icon, whatever you select.', 'click-top' ),
                    'type'    => 'color',
					'default' => '#000000',
                  
                ),
				array(
                    'name'    => 'bg_hover_color',
                    'label'   => __( 'Set scroll background hover color', 'click-top' ),
                    'desc'    => __( 'Set scroll background hover color.', 'click-top' ),
                    'type'    => 'color',
					'default' => '#555555',
                  
                ),
				array(
                    'name'    => 'hover_color',
                    'label'   => __( 'Set icon or text hover color', 'click-top' ),
                    'desc'    => __( 'Set scroll selected hover color.', 'click-top' ),
                    'type'    => 'color',
					'default' => '#ffffff',
                  
                ),
			    array(
                    'name'    => 'scroll_opacity',
                    'label'   => __( 'Set scroll opacity', 'click-top' ),
                    'desc'    => __( 'Set scroll opacity by 1 to 99.default is 99', 'click-top' ),
                    'type'              => 'number',
                    'default'           => 99,
                    'sanitize_callback' => 'intval'
                ),
			    array(
                    'name'    => 'scroll_padding',
                    'label'   => __( 'Set scroll padding', 'click-top' ),
                    'desc'    => __( 'Set scroll padding by px.', 'click-top' ),
                    'type'              => 'number',
                    'default'           => 5,
                    'sanitize_callback' => 'intval'
                ),
			    array(
                    'name'    => 'font_size',
                    'label'   => __( 'Set scroll font size', 'click-top' ),
                    'desc'    => __( 'Set scroll font size by px.', 'click-top' ),
                    'type'              => 'number',
                    'default'           => 16,
                    'sanitize_callback' => 'intval'
                ),

            )
        );
        return $settings_fields;
    }
    function plugin_page() {
        echo '<div class="wrap click-top">';
        echo '<a href="http://wpthemespace.com/product/x-blog/" target="_blank"> <img src="https://wpthemespace.com/wp-content/uploads/2019/01/xblog-pro.png'.'" alt="X blog pro" /></a>';
		echo '<h1>' . esc_html__( 'Click to top settings', 'click-top' ) . '</h1>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
require plugin_dir_path( __FILE__ ) . '/src/class.settings-api.php';
new click_top_options();

//Admin notice 
if( !function_exists('wpspace_admin_notice')):
function wpspace_admin_notice() {
    global $pagenow;
    if( $pagenow != 'themes.php' ){
        return;
    }

    $class = 'notice notice-success is-dismissible';
    $url1 = esc_url('https://wpthemespace.com/product-category/theme/');

    $message = __( '<strong><span style="color:red;">Recommended WordPress Themes:</span>  <span style="color:green"> Awesome WordPress Theme For your WordPress Website</span>  </strong>', 'click-top' );

    printf( '<div class="%1$s" style="padding:10px 15px 20px;"><p>%2$s <a href="%3$s" target="_blank">'.__('see here','click-top' ).'</a>.</p><a target="_blank" class="button button-danger" href="%3$s" style="margin-right:10px">'.__('View All Themes','click-top').'</a></div>', esc_attr( $class ), wp_kses_post( $message ),$url1 ); 
}
add_action( 'admin_notices', 'wpspace_admin_notice' );
endif;

if( !function_exists('wpspace_admin_notice_mplugin')):
add_action( 'admin_notices', 'wpspace_admin_notice_mplugin' );
    function wpspace_admin_notice_mplugin() {
        global $pagenow;
    
        if(get_option('clickrecome') ||  $pagenow  == 'themes.php' || $pagenow  == 'plugins.php'){
        return;
        }

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        
        if (! file_exists( WP_PLUGIN_DIR . '/magical-posts-display/magical-posts-display.php' ) ) {

                $magial_einstall_url =  wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=magical-posts-display' ), 'install-plugin_magical-posts-display' );
                    $wpnmessage = sprintf(
                    /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
                    esc_html__( 'Recommended Best WordPress posts display plugin %1$s, Install and show your posts awesome way. It\'s free  %2$s', 'click-top' ),
                    '<strong>' . esc_html__( 'Magical post display', 'click-top' ) . '</strong>',
                    '<a class="button button-primary" style="margin-left:20px" href="'.$magial_einstall_url.'">' . __( 'Install Magical posts Display', 'click-top' ) . '</a>'

                );
            printf( '<div class="notice notice-warning is-dismissible" style="padding: 13px 10px"><p>%1$s</p><button class="nothanks notic-click-dissmiss">%2$s</button> <a style="margin-left:5px" href="%3$s" class="button-primary">%4$s</a></div> ', $wpnmessage,esc_html__('No Thanks','click-top'),$magial_einstall_url,esc_html__('Check one time','click-top') );

            
        }

    }
endif;

if( !function_exists('wpspace_admin_notice_option')):
function wpspace_admin_notice_option(){
    if(isset($_GET['cdismissed']) && $_GET['cdismissed'] == 1 ){
        update_option( 'clickrecome', 1);
    }
}
add_action('init','wpspace_admin_notice_option');
endif;

