<?php
/**
 * Plugin Name: NavThemes FontAwesome Icons
 * Plugin URI: https://www.navthemes.com
 * Description: FontAwesome Icon Block for WordPress
 * Author: NavThemes
 * Author URI: https://www.navthemes.com
 * Version: 1.0.3
 * Text Domain: navthemesfa
 *
 * NavThemes FontAwesome Icons is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * NavThemes FontAwesome Icons is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with NavThemesFontAwesome Icons. If not, see <http://www.gnu.org/licenses/>.
 *
 */

	if ( ! defined( 'NAVTHEMES_FA_PLUGIN_VERSION' ) ) {
		define( 'NAVTHEMES_FA_PLUGIN_VERSION', '1.0' );
	}

	if ( ! defined( 'NAVTHEMES_FA_PLUGIN_DIR' ) ) {
		define( 'NAVTHEMES_FA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}

	if ( ! defined( 'NAVTHEMES_FA_PLUGIN_DIR_URL' ) ) {
		define( 'NAVTHEMES_FA_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
	}

	add_action( 'enqueue_block_editor_assets', 'navthemes_fa_enqueue_editor_assets' );

	function navthemes_fa_enqueue_editor_assets() {
		wp_enqueue_script( 'navthemesfa', untrailingslashit( NAVTHEMES_FA_PLUGIN_DIR_URL ) . '/build/navthemesfa.build.js', array(
			'wp-components',
			'wp-blocks',
			'wp-element',
			'wp-editor',
			'wp-data',
			'wp-date',
			'wp-i18n',
			'wp-compose',
			'wp-keycodes',
			'wp-html-entities',
		), NAVTHEMES_FA_PLUGIN_VERSION );

		wp_enqueue_style( 'navthemesfa-editor', untrailingslashit( NAVTHEMES_FA_PLUGIN_DIR_URL ) . '/build/navthemesfa.build.css', array(
			'wp-edit-blocks',
		), NAVTHEMES_FA_PLUGIN_VERSION );
	}

	add_action( 'wp_enqueue_scripts', 'navthemesfa_enqueue_frontend_block_assets' );

	function navthemesfa_enqueue_frontend_block_assets() {
	
		wp_enqueue_style( 'navthemesfa', untrailingslashit( NAVTHEMES_FA_PLUGIN_DIR_URL ) . '/build/navthemesfa.scripts.css', array(), NAVTHEMES_FA_PLUGIN_VERSION );

	 	wp_enqueue_script( 'navthemesfa-scripts', untrailingslashit( NAVTHEMES_FA_PLUGIN_DIR_URL ) . '/build/navthemesfa.scripts.js', array(
			'jquery',
		), NAVTHEMES_FA_PLUGIN_VERSION, true );
	}

	add_action( 'admin_enqueue_scripts', 'navthemesfa_admin_styles' );

	function navthemesfa_admin_styles() {
		wp_enqueue_style( 'navthemesfa-admin-styles', untrailingslashit( NAVTHEMES_FA_PLUGIN_DIR_URL ) . '/assets/css/admin.css', array(), NAVTHEMES_FA_PLUGIN_VERSION );
	}

	if(!function_exists('NavThemesBlocksAddCategory')) : 

	function NavThemesBlocksAddCategory (){

		/**
		 - This functions checks and add navthemes-blocks category
		**/

		global $post;	
		
		$block_categories = get_block_categories($post) ;

		$available_Block_categories = array();

		foreach ($block_categories as $category) {
			$slug = $category['slug'];
			array_push($available_Block_categories, $slug);
		}

		if(!in_array("navthemes-blocks", $available_Block_categories)){
				// NavThemes Blocks's block category
				add_filter( 'block_categories', 'navthemes_fa_block_categories', 10, 2 );
				function navthemes_fa_block_categories( $categories, $post ) {
					return array_merge( $categories, array(
						array(
							'slug'  => 'navthemes-blocks',
							'title' => __( 'NavThemes Blocks', 'navthemesfa' ),
						),
					) );
				}
		} // if

	} 
	
	add_action('admin_init','NavThemesBlocksAddCategory');

endif;

	