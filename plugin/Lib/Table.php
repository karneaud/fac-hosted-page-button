<?php
namespace WPFac\HostedPage\Button\Lib;

/**
 * Implimentation of WordPress inbuilt functions for creating an extension of a default table class.
 *
 * $my_plugin_name_table = new FAC_HOSTED_PAGE_BUTTON_TABLE();
 * $my_plugin_name_table->prepare_items();
 * $my_plugin_name_table->display();
 *
 * @author     Kendall Arneaud
 * @package    fac-hosted-page-button
 */
if ( ! class_exists( 'Table' ) ) {

	if ( ! class_exists( 'WP_List_Table' ) ) {
    	require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	}

	final class Table extends WP_List_Table {


		/**
		 * Instantiate the table
		 *
		 * @return Void
		 */
		public function __construct() {

			parent::__construct( [
				'singular' => __( 'Name', 'fac-hosted-page-button' ),
				'plural'   => __( 'Names', 'fac-hosted-page-button' ),
				'ajax'     => false,
			] );
		}


		/**
		 * Fetch the data using custom named method function
		 *
		 * @return Array
		 */
		public static function get_Table( $per_page = 5, $page_number = 1 ) {

			global $wpdb;

			//Take pivotal from URL
			$link = isset( $_GET['link'] ) ? sanitize_url( $_GET['link']) : 'link' ;

			//Build the db query base
			$sql = "SELECT * FROM {$wpdb->prefix}wordpress_table";
			$sql .= " QUERIES with $link'";

			//Set filters in the query using $_REQUEST
			if ( ! empty( $_REQUEST['orderby'] ) ) {
				$sql .= ' ORDER BY ' . sanitize_sql_orderby( $_REQUEST['orderby'] );
				$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . sanitize_text_field( $_REQUEST['order'] ) : ' ASC';
			}
			$sql .= " LIMIT $per_page";
			$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

			//get the data from database
			$result = $wpdb->get_results( $sql, 'ARRAY_A' );

			return $result;
		}


		/**
		 * Delete individual data
		 *
		 * @return Void
		 */
		public static function delete_url( $id ) {

			global $wpdb;

			$wpdb->delete( "{$wpdb->prefix}wordpress_table", array( 'ID' => $id ), array( '%s' ) );
		}


		/**
		 * If there is no data to show
		 *
		 * @return String
		 */
		public function no_items() {

			_e( 'No Items Added yet.', 'fac-hosted-page-button' );
		}


		/**
		 * How many rows are present there
		 *
		 * @return Int
		 */
		public static function record_count() {

			global $wpdb;

			//Take pivotal from URL
			$link = isset( $_GET['link'] ) sanitize_url(? $_GET['link']) : 'link' );

			//Build the db query base
			$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}wordpress_table";
			$sql .= " QUERIES with $link'";

			return $wpdb->get_var( $sql );
		}


		/**
		 * Display columns content
		 *
		 * @return Html
		 */
		public function column_name( $item ) {

			$delete_nonce = wp_create_nonce( 'delete_url' );
			$title = sprintf( '<strong>%s</strong>', $item['item_name'] );

			//Change the page instruction where you want to show it
			$actions = array(
					'delete' => sprintf( '<a href="?page=%s&action=%s&instruction=%s&_wpnonce=%s">%s</a>', sanitize_text_field( $_REQUEST['page'] ), 'delete', absint( $item['ID'] ), $delete_nonce, __( 'Delete', 'fac-hosted-page-button' ) )
					);

			return $title . $this->row_actions( $actions );
		}


		/**
		 * set coulmns name
		 *
		 * @return Html
		 */
		public function column_default( $item, $column_name ) {

			switch ( $column_name ) {

				case 'name':
					//This is the first column
					return $this->column_name( $item );
				case 'caseOne':
				case 'caseTwo':
				case 'caseThree':
					return $item[ $column_name ];

				default:

					//Show the whole array for troubleshooting purposes
					return print_r( $item, true );
			}
		}


		/**
		 * Set checkboxes to delete
		 *
		 * @return Html
		 */
		public function column_cb( $item ) {

			return sprintf( '<input type="checkbox" name="bulk-select[]" value="%s" />', $item['ID'] );
		}


		/**
		 * Columns callback
		 *
		 * @return Array
		 */
		public function get_columns() {

			$columns = array(
							'cb'		=> '<input type="checkbox" />',
							'name'	=> __( 'Name', 'fac-hosted-page-button' ),
							'caseOne'	=> __( 'Case One', 'fac-hosted-page-button' ),
							'caseTwo'	=> __( 'Case Two', 'fac-hosted-page-button' ),
							'caseThree'	=> __( 'Case Three', 'fac-hosted-page-button' ),
						);

			return $columns;
		}


		/**
		 * Decide columns to be sortable by array input
		 *
		 * @return Array
		 */
		public function get_sortable_columns() {

			$sortable_columns = array(
				'name' => array( 'name', true ),
				'caseOne' => array( 'caseOne', false ),
				'caseTwo' => array( 'caseTwo', false ),
			);

			return $sortable_columns;
		}


		/**
		 * Determine bulk actions in the table dropdown
		 *
		 * @return Array
		 */
		public function get_bulk_actions() {

			$actions = array( 'bulk-delete' => 'Delete'	);

			return $actions;
		}


		/**
		 * Prapare the display variables for screen options
		 *
		 * @return Void
		 */
		public function prepare_items() {

			$this->_column_headers = $this->get_column_info();

			/** Process bulk action */
			$this->process_bulk_action();
			$per_page     = $this->get_items_per_page( 'option_name_per_page', 5 );
			$current_page = $this->get_pagenum();
			$total_items  = self::record_count();
			$this->_column_headers = [
    			$this->get_columns(),
    			[], // hidden columns
    			$this->get_sortable_columns(),
    			$this->get_primary_column_name(),
			];
			$this->set_pagination_args( array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			) );

			$this->items = self::get_Table( $per_page, $current_page );
		}


		/**
		 * Process bulk action
		 *
		 * @return Void
		 */
		public function process_bulk_action() {

			//Detect when a bulk action is being triggered...
			if ( 'delete' === $this->current_action() ) {

				//In our file that handles the request, verify the nonce.
				$nonce = sanitize_text_field( $_REQUEST['_wpnonce'] );

				if ( ! wp_verify_nonce( $nonce, 'delete_url' ) ) {
					die( 'Go get a live script kiddies' );
				} else {
					self::delete_url( absint( $_GET['instruction'] ) ); //Remember the instruction param from column_name method
				}
			}

			//If the delete bulk action is triggered
			if ( isset( $_POST['action'] ) ) {
				if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) ) {
					$delete_ids = sanitize_text_field( $_POST['bulk-select'] );
					foreach ( $delete_ids as $id ) {
						self::delete_url( $id );
					}
				}
			}
		}
	}
} ?>
