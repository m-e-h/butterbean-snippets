<?php
/**
 * Address Metabox
 */

if ( ! class_exists( 'Bbs_Events' ) ) {

	/**
	* Main ButterBean class.
	*/
	final class Bbs_Events {

		/**
		 * Sets up initial actions.
		 */
		private function setup_actions() {
			add_action( 'butterbean_register', array( $this, 'register' ), 10, 2 );
			add_filter( 'be_events_manager_metabox_override', '__return_true' );
		}

		/**
		 * Registers managers, sections, controls, and settings.
		 */
		public function register( $butterbean, $post_type ) {

			if ( 'events' !== $post_type && 'post' !== $post_type ) {
				return; }

			$dir_path = bbs_get_dir_path();

			// require_once $dir_path . 'settings/class-setting-value-array.php';
			require_once $dir_path . 'flatpickr/class-control-flatpickr.php';
			require_once $dir_path . 'address/class-control-address.php';
			require_once $dir_path . 'contact/class-control-contact.php';
			require_once $dir_path . 'oembed/class-control-oembed.php';
			require_once $dir_path . 'post-select/class-control-post-select.php';

			$butterbean->register_manager(
				'bbs_events',
				array(
				'label'     => 'Event Info',
				'post_type' => array( 'events', 'post' ),
				'context'   => 'normal',
				'priority'  => 'high',
				)
			);

			$manager = $butterbean->get_manager( 'bbs_events' );

			$manager->register_section(
				'be_date_fields',
				array(
					'label' => 'Date',
					'icon'  => 'dashicons-calendar',
				)
			);

			$manager->register_control(
				'be_event_allday',
				array(
					'type'        => 'checkbox',
					'section'     => 'be_date_fields',
					'label'       => 'All day event',
					'description' => 'Example description.',
				)
			);

			$manager->register_control(
				new ButterBean_Control_FlatPickr(
					$manager,
					'be_event_start',
					array(
						'type'        => 'flatpickr',
						'section'     => 'be_date_fields',
						'label'       => 'Start Date',
						'description' => 'Example description.',
					)
				)
			);

			$manager->register_control(
				new ButterBean_Control_FlatPickr(
					$manager,
					'be_event_end',
					array(
						'type'        	=> 'flatpickr',
						'section'     	=> 'be_date_fields',
						'label'       	=> 'End Date',
					)
				)
			);

			$manager->register_section(
				'be_location_fields',
				array(
				'label' => 'Location',
				'icon'  => 'dashicons-location-alt',
				)
			);

			$manager->register_control(
				new ButterBean_Control_Address(
					$manager,
					'be_location',
					array(
						'type'        => 'address',
						'section'     => 'be_location_fields',
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

			$manager->register_section(
				'bbs_contact_fields',
				array(
				'label' => 'Contact',
				'icon'  => 'dashicons-format-status',
				)
			);

			$manager->register_control(
				new ButterBean_Control_Contact(
					$manager,
					'bbs_contact',
					array(
					'type'        => 'contact',
					'section'     => 'bbs_contact_fields',
					'settings' => array(
						'phone' 	=> 'bbs_phone_number',
						'fax'  		=> 'bbs_fax',
						'email'  	=> 'bbs_email',
						'website' 	=> 'bbs_website',
					),
					)
				)
			);

			$manager->register_section(
				'bbs_oembed_fields',
				array(
				'label' => 'Video',
				'icon'  => 'dashicons-video-alt3',
				)
			);

			$manager->register_control(
				new ButterBean_Control_Oembed(
					$manager,
					'bbs_oembed',
					array(
					'type'        => 'oembed',
					'section'     => 'bbs_oembed_fields',
					'label'       => 'Event Video',
					)
				)
			);

			$manager->register_section(
				'bbs_post_select_fields',
				array(
					'label' => 'Post Select',
					'icon'  => 'dashicons-welcome-add-page',
				)
			);

			$manager->register_control(
				new ButterBean_Control_PostSelect(
					$manager,
					'bbs_attached_post',
					array(
						'type'        => 'post_select',
						'section'     => 'bbs_post_select_fields',
						'label'       => 'Select Post',
						'choices'     => array(
							''         => '',
							'choice_x' => 'Choice X',
							'choice_y' => 'Choice Y',
							'choice_z' => 'Choice Z',
						),
					)
				)
			);

			$manager->register_setting(
				new ButterBean_Setting_Array(
					$manager,
					'bbs_attached_post',
					array( 'sanitize_callback' => 'sanitize_key' )
				)
			);

			$manager->register_setting(
				'bbs_oembed',
				array( 'sanitize_callback' => 'esc_url' )
			);

			$manager->register_setting(
				'bbs_phone_number',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);
			$manager->register_setting(
				'bbs_fax',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);
			$manager->register_setting(
				'bbs_email',
				array( 'sanitize_callback' => 'sanitize_email' )
			);
			$manager->register_setting(
				'bbs_website',
				array( 'sanitize_callback' => 'esc_url' )
			);

			$manager->register_setting(
				'be_event_start',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);

			$manager->register_setting(
				'be_event_end',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);

			$manager->register_setting(
				'be_event_allday',
				array( 'sanitize_callback' => 'butterbean_validate_boolean' )
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

	Bbs_Events::get_instance();
}
