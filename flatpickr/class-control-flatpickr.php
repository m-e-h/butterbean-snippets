<?php
/**
* Address control class for ButterBean.
*/
if ( ! class_exists( 'ButterBean_Control' ) ) {
	return; }

class ButterBean_Control_FlatPickr extends ButterBean_Control {

	public $type = 'flatpickr';

	public function to_json() {
		parent::to_json();

		$this->json['value'] = esc_html( $this->get_value() );
	}

	public function get_template() {
		wp_enqueue_style( 'flatpickr' );
		wp_enqueue_script( 'flatpickr' ); ?>

		<div class="row">
			<div class="u-1of1 u-p1">
				<input type="text" id="flatpickr" class="flatpickr-input" placeholder="Date" value="{{ data.value }}" name="{{ data.field_name }}" data-enable-time=true>
			</div>
		</div>
		<?php }
}
