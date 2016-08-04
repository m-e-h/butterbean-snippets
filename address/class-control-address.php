<?php
/**
* Address control class for ButterBean.
*/

if ( ! class_exists( 'ButterBean_Control' ) )
	return;

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
		wp_enqueue_script( 'address_scripts' );
		wp_enqueue_script( 'leaflet_js' );
		wp_enqueue_style( 'leaflet_styles' );
		?>

		<p class="form-group">
			<label>
				<span class="butterbean-label">{{ data.street.label }}</span>
				<input type="text" id="form-address" value="{{ data.street.value }}" name="{{ data.street.field_name }}" />
			</label>
		</p>

		<div class="form-inline">
			<p class="form-group">
				<label>
					<span class="butterbean-label">{{ data.city.label }}</span>
					<input type="text" id="form-city" value="{{ data.city.value }}" name="{{ data.city.field_name }}" />
				</label>
			</p>
			<p class="form-group">
				<label>
					<span class="butterbean-label">{{ data.state.label }}</span>
					<input type="text" id="form-state" maxlength="2" value="{{ data.state.value }}" name="{{ data.state.field_name }}" />
				</label>
			</p>
			<p class="form-group">
				<label>
					<span class="butterbean-label">{{ data.zip.label }}</span>
					<input type="text" id="form-zip" pattern="[0-9]*" maxlength="5" value="{{ data.zip.value }}" name="{{ data.zip.field_name }}" />
				</label>
			</p>
		</div>

		<div class="row">

			<div id="map_canvas"></div>

			<p class="form-group">
				<label>
					<span class="butterbean-label">{{ data.lat_lon.label }}</span>
					<input id="form-geo" name="{{ data.lat_lon.field_name }}" type="text" value="{{ data.lat_lon.value }}">
				</label>
			</p>
		</div>
		<?php }
}
