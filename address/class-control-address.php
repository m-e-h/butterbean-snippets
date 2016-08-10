<?php
/**
 * Address control class for ButterBean.
 */

if ( ! class_exists( 'ButterBean_Control' ) ) {
	return; }

class ButterBean_Control_Address extends ButterBean_Control {

	public $type = 'address';

	public function to_json() {
		parent::to_json();

		$this->json['street'] = array(
			'label'      => 'Street',
			'value'      => $this->get_value( 'street' ),
			'field_name' => $this->get_field_name( 'street' ),
		);

		$this->json['city'] = array(
			'label'      => 'City',
			'value'      => $this->get_value( 'city' ),
			'field_name' => $this->get_field_name( 'city' ),
		);

		$this->json['state'] = array(
			'label'      => 'State',
			'value'      => $this->get_value( 'state' ),
			'field_name' => $this->get_field_name( 'state' ),
		);

		$this->json['zip'] = array(
			'label'      => 'ZIP Code',
			'value'      => $this->get_value( 'zip_code' ),
			'field_name' => $this->get_field_name( 'zip_code' ),
		);

		$this->json['lat_lon'] = array(
			'label'      => 'Coordinates',
			'value'      => $this->get_value( 'lat_lon' ),
			'field_name' => $this->get_field_name( 'lat_lon' ),
		);
	}

	public function get_template() {
		wp_enqueue_script( 'gplaces' ); ?>

		<?php if ( get_theme_mod( 'google_maps_api' ) ) : ?>
			<p class="form-group">
				<input id="autocomplete" class="widefat" placeholder="Begin typing your address" onFocus="geolocate()" type="text"></input>
			</p>
		<?php else : ?>
			<p><code><span class="dashicons dashicons-info"></span> To use the address autofill and geolocation features, enter your Google Maps API key in the "Owner Info and APIs" Customizer control.</code></p>
		<?php endif; ?>

		<p class="form-group">
			<label>
				<span class="butterbean-label">{{ data.street.label }}</span>
				<input type="text" id="address1" value="{{ data.street.value }}" name="{{ data.street.field_name }}" />
			</label>
		</p>

		<div class="form-inline">
			<p class="form-group">
				<label>
					<span class="butterbean-label">{{ data.city.label }}</span>
					<input type="text" id="locality" value="{{ data.city.value }}" name="{{ data.city.field_name }}" />
				</label>
			</p>
			<p class="form-group">
				<label>
					<span class="butterbean-label">{{ data.state.label }}</span>
					<input type="text" id="administrative_area_level_1" maxlength="2" value="{{ data.state.value }}" name="{{ data.state.field_name }}" />
				</label>
			</p>
			<p class="form-group">
				<label>
					<span class="butterbean-label">{{ data.zip.label }}</span>
					<input type="text" id="postal_code" pattern="[0-9]*" maxlength="5" value="{{ data.zip.value }}" name="{{ data.zip.field_name }}" />
				</label>
			</p>
		</div>

		<div class="row">

			<iframe width="100%" height="350" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/streetview?location={{ data.lat_lon.value }}&key=<?php echo bbs_get_maps_api(); ?>"></iframe>

			<p class="form-group">
				<label>
					<span class="butterbean-label">{{ data.lat_lon.label }}</span>
					<input id="geolocation" name="{{ data.lat_lon.field_name }}" type="text" placeholder="geo-coordinates" class="u-1of1" value="{{ data.lat_lon.value }}">
				</label>
			</p>
		</div>
		<?php }
}
