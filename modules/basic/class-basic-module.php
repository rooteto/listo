<?php
/**
 * Listo Basic Module
 * Temel mağaza listeleme modülü
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

class Listo_Basic_Module {

	public $name = 'Basic Store Display';
	public $version = '1.0.0';
	public $description = 'Temel mağaza listeleme modülü';

	public function __construct() {
		add_action('init', array($this, 'init'));
	}

	/**
	 * Modülü başlat
	 */
	public function init() {
		// Temel listeleme fonksiyonları
		add_filter('listo_store_display_format', array($this, 'basic_display_format'));
		add_action('listo_before_store_list', array($this, 'add_search_form'));
	}

	/**
	 * Temel görünüm formatı
	 */
	public function basic_display_format($format) {
		return 'list'; // list, grid, table
	}

	/**
	 * Arama formu ekle
	 */
	public function add_search_form() {
		echo '<div class="listo-search-form">';
		echo '<input type="text" placeholder="Mağaza ara..." class="listo-search-input">';
		echo '<button type="button" class="listo-search-btn">Ara</button>';
		echo '</div>';
	}

	/**
	 * Modül bilgilerini döndür
	 */
	public function get_module_info() {
		return array(
			'name' => $this->name,
			'version' => $this->version,
			'description' => $this->description,
			'status' => 'active'
		);
	}
}
