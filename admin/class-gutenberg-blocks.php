<?php
/**
 * Listo Gutenberg Blocks sınıfı
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

class Listo_Gutenberg_Blocks {

	public function __construct() {
		add_action('init', array($this, 'register_blocks'));
		add_action('enqueue_block_editor_assets', array($this, 'enqueue_block_editor_assets'));
	}

	/**
	 * Blokları register et
	 */
	public function register_blocks() {
		// Eğer Gutenberg yoksa çık
		if (!function_exists('register_block_type')) {
			return;
		}

		// Listo Store Locator bloğunu register et
		register_block_type('listo/store-locator', array(
			'editor_script' => 'listo-block-editor',
			'render_callback' => array($this, 'render_store_locator_block'),
			'attributes' => array(
				'limit' => array(
					'type' => 'number',
					'default' => 10,
				),
				'country' => array(
					'type' => 'string',
					'default' => '',
				),
				'city' => array(
					'type' => 'string',
					'default' => '',
				),
				'district' => array(
					'type' => 'string',
					'default' => '',
				),
			),
		));
	}

	/**
	 * Block editor için JS/CSS yükle
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_script(
			'listo-block-editor',
			LISTO_PLUGIN_URL . 'admin/js/block-editor.js',
			array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
			LISTO_VERSION,
			true
		);

		wp_enqueue_style(
			'listo-block-editor-style',
			LISTO_PLUGIN_URL . 'admin/css/block-editor.css',
			array('wp-edit-blocks'),
			LISTO_VERSION
		);
	}

	/**
	 * Store Locator bloğunu render et
	 */
	public function render_store_locator_block($attributes) {
		// Shortcode sınıfını kullan
		$shortcode = new Listo_Shortcodes();
		return $shortcode->display_stores($attributes);
	}
}
