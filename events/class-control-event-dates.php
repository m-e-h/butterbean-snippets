<?php
/**
* Address control class for ButterBean.
*/
if ( ! class_exists( 'ButterBean_Control' ) ) {
	return; }

class ButterBean_Control_FlatPickr extends ButterBean_Control {

	public $type = 'flatpickr';

	public $show_time = true;

	public $date_format = 'Y-m-d';

	public $min_date = '';

	public $max_date = '';

	public function to_json() {
		parent::to_json();

		$this->json['show_time'] = $this->show_time;

		$this->json['date_format'] = $this->date_format;

		$this->json['min_date'] = $this->min_date;

		$this->json['max_date'] = $this->max_date;

		$this->json['value'] = esc_html( $this->get_value() );
	}

	public function get_template() {

		wp_enqueue_style( 'flatpickr' );
		wp_enqueue_script( 'flatpickr' );
		wp_add_inline_script ( 'flatpickr', $this->bbs_get_flatpickr_script() );
		?>

		<div class="row">
			<p class="flatpickr input-group">
				<span class="butterbean-label">{{ data.label }}</span>
				<input type="text" id="{{ data.field_name }}" class="flatpickr-input" placeholder="Date" value="{{ data.value }}" name="{{ data.field_name }}" data-enable-time="{{ data.show_time }}" data-min-date="{{ data.min_date }}" data-date-format="{{ data.date_format }}">
			</p>
		</div>
		<?php }


	/**
	 * @return string
	 */
	public function bbs_get_flatpickr_script() {
		return "document.querySelectorAll('.flatpickr-input').flatpickr();";
	}
}
