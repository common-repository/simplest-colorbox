<?php
/*
 *
 * Plugin Name: Simplest Colorbox
 * Plugin URI: http://picomol.de/simplest-colorbox/
 * Description: A configuration-free colorbox plugin
 * Author: Valentin
 * Version: 1.0
 * Author URI: http://picomol.de/
 * License: GPLv3
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * This plugin bases on "Simple Colorbox" by Ryan Hellyer: http://wordpress.org/extend/plugins/simple-colorbox/
 * 
 */


/**
 * Define constants
 * 
 * @since 1.0
 * @author Ryan Hellyer <ryanhellyer@gmail.com>
 */
define( 'SIMPLECOLORBOX_DIR', dirname( __FILE__ ) . '/' ); // Plugin folder DIR
define( 'SIMPLECOLORBOX_URL', plugins_url( '', __FILE__ ) ); // Plugin folder URL
define( 'SIMPLECOLORBOX_VERSION', '1.4.5' );
//define( 'SIMPLECOLORBOX_OPACITY', '0.2' );
//define( 'SIMPLECOLORBOX_WIDTH', '50' );
//define( 'SIMPLECOLORBOX_HEIGHT', '50' );

/**
 * Simple Colorbox class
 * Adds the required CSS and JS files to front-end of the site
 * 
 * This class may be abstracted from the plugin and used in your own theme if you prefer.
 * This can allow you to offer easy to use colorbox functionality without the hassle of 
 * users needing to install a complicated plugin.
 * 
 * @copyright Copyright (c), Ryan Hellyer
 * @author Ryan Hellyer <ryanhellyer@gmail.com>
 * @since 1.0
 */
class Simple_Colorbox {

	/**
	 * Class constructor
	 * Adds all the methods to appropriate hooks or shortcodes
	 */
	public function __construct() {

		// Add action hooks
		add_action( 'wp_enqueue_scripts', array( $this, 'external_css' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'external_scripts' ) );
		add_action( 'wp_head',            array( $this, 'simplecolorbox_ad' ) );
		add_action( 'wp_head',            array( $this, 'inline_scripts' ) );

	}

	/**
	 * Print scripts onto pages
	 */
	public function external_scripts() {

		wp_enqueue_script(
			'colorbox',
			SIMPLECOLORBOX_URL . '/scripts/jquery.colorbox-min.js',
			array( 'jquery' ),
			1.0,
			true
		);		
	}

	/**
	 * Print scripts onto pages
	 */
	public function inline_scripts() {

		// Do definition check - used by themes/plugins to over-ride the default settings
		if ( ! defined( 'SIMPLECOLORBOX_OPACITY' ) )
			define( 'SIMPLECOLORBOX_OPACITY', '0.6' );
		if ( ! defined( 'SIMPLECOLORBOX_WIDTH' ) )
			define( 'SIMPLECOLORBOX_WIDTH', '95' );
		if ( ! defined( 'SIMPLECOLORBOX_HEIGHT' ) )
			define( 'SIMPLECOLORBOX_HEIGHT', '95' );
		if ( ! defined( 'SIMPLECOLORBOX_SLIDESHOW' ) )
			define( 'SIMPLECOLORBOX_SLIDESHOW', 'group' );

		// Colorbox settings
		echo '
<script>
	jQuery(function($){
		$("a[href$=\'jpg\'],a[href$=\'jpeg\'],a[href$=\'png\'],a[href$=\'bmp\'],a[href$=\'gif\'],a[href$=\'JPG\'],a[href$=\'JPEG\'],a[href$=\'PNG\'],a[href$=\'BMP\'],a[href$=\'GIF\']").colorbox({
			maxWidth:\'' . SIMPLECOLORBOX_WIDTH . '%\',
			maxHeight:\'' . SIMPLECOLORBOX_HEIGHT . '%\',
			opacity:\'' . SIMPLECOLORBOX_OPACITY . '\',
			transition: \'none\',
			rel:\'' . SIMPLECOLORBOX_SLIDESHOW . '\'
		});
	});
</script>';
	}

	/*
	 * Adds CSS to front end of site
	 */
	public function external_css() {
		// Load the stylesheet
		wp_enqueue_style( 'colorbox', SIMPLECOLORBOX_URL . '/theme/colorbox.css', false, '', 'screen' );
	}

	/**
	 * Display notice about the plugin in head
	 */
	public function simplecolorbox_ad() {
		echo "\n<!-- Simple Colorbox Plugin v" . SIMPLECOLORBOX_VERSION ." by Ryan Hellyer ... http://geek.ryanhellyer.net/products/simple-colorbox/ -->\n";
	}

}
$simple_colorbox = new Simple_Colorbox();
