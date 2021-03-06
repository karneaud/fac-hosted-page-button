<?php
namespace WPFac\HostedPage\Button\Src;

use WPFac\HostedPage\Button\Lib\Table as Table;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Backend settings page class, can have settings fields or data table
 *
 * @author     Kendall Arneaud
 * @package    fac-hosted-page-button
 */
if ( ! class_exists( 'Settings' ) ) {

	class Settings {


		/**
		 * @var String
		 */
		public $capability;


		/**
		 * @var Array
		 */
		public $menu_page;


		/**
		 * @var Array
		 */
		public $sub_menu_page;


		/**
		 * @var Array
		 */
		public $help;


		/**
		 * @var String
		 */
		public $screen;


		/**
		 * @var Object
		 */
		 public $table;


		/**
		 * Add basic actions for menu and settings
		 *
		 * @return Void
		 */
		public function __construct() {

			$this->capability = 'manage_options';
			$this->menu_page = array( 'name' => '', 'heading' => 'FAC Hosted Page Button Settings', 'slug' => FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings', );
			$this->sub_menu_page = array(
									'name' => 'FAC Hosted Page Button Settings',
									'heading' => 'FAC Hosted Page Button Settings',
									'slug' => FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings',
									'parent_slug' => 'options-writing.php',
									'help' => false,//true/false,
									'screen' => false,//true/false
								);
			$this->helpData = array(
								array(
								'slug' => '',
								'help' => array(
											'info' => array(
														array(
															'id' => 'helpId',
															'title' => __( 'Title', 'fac-hosted-page-button' ),
															'content' => __( 'Description', 'fac-hosted-page-button' ),
														),
													),
											'link' => '<p><a href="#">' . __( 'helpLink', 'fac-hosted-page-button' ) . '</a></p>',
											)
								)
							);
			$this->screen = true; // true/false

			/**
			 * Add menues and hooks
			 */
			add_action( 'admin_init', array( $this, 'add_settings' ) );
        	add_action( 'admin_menu', array( $this, 'menu_page' ) );
			add_filter( 'set-screen-option', array( $this, 'set_screen' ), 10, 3 );
        	// add_filter( 'plugin_action_links_' . FAC_HOSTED_PAGE_BUTTON_FILE ,[ $this, 'register_settings_link'] );
            /*
			add_action( 'admin_menu', array( $this, 'sub_menu_page' ) );
			 *
			 */
		}


		/**
		 * Adds an option page for plugin
		 * @return Void
		 */
		public function menu_page() {

			if ($this->menu_page) {
            	add_options_page(
            		null, // $this->menu_page['name'],
            		null, //$this->menu_page['heading'],
            		$this->capability,
            		$this->menu_page['slug'],
            		array($this, 'menu_page_callback')
       			 );
				/*add_menu_page(
					$this->menu_page['name'],
					$this->menu_page['heading'],
					$this->capability,
					$this->menu_page['slug'],
					array( $this, 'menu_page_callback' )
				);*/
			}
		}

	    public function register_settings_link( $links ) {
		// Build and escape the URL.
		$url = esc_url( add_query_arg(
			'page',
			'menu_page_callback',
			  get_admin_url() . "options-general.php?page=" . FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings'
		) );
		// Create the link.
		$settings_link = "<a href='$url'>" . __( 'Settings' , 'fac-hosted-page-button') . '</a>';
		// Adds the link to the end of the array.
		array_push(
			$links,
			$settings_link
		);
	
    	return $links;
	}


		/**
		 * Add a sample Submenu page callback
		 *
		 * @return Void
		 */
		public function sub_menu_page() {

			if ( $this->sub_menu_page ) {
				foreach ( $this->sub_menu_page as $page ) {
					$hook = add_menu_page(
							$page['parent_slug'],
							$page['name'],
							$page['heading'],
							$this->capability,
							// For the first submenu page, slug should be same as menupage.
							$page['slug'],
							// For the first submenu page, callback should be same as menupage.
							array( $this, 'menu_page_callback' )
						);
					if ( $page['help'] ) {
						add_action( 'load-' . $hook, array( $this, 'help_tabs' ) );
					}
					if ( $page['screen'] ) {
						add_action( 'load-' . $hook, array( $this, 'screen_option' ) );
					}
				}
			}
		}


		/**
		 * Set screen
		 *
		 * @param String $status
		 * @param String $option
		 * @param String $value
		 *
		 * @return String
		 */
		public function set_screen($status, $option, $value) {

			$user = get_current_user_id();

			switch ($option) {
				case 'option_name_per_page':
					update_user_meta($user, 'option_name_per_page', $value);
					$output = $value;
					break;
			}

    		if ( $output ) return $output; // Related to FAC_HOSTED_PAGE_BUTTON_TABLE()
		}


		/**
		 * Set screen option for Items table
		 *
		 * @return Void
		 */
		public function screen_option() {

			$option = 'per_page';
			$args   = array(
						'label'   => __( 'Show per page', 'fac-hosted-page-button' ),
						'default' => 10,
						'option'  => 'option_name_per_page' // Related to FAC_HOSTED_PAGE_BUTTON_TABLE()
						);
			add_screen_option( $option, $args );
			//$this->table = new Table(); // Source /lib/table.php
		}


		/**
		 * Menu page callback
		 *
		 * @return Html
		 */
		public function menu_page_callback() { ?>

			<div class="wrap">
				<h1><?php echo get_admin_page_title(); ?></h1>
				<br class="clear">
				<?php settings_errors();

					/**
					 * Following is the settings form
					 */ ?>
					<form method="post" action="options.php">
						<?php settings_fields(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings');
						do_settings_sections(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings');
						submit_button( __( 'Save Settings', 'fac-hosted-page-button'  ), 'primary', 'id' ); ?>
					</form>

					<?php
					/**
					 * Following is the data table class
					 *
					<form method="post" action="">
					
						//$this->table->prepare_items();
						//$this->table->display(); ?>
					</form>
				<br class="clear">
                */ ?>
			</div>
		<?php
		}


		/**
		 * Add help tabs using help data
		 *
		 * @return Void
		 */
		public function help_tabs() {

			foreach ($this->helpData as $value) {
				if ($_GET['page'] == $value['slug']) {
					$this->screen = get_current_screen();
					foreach( $value['info'] as $key ) {
						$this->screen->add_help_tab( $key );
					}
					$this->screen->set_help_sidebar( $value['link'] );
				}
			}
		}


		/**
		 * Add different types of settings, settings fields and corrosponding sections
		 * @return Void
		 */
		public function add_settings() {

			add_settings_section( FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings', __( 'FAC SETTINGS','fac-hosted-page-button'), array( $this,'section_cb' ), FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings' );
        	register_setting( FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings', FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings', [ 'type' => 'array', 'sanitize_callback' => [$this, 'sanitize_settings' ]] );
			add_settings_field( FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_merchant_id', __( 'FAC MERCHANT ID', FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN ), array( $this, 'settings_field_merchant_id' ), FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN .'_settings', FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings' );
        	add_settings_field( FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_merchant_secret', __( 'FAC MERCHANT SECRET', 'fac-hosted-page-button' ), array( $this, 'settings_field_merchant_secret' ), FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN .'_settings', FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings' );
        	add_settings_field( FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_page_set', __( 'FAC PAGE SET', 'fac-hosted-page-button'), array( $this, 'settings_field_page_set' ), FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN .'_settings', FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings' );
        	add_settings_field( FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_page_name', __( 'FAC PAGE NAME', 'fac-hosted-page-button'), array( $this, 'settings_field_page_name' ), FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN .'_settings', FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings' );
        	add_settings_field( FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_test_mode', __( 'FAC TEST MODE', 'fac-hosted-page-button' ), array( $this, 'settings_field_test_mode' ), FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN .'_settings', FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings' );
		}
		/**
		 * Section description
		 *
		 * @return Html
		 */
		public function section_cb() {

			echo '<p class="description">' . __( 'Setup First Atlantic merchant user account configurations', 'fac-hosted-page-button' ) . '</p>';
		}
		/**
		 * The merchant  account id 
		 * @return the input Html
		 */
		public function settings_field_merchant_id() {

			//Choose any one from input, textarea, select or checkbox
			
			printf('<input type="text" class="medium-text" name="%s_settings[merchant_id]" id="%s_merchant_id" value="%s" placeholder="%s" required /><p class="description" id="tagline-description">The merchant account ID.</p>',
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   get_option(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings')['merchant_id'] ?? '123456',
                   __( 'Enter Value',  'fac-hosted-page-button' )
                 );
		}
    	/**
		 * The merchant account password
		 * @return the input Html
		 */
		public function settings_field_merchant_secret() {

			//Choose any one from input, textarea, select or checkbox
			
			printf('<input type="text" class="medium-text" name="%s_settings[merchant_secret]" id="%s_merchant_secret" value="%s" placeholder="%s" required /><p class="description" id="tagline-description">The merchant account secret.</p>',
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   get_option(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings')['merchant_secret'] ?? 'abcdefg',
                   __( 'Enter Value',  'fac-hosted-page-button')
                 );
		}
    	/**
		 * The merchant hosted page page set id
		 * @return the input Html
		 */
		public function settings_field_page_set() {

			//Choose any one from input, textarea, select or checkbox
			
			printf('<input type="text" class="medium-text" name="%s_settings[page_set]" id="%s_page_set" value="%s" placeholder="%s" required /><p class="description" id="tagline-description">The merchant account configured hosted page\'s page set.</p>',
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   get_option(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings')['page_set'] ?? '',
                   __( 'Enter Value',  'fac-hosted-page-button' )
                 );
		}
    	/**
		 * The merchant account hosted page page name
		 * @return the input Html
		 */
		public function settings_field_page_name() {

			//Choose any one from input, textarea, select or checkbox
			
			printf('<input type="text" class="medium-text" name="%s_settings[page_name]" id="%s_page_name" value="%s" placeholder="%s" required /><p class="description" id="tagline-description">The merchant account configured hosted page\'s page name.</p>',
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   get_option(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings')['page_name'] ?? '',
                   __( 'Enter Value',  'fac-hosted-page-button' )
                 );
		}
    	/**
		 * Enables/ Disables plugin test mode
		 * @return the input Html
		 */
		public function settings_field_test_mode() {

			//Choose any one from input, textarea, select or checkbox
			$opt = get_option(FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN . '_settings')['test_mode'] ?? false;
			printf('<input type="checkbox" name="%s_settings[test_mode]" id="%s_settings_test_mode" value="true" %s><label for="%s_settings_test_mode"></label><p class="description" id="tagline-description">Enable test mode?</p>',
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN, 
                   $opt  ? 'checked' : '',
                   FAC_HOSTED_PAGE_BUTTON_TEXT_DOMAIN
                 );
		}
    
    	public function sanitize_settings($input)
        {
        	$input = array_filter($input);
        	$input = array_map('sanitize_text_field', $input);
        	return $input;
        }
	}
} ?>
