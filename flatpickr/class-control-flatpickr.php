<?php
/**
* Address control class for ButterBean.
*/
if ( ! class_exists( 'ButterBean_Control' ) ) {
	return; }

class ButterBean_Control_FlatPickr extends ButterBean_Control {

	public $type = 'flatpickr';

	public $show_time = true;

	public function to_json() {
		parent::to_json();

		$this->json['show_time'] = $this->show_time;

		$this->json['value'] = esc_html( $this->get_value() );
	}

	public function get_template() {
		$field_name = get_field_name();
		wp_enqueue_style( 'flatpickr' );
		wp_enqueue_script( 'flatpickr' );
		wp_add_inline_script ( 'flatpickr', "document.getElementById('{$field_name}').flatpickr();" );
		?>

		<div class="row">
			<p class="flatpickr input-group">
				<span class="butterbean-label">{{ data.label }}</span>
				<input type="text" id="{{ data.field_name }}" class="flatpickr-input" placeholder="Date" value="{{ data.value }}" name="{{ data.field_name }}" data-enable-time=true>
			</p>
		</div>
		<?php }
}
