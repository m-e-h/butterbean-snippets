<?php
/**
 * oEmbed control class for ButterBean.
 */

if ( ! class_exists( 'ButterBean_Control' ) ) {
	return;
}

/**
 * Textarea control class.
 *
 * @since  1.0.0
 * @access public
 */
class ButterBean_Control_PostSelect extends ButterBean_Control {


	/**
	 * The type of control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'post_select';

	/**
	 * Custom field name.  We need to add `[]` at the end of the name so that it
	 * accepts an array of values.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function get_field_name( $setting = 'default' ) {

		$name = parent::get_field_name( $setting );

		return sprintf( '%s[]', $name );
	}

	/**
	 * Adds custom data to the json array. This data is passed to the Underscore template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	 public function to_json() {

 		parent::to_json();

		$this->json['choices'] = $this->choices;

 		$this->json['value'] = (array) $this->get_value();

 	}

	public function get_template() {

		wp_enqueue_style( 'select2' );
		wp_enqueue_script( 'select2' );
		?>

		<div class="row">
			<label>

				<# if ( data.label ) { #>
					<span class="butterbean-label">{{ data.label }}</span>
				<# } #>

				<# if ( data.description ) { #>
					<span class="butterbean-description">{{{ data.description }}}</span>
				<# } #>

				<select {{{ data.attr }}} multiple="multiple" style="width: 50%" class="bbs-select-multiple">

					<# _.each( data.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( -1 !== _.indexOf( data.value, choice ) ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</label>
		</div>
		<?php }
}
