<?php
/**
 * Address Metabox
 */

if ( ! class_exists( 'Address_Meta' ) ) {

	/**
	* Main ButterBean class.
	*/
	final class Address_Meta {

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
				'bbs_location_info',
				array(
				'label'     => 'Location Info',
				'post_type' => array( 'post', 'page' ),
				'context'   => 'normal',
				'priority'  => 'high'
				)
			);

			$manager = $butterbean->get_manager( 'bbs_location_info' );

			$manager->register_section(
				'bbs_address_fields',
				array(
				'label' => 'Location',
				'icon'  => 'dashicons-location-alt',
				)
			);

			$dir_path = bbs_get_dir_path();
			require_once $dir_path . 'address/class-control-address.php';
			
			$manager->register_control(
				new ButterBean_Control_Address(
					$manager,
					'bbs_address',
					array(
						'type'        => 'address',
						'section'     => 'bbs_address_fields',
						'settings' => array(
							'street' 	=> 'street',
							'city'  	=> 'city',
							'state'  	=> 'state',
							'zip_code' 	=> 'zip',
							'lat_lon' 	=> 'geo_coordinates',
						),
					)
				)
			);

			$manager->register_setting(
				'street',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);
			$manager->register_setting(
				'city',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);
			$manager->register_setting(
				'state',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);
			$manager->register_setting(
				'zip',
				array( 'sanitize_callback' => 'absint' )
			);

			$manager->register_setting(
				'geo_coordinates',
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

	Address_Meta::get_instance();
}
