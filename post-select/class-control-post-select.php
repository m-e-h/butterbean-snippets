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
	 * The post type to select posts from.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $post_type = '';
	/**
	 * Returns the HTML field name for the control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $setting
	 * @return array
	 */
	public function get_field_name( $setting = 'default' ) {
		return 'post_select';
	}
	/**
	 * Get the value for the setting.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $setting
	 * @return mixed
	 */
	public function get_value( $setting = 'default' ) {
		return get_post( $this->manager->post_id )->post_select;
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
		$_post = get_post( $this->manager->post_id );
		$posts = get_posts(
			array(
				'post_type'      => $this->post_type ? $this->post_type : get_post_type( $this->manager->post_id ),
				'post_status'    => 'any',
				'post__not_in'   => array( $this->manager->post_id ),
				'posts_per_page' => -1,
				// 'post_parent'    => 0,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => array( 'ID', 'post_title' )
			)
		);
		$this->json['choices'] = array( array( 'value' => 0, 'label' => '' ) );
		foreach ( $posts as $post )
			$this->json['choices'][] = array( 'value' => $post->ID, 'label' => $post->post_title );
	}

	public function get_template() {

		wp_enqueue_style( 'select2' );
		wp_enqueue_script( 'select2' );
		wp_add_inline_script ( 'select2', $this->bbs_get_select2_script() );
		?>

		<div class="row">
			<label for="{{ data.field_name }}">
				<# if ( data.label ) { #>
					<span class="butterbean-label">{{ data.label }}</span>
				<# } #>

				<select name="{{ data.field_name }}" id="{{ data.field_name }}" class="bbs-select-multiple" multiple="multiple">

					<# _.each( data.choices, function( choice ) { #>
						<option value="{{ choice.value }}" <# if ( choice.value === data.value ) { #> selected="selected" <# } #>>{{ choice.label }}</option>
					<# } ) #>

				</select>

				<# if ( data.description ) { #>
					<span class="butterbean-description">{{{ data.description }}}</span>
				<# } #>
			</label>
		</div>
		<?php }


	/**
	 * @return string
	 */
	public function bbs_get_select2_script() {
		return "$(".bbs-select-multiple").select2();";
	}
}
