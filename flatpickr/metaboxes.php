<?php
/**
 * FlatPickr Metabox
 */

if ( ! class_exists( 'FlatPickr_Meta' ) ) {

	/**
	* Main ButterBean class.
	*/
	final class FlatPickr_Meta {

		/**
		 * Sets up initial actions.
		 */
		private function setup_actions() {
			add_action( 'butterbean_register', array( $this, 'register' ), 10, 2 );
		}

		/**
		 * Registers managers, sections, controls, and settings.
		 */
		public function register( $butterbean, $post_type ) {

			if ( 'page' !== $post_type && 'post' !== $post_type )
				return;

			$butterbean->register_manager(
				'bbs_event_info',
				array(
				'label'     => 'Event Info',
				'post_type' => array( 'post', 'page' ),
				'context'   => 'normal',
				'priority'  => 'high'
				)
			);

			$manager = $butterbean->get_manager( 'bbs_event_info' );

			$manager->register_section(
				'bbs_flatpickr_fields',
				array(
					'label' => 'Date',
					'icon'  => 'dashicons-calendar'
				)
			);

			$dir_path = bbs_get_dir_path();
			require_once $dir_path . 'flatpickr/class-control-flatpickr.php';

			$manager->register_control(
				new ButterBean_Control_FlatPickr(
					$manager,
					'bbs_flatpickr',
					array(
						'type'        => 'flatpickr',
						'section'     => 'bbs_flatpickr_fields',
						'label'       => 'Event Date',
						'description' => 'Example description.'
					)
				)
			);

			$manager->register_setting(
				'bbs_flatpickr',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);
		}
		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {

			static $instance = null;

			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}

			return $instance;
		}

		/**
		 * Constructor method.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function __construct() {}
	}

	FlatPickr_Meta::get_instance();
}
