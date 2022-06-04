<?php
namespace WPFac\HostedPage\Button\Src;

use WP_WIDGET as WP_WIDGET;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Widget class
 *
 * @author     Kendall Arneaud
 * @package    fac-hosted-page-button
 */
if ( ! class_exists( 'Widget' ) ) {

	final class Widget extends WP_WIDGET {


		/**
		 * Add widget
		 *
		 * @return Void
		 */
		public function __construct() {

			$widget_ops = array(
							'classname' => 'plugin_widget',
							'description' => __( 'Plugin widget', 'fac-hosted-page-button' ),
							);
			parent::__construct( 'my_widget_id', __( 'Plugin widget', 'fac-hosted-page-button' ), $widget_ops );
		}


		/**
		 * Outputs the content of the widget for front end
		 *
		 * @param Array $args
		 * @param Array $instance
		 *
		 * @return Html
		 */
		public function widget( $args, $instance ) {

			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}
			echo esc_html__( 'Hello, World!', 'fac-hosted-page-button' );
			echo $args['after_widget'];
		}


		/**
		 * Outputs the options form on admin
		 *
		 * @param Array $instance
		 *
		 * @return Html
		 */
		public function form( $instance ) {

			$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Internal Link Master', 'fac-hosted-page-button' ); ?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'fac-hosted-page-button' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
		<?php
		}


		/**
		 * Processing widget options on save
		 *
		 * @param Array $new_instance
		 * @param Array $old_instance
		 *
		 * @return Array
		 */
		public function update( $new_instance, $old_instance ) {

			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '' );
			return $instance;
		}
	}
} ?>
