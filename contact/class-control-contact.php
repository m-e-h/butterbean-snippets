<?php
/**
 * Contact control class for ButterBean.
 */

if ( ! class_exists( 'ButterBean_Control' ) ) {
	return; }

class ButterBean_Control_Contact extends ButterBean_Control {

	public $type = 'contact';

	public function to_json() {
		parent::to_json();

		$this->json['phone'] = array(
			'label'      => 'Phone',
			'value'      => $this->get_value( 'phone' ),
			'field_name' => $this->get_field_name( 'phone' ),
		);

		$this->json['fax'] = array(
			'label'      => 'Fax',
			'value'      => $this->get_value( 'fax' ),
			'field_name' => $this->get_field_name( 'fax' ),
		);

		$this->json['email'] = array(
			'label'      => 'Email',
			'value'      => $this->get_value( 'email' ),
			'field_name' => $this->get_field_name( 'email' ),
		);

		$this->json['website'] = array(
			'label'      => 'Website',
			'value'      => $this->get_value( 'website' ),
			'field_name' => $this->get_field_name( 'website' ),
		);
	}

	public function get_template() {
	?>

		<div class="form-inline">
			<p class="form-group">
		        <label>
		            <span class="butterbean-label">{{ data.phone.label }}</span>
		            <input type="tel" value="{{ data.phone.value }}" name="{{ data.phone.field_name }}" />
		        </label>
			</p>
			<p class="form-group">
				<label>
		            <span class="butterbean-label">{{ data.fax.label }}</span>
		            <input type="text" value="{{ data.fax.value }}" name="{{ data.fax.field_name }}" />
		        </label>
			</p>
		</div>
		<div class="form-inline">
			<p class="form-group">
		        <label>
		            <span class="butterbean-label">{{ data.email.label }}</span>
		            <input type="email" value="{{ data.email.value }}" name="{{ data.email.field_name }}" />
		        </label>
			</p>
			<p class="form-group">
		        <label>
		            <span class="butterbean-label">{{ data.website.label }}</span>
		            <input type="url" value="{{ data.website.value }}" name="{{ data.website.field_name }}" />
		        </label>
			</p>
		</div>
    <?php }
}
