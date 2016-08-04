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
require_once $dir_path . 'address/metaboxes.php';
require_once $dir_path . 'oembed/class-control-oembed.php';

function bbs_get_dir_path() {
	return plugin_dir_path( __FILE__ );
}

function bbs_get_dir_url() {
	return plugin_dir_url( __FILE__ );
}

// Register Script
function bbs_scripts() {

	wp_register_style( 'leaflet_styles', 
	'https://cdn.jsdelivr.net/leaflet/1/leaflet.css',
	false, false
	);

	wp_register_script( 'address_scripts',
		'https://cdn.jsdelivr.net/places.js/1/places.min.js',
		false, false, false
	);

	wp_register_script( 'leaflet_js',
		'https://cdn.jsdelivr.net/leaflet/1/leaflet.js',
		false, false, false
	);

	wp_add_inline_script( 'address_scripts',
		'(function() {
		  var placesAutocomplete = places({
		    container: document.querySelector("#form-address"),
		    type: "address",
		    templates: {
		      value: function(suggestion) {
		        return suggestion.name;
		      }
		    }
		  });
		  placesAutocomplete.on("change", function resultSelected(e) {
		    document.querySelector("#form-city").value = e.suggestion.city || "";
		    document.querySelector("#form-zip").value = e.suggestion.postcode || "";
			document.querySelector("#form-geo").value = e.suggestion.latlng || "";
		  });
		})();'
	);
}
