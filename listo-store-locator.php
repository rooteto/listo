<?php
/**
 * Plugin Name: Listo Store Locator
 * Plugin URI: https://www.hosteva.com
 * Description: WordPress Store Locator plugin for finding stores by location.
 * Version: 1.0.0
 * Author: Hosteva Hosting
 * Author URI: https://www.hosteva.com
 * Text Domain: listo-store-locator
 * Domain Path: /languages
 * License: GPL v2 or later
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

// Plugin sabitleri
define('LISTO_VERSION', '1.0.0');
define('LISTO_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LISTO_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('LISTO_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Ana plugin sınıfı
 */
class Listo_Store_Locator {

	public function __construct() {
		// WordPress init hook'unda başlat
		add_action('plugins_loaded', array($this, 'init'));

		// Aktivasyon/deaktivasyon hook'ları
		register_activation_hook(__FILE__, array($this, 'activate'));
		register_deactivation_hook(__FILE__, array($this, 'deactivate'));
	}

	/**
	 * Plugin başlatma
	 */
	public function init() {
		// Text domain yükle
		load_plugin_textdomain('listo-store-locator', false, dirname(plugin_basename(__FILE__)) . '/languages');

		// Admin dosyalarını yükle
		if (is_admin()) {
			$this->load_admin();
		}

		// Public dosyalarını yükle
		$this->load_public();

		// Shortcode'ları yükle
		$this->load_shortcodes();

		// Custom Post Type'ı erken yükle
		add_action('init', array($this, 'register_post_types'), 0);
	}

	/**
	 * Custom Post Type'ları register et
	 */
	public function register_post_types() {
		require_once LISTO_PLUGIN_PATH . 'admin/class-post-type.php';
		new Listo_Post_Type();
	}

	/**
	 * Admin dosyalarını yükle
	 */
	private function load_admin() {
		require_once LISTO_PLUGIN_PATH . 'admin/class-admin.php';
		require_once LISTO_PLUGIN_PATH . 'admin/class-meta-boxes.php';
		require_once LISTO_PLUGIN_PATH . 'admin/class-module-manager.php';
		require_once LISTO_PLUGIN_PATH . 'admin/class-gutenberg-blocks.php';

		new Listo_Admin();
		new Listo_Meta_Boxes();
		new Listo_Module_Manager();
		new Listo_Gutenberg_Blocks();
	}

	/**
	 * Public dosyalarını yükle
	 */
	private function load_public() {
		require_once LISTO_PLUGIN_PATH . 'public/class-public.php';
		new Listo_Public();
	}

	/**
	 * Shortcode dosyalarını yükle
	 */
	private function load_shortcodes() {
		require_once LISTO_PLUGIN_PATH . 'shortcodes/class-shortcodes.php';
		new Listo_Shortcodes();
	}

	/**
	 * Plugin aktivasyon
	 */
	public function activate() {
		// Custom post type'ı register et
		require_once LISTO_PLUGIN_PATH . 'admin/class-post-type.php';
		$post_type = new Listo_Post_Type();
		$post_type->register_post_type();

		// Rewrite rules'u flush et
		flush_rewrite_rules();

		// Default modülleri aktif et
		if (!get_option('listo_active_modules')) {
			update_option('listo_active_modules', array('basic'));
		}
	}

	/**
	 * Plugin deaktivasyon
	 */
	public function deactivate() {
		// Rewrite rules'u flush et
		flush_rewrite_rules();
	}
}

// Plugin'i başlat
new Listo_Store_Locator();
