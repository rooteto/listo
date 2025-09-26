<?php
/**
 * Listo Shortcodes sınıfı
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

class Listo_Shortcodes {

	public function __construct() {
		add_shortcode('listo-stores', array($this, 'display_stores'));
	}

	/**
	 * [listo-stores] shortcode
	 */
	public function display_stores($atts) {

		// Shortcode parametreleri
		$atts = shortcode_atts(array(
			                       'limit' => 10,
			                       'country' => '',
			                       'city' => '',
			                       'district' => '',
		                       ), $atts, 'listo-stores');

		// Query parametreleri
		$args = array(
			'post_type' => 'listo',
			'post_status' => 'publish',
			'posts_per_page' => intval($atts['limit']),
			'meta_query' => array(
				array(
					'key' => '_listo_status',
					'value' => 'active',
					'compare' => '='
				)
			)
		);

		// Konum filtrelemeleri
		if (!empty($atts['country'])) {
			$args['meta_query'][] = array(
				'key' => '_listo_country',
				'value' => $atts['country'],
				'compare' => '='
			);
		}

		if (!empty($atts['city'])) {
			$args['meta_query'][] = array(
				'key' => '_listo_city',
				'value' => $atts['city'],
				'compare' => '='
			);
		}

		if (!empty($atts['district'])) {
			$args['meta_query'][] = array(
				'key' => '_listo_district',
				'value' => $atts['district'],
				'compare' => '='
			);
		}

		// Mağazaları getir
		$stores = new WP_Query($args);

		// Output buffer başlat
		ob_start();

		if ($stores->have_posts()) {
			echo '<div class="listo-stores-list">';

			while ($stores->have_posts()) {
				$stores->the_post();

				// Meta verilerini al
				$country = get_post_meta(get_the_ID(), '_listo_country', true);
				$city = get_post_meta(get_the_ID(), '_listo_city', true);
				$district = get_post_meta(get_the_ID(), '_listo_district', true);
				$phone = get_post_meta(get_the_ID(), '_listo_phone', true);
				$email = get_post_meta(get_the_ID(), '_listo_email', true);
				$address = get_post_meta(get_the_ID(), '_listo_address', true);

				echo '<div class="listo-store-item">';
				echo '<h3 class="store-title">' . get_the_title() . '</h3>';

				if (!empty($address)) {
					echo '<p class="store-address"><strong>Adres:</strong> ' . esc_html($address) . '</p>';
				}

				if (!empty($city) || !empty($district)) {
					echo '<p class="store-location"><strong>Konum:</strong> ';
					if (!empty($district)) echo esc_html(ucfirst($district));
					if (!empty($city) && !empty($district)) echo ' / ';
					if (!empty($city)) echo esc_html(ucfirst($city));
					echo '</p>';
				}

				if (!empty($phone)) {
					echo '<p class="store-phone"><strong>Telefon:</strong> <a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a></p>';
				}

				if (!empty($email)) {
					echo '<p class="store-email"><strong>E-posta:</strong> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
				}

				echo '</div>';
			}

			echo '</div>';

			wp_reset_postdata();
		} else {
			echo '<p class="listo-no-stores">Konum bulunamadı.</p>';
		}

		return ob_get_clean();
	}
}
