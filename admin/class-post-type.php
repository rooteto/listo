<?php
/**
 * Listo Custom Post Type sınıfı
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

class Listo_Post_Type {

	public function __construct() {
		add_action('init', array($this, 'register_post_type'));
	}

	/**
	 * Custom Post Type'ı register et
	 */
	public function register_post_type() {

		$labels = array(
			'name'                  => 'Listo Listeleri',
			'singular_name'         => 'Liste',
			'menu_name'             => 'Listo',
			'name_admin_bar'        => 'Liste',
			'archives'              => 'Liste Arşivleri',
			'attributes'            => 'Liste Özellikleri',
			'parent_item_colon'     => 'Üst Liste:',
			'all_items'             => 'Tüm Listeler',
			'add_new_item'          => 'Yeni Liste Ekle',
			'add_new'               => 'Yeni Ekle',
			'new_item'              => 'Yeni Liste',
			'edit_item'             => 'Liste Düzenle',
			'update_item'           => 'Liste Güncelle',
			'view_item'             => 'Liste Görüntüle',
			'view_items'            => 'Listeleri Görüntüle',
			'search_items'          => 'Liste Ara',
			'not_found'             => 'Liste bulunamadı',
			'not_found_in_trash'    => 'Çöp kutusunda liste bulunamadı',
			'featured_image'        => 'Liste Resmi',
			'set_featured_image'    => 'Liste resmi seç',
			'remove_featured_image' => 'Liste resmini kaldır',
			'use_featured_image'    => 'Liste resmi olarak kullan',
			'insert_into_item'      => 'Listeye ekle',
			'uploaded_to_this_item' => 'Bu listeye yüklenen',
			'items_list'            => 'Liste listesi',
			'items_list_navigation' => 'Liste listesi navigasyonu',
			'filter_items_list'     => 'Liste listesini filtrele',
		);

		$args = array(
			'label'                 => 'Liste',
			'description'           => 'Listo konum listeleri',
			'labels'                => $labels,
			'supports'              => array('title', 'editor', 'thumbnail'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-location-alt',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => true, // Gutenberg desteği
		);

		register_post_type('listo', $args);
	}
}
