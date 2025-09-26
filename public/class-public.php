<?php
/**
 * Listo Public sınıfı
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

class Listo_Public {

	public function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
	}

	/**
	 * Public CSS dosyalarını yükle
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'listo-public-style',
			LISTO_PLUGIN_URL . 'public/css/public.css',
			array(),
			LISTO_VERSION,
			'all'
		);
	}

	/**
	 * Public JS dosyalarını yükle
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'listo-public-script',
			LISTO_PLUGIN_URL . 'public/js/public.js',
			array('jquery'),
			LISTO_VERSION,
			false
		);
	}
}
