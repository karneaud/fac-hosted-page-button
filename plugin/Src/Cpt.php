<?php
namespace WPFac\HostedPage\Button\Src;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom post type class
 *
 * @author     Kendall Arneaud
 * @package    fac-hosted-page-button
 */
if ( ! class_exists( 'Cpt' ) ) {

	class Cpt {

		/**
		 * @var Array
		 */
		private $labels;

		/**
		 * @var Array
		 */
		private $args;

		/**
		 * @var String
		 */
		private static $menu_svg = '';


		/**
		 * Integrate the shortcode
		 *
		 * @return Void
		 */
		public function __construct() {

			$this->labels = $this->labels();
			$this->args = $this->args( $this->labels );

			$this->taxonomy_labels = $this->taxonomy_labels();
			$this->taxonomy_args = $this->taxonomy_args( $this->taxonomy_labels );

			//register_post_type( 'cpt_name', $this->args );
			//add_filter( 'post_updated_messages', array( $this, 'group_updated_messages' ) );

			//register_taxonomy( 'custom_tax', array( 'cpt_name' ), $this->taxonomy_args );
		}


		/**
		 * Define the labels
		 *
		 * @return Array
		 */
		public function labels() {

	      $labels = array(
	        'name'                => _x( '', 'Post Type General Name', 'fac-hosted-page-button' ),
	        'singular_name'       => _x( '', 'Post Type Singular Name', 'fac-hosted-page-button' ),
	        'menu_name'           => __( '', 'fac-hosted-page-button' ),
	        'parent_item_colon'   => __( '', 'fac-hosted-page-button' ),
	        'all_items'           => __( '', 'fac-hosted-page-button' ),
	        'view_item'           => __( '', 'fac-hosted-page-button' ),
	        'add_new_item'        => __( '', 'fac-hosted-page-button' ),
	        'add_new'             => __( '', 'fac-hosted-page-button' ),
	        'edit_item'           => __( '', 'fac-hosted-page-button' ),
	        'update_item'         => __( '', 'fac-hosted-page-button' ),
	        'search_items'        => __( '', 'fac-hosted-page-button' ),
	        'not_found'           => __( '', 'fac-hosted-page-button' ),
	        'not_found_in_trash'  => __( '', 'fac-hosted-page-button' ),
	      );

	      return $labels;
	    }


		/**
		 * Define the arguments for custom post type
		 *
		 * @param Array $labels
		 *
		 * @return Array
		 */
	    public function args( $labels ) {

	      $args = array(
	          'label'               => __( '', 'fac-hosted-page-button' ),
	          'description'         => __( '', 'fac-hosted-page-button' ),
	          'labels'              => $labels,
	          'supports'            => array( 'title', 'editor', 'thumbnail' ),
	          'taxonomies'          => array( 'custom_tax', 'post_tag' ),
	          'hierarchical'        => true,
	          'public'              => true,
			  'rewrite'			  	=> array( 'slug' => 'slug_name' ),
	          'show_ui'             => true,
	          'show_in_menu'        => true,
			  'menu_icon' 			=> 'data:image/svg+xml;base64,' . self::$menu_svg,
	          'show_in_nav_menus'   => true,
	          'show_in_admin_bar'   => true,
	          'menu_position'       => 5,
	          'can_export'          => true,
	          'has_archive'         => true,
	          'exclude_from_search' => false,
	          'publicly_queryable'  => true,
	          'capability_type'     => 'post',
	          'show_in_rest'        => true,
			  //Controls WP REST API behaviour
			  'rest_controller_class' => 'WP_REST_Posts_Controller',
	      );

	      return $args;
	    }


		/**
	 	 * Modify the cpt messages
		 *
		 * @param Array $messages
		 *
		 * @return Array
	 	 */
		 public function cpt_updated_messages( $messages ) {

			 global $post, $post_ID;

			 $messages['cpt_name'] = array(
				 0 => '',
				 1 => sprintf( __( 'CPT updated. <a href="%s">View CPT</a>', 'fac-hosted-page-button' ), esc_url( get_permalink( $post_ID ) ) ),
				 2 => __( 'field updated.', 'fac-hosted-page-button' ),
				 3 => __( 'field deleted.', 'fac-hosted-page-button' ),
				 4 => __( 'CPT updated.', 'fac-hosted-page-button' ),
				 5 => ( isset( $_GET['revision'] ) ? sprintf( __( 'CPT restored to revision from %s', 'fac-hosted-page-button' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false ),
				 6 => sprintf( __( 'CPT published. <a href="%s">View Cpt</a>', 'fac-hosted-page-button' ), esc_url( get_permalink( $post_ID ) ) ),
				 7 => __( 'CPT saved.', 'fac-hosted-page-button' ),
				 8 => sprintf( __( 'CPT submitted. <a target="_blank" href="%s">Preview cpt</a>', 'fac-hosted-page-button' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
				 9 => sprintf( __( 'CPT scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview cpt</a>', 'fac-hosted-page-button' ), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
				 10 => sprintf( __( 'CPT draft updated. <a target="_blank" href="%s">Preview cpt</a>', 'fac-hosted-page-button' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			 );

			 return $messages;
		 }


		 /**
 	 	  * Taxonomy labels
 		  *
 		  * @return Array
 	 	  */
		 public function taxonomy_labels() {

			 $labels = array(
			     'name'              => _x( 'Taxonomy', 'taxonomy general name', 'fac-hosted-page-button' ),
			     'singular_name'     => _x( 'Taxonomy', 'taxonomy singular name', 'fac-hosted-page-button' ),
			     'search_items'      => __( 'Search Taxonomy', 'fac-hosted-page-button' ),
			     'all_items'         => __( 'All Taxonomies', 'fac-hosted-page-button' ),
			     'parent_item'       => __( 'Parent Taxonomy', 'fac-hosted-page-button' ),
			     'parent_item_colon' => __( 'Parent Taxonomy:', 'fac-hosted-page-button' ),
			     'edit_item'         => __( 'Edit Taxonomy', 'fac-hosted-page-button' ),
			     'update_item'       => __( 'Update Taxonomy', 'fac-hosted-page-button' ),
			     'add_new_item'      => __( 'Add New Taxonomy', 'fac-hosted-page-button' ),
			     'new_item_name'     => __( 'New Taxonomy Name', 'fac-hosted-page-button' ),
			     'menu_name'         => __( 'Taxonomy', 'fac-hosted-page-button' ),
			);

			return $labels;
		 }


		 /**
 		 * Define the arguments for custom taxonomy
 		 *
 		 * @param Array $labels
 		 *
 		 * @return Array
 		 */
 	    public function taxonomy_args( $labels ) {

 	      $args = array(
			  	'hierarchical'          => true,
    			'labels'                => $labels,
    			'show_ui'               => true,
    			'show_admin_column'     => true,
    			'query_var'             => true,
    			'rewrite'               => array( 'slug' => 'custom_tax' ),
    			'show_in_rest'          => true,
    			'rest_base'             => 'custom_tax',
				//Controls WP REST API behaviour
    			'rest_controller_class' => 'WP_REST_Terms_Controller',
 	      );

 	      return $args;
 	    }
	}
}
