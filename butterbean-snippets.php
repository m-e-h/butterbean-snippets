<?php

/*
Plugin Name: Butterbean Snippets
Plugin URI: https://github.com/meh/butterbean-snippets
Description: Snippets for ButterBean.
Version: 0.1
Author: Marty Helmick
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: butterbean-snippets
*/

add_action( 'admin_enqueue_scripts', 'bbs_scripts' );

$dir_path = bbs_get_dir_path();

require_once $dir_path . 'address/customizer.php';
require_once $dir_path . 'metaboxes.php';

function bbs_get_dir_path() {
	return plugin_dir_path( __FILE__ );
}

function bbs_get_dir_url() {
	return plugin_dir_url( __FILE__ );
}

function bbs_get_maps_api() {
	return get_theme_mod( 'google_maps_api' );
}

// Register Script
function bbs_scripts() {

	wp_register_script( 'geocomplete', bbs_get_dir_url() . 'address/address-autocomplete.js', false, false, true );
	wp_register_script( 'gplaces', 'https://maps.googleapis.com/maps/api/js?key='.bbs_get_maps_api().'&libraries=places&callback=initAutocomplete', array( 'geocomplete' ), false, true );
	wp_register_style( 'flatpickr', bbs_get_dir_url() . 'flatpickr/flatpickr.wp.css', false, false );
	wp_register_script( 'flatpickr', bbs_get_dir_url() . 'flatpickr/flatpickr.js', false, false, true );
	wp_register_style( 'select2', bbs_get_dir_url() . 'post-select/select2.min.css', false, false );
	wp_register_script( 'select2', bbs_get_dir_url() . 'post-select/select2.min.js', array( 'jquery' ), false, true );

	wp_add_inline_script ( 'flatpickr', bbs_get_flatpickr_script() );
	wp_add_inline_script ( 'select2', bbs_get_select2_script() );


}

/**
 * FlatPickr
 */
function bbs_get_flatpickr_script() {
	return "function domReady(callback) {
				document.readyState === 'interactive' ||
				document.readyState === 'complete' ? callback() : document.addEventListener('DOMContentLoaded', callback);
			};
			domReady(function () {
				document.querySelectorAll('.flatpickr-input').flatpickr();
			});";
}

/**
 * Select2
 */
function bbs_get_select2_script() {
	return "function domReady(callback) {
				document.readyState === 'interactive' ||
				document.readyState === 'complete' ? callback() : document.addEventListener('DOMContentLoaded', callback);
			};
			domReady(function () {
				jQuery('.bbs-select-multiple').select2();
			});";
}
