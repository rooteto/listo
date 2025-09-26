<?php
/**
 * Listo Admin sınıfı
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

class Listo_Admin {

	public function __construct() {
		add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
	}

	/**
	 * Admin CSS dosyalarını yükle
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'listo-admin-style',
			LISTO_PLUGIN_URL . 'admin/css/admin.css',
			array(),
			LISTO_VERSION,
			'all'
		);
	}

	/**
	 * Admin JS dosyalarını yükle
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'listo-admin-script',
			LISTO_PLUGIN_URL . 'admin/js/admin.js',
			array('jquery'),
			LISTO_VERSION,
			false
		);
	}
}
