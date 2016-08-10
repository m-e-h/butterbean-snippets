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

			$manager->register_control(
				'event_allday',
				array(
					'type'        => 'checkbox',
					'section'     => 'bbs_flatpickr_fields',
					'label'       => 'All day event',
					'description' => 'Example description.'
				)
			);

			$dir_path = bbs_get_dir_path();
			require_once $dir_path . 'flatpickr/class-control-flatpickr.php';

			$manager->register_control(
				new ButterBean_Control_FlatPickr(
					$manager,
					'event_start',
					array(
						'type'        => 'flatpickr',
						'section'     => 'bbs_flatpickr_fields',
						'label'       => 'Start Date',
						'description' => 'Example description.'
					)
				)
			);

			$manager->register_control(
				new ButterBean_Control_FlatPickr(
					$manager,
					'event_end',
					array(
						'type'        	=> 'flatpickr',
						'section'     	=> 'bbs_flatpickr_fields',
						'label'       	=> 'End Date',
						'date_format'	=> 'm/d/Y',
						'show_time'     => '',
						'min_date'     	=> '2016-08-12'
					)
				)
			);

			$manager->register_setting(
				'event_start',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);

			$manager->register_setting(
				'event_end',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);

			$manager->register_setting(
				'event_allday',
				array( 'sanitize_callback' => 'butterbean_validate_boolean' )
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
