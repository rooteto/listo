<?php
/**
 * Listo Meta Boxes sınıfı
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

class Listo_Meta_Boxes {

	public function __construct() {
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'));
	}

	/**
	 * Meta box'ları ekle
	 */
	public function add_meta_boxes() {
		add_meta_box(
				'listo-location-details',
				'Konum Bilgileri',
				array($this, 'location_details_callback'),
				'listo',
				'normal',
				'high'
		);
	}

	/**
	 * Konum bilgileri meta box callback
	 */
	public function location_details_callback($post) {

		// Nonce ekle
		wp_nonce_field('listo_location_details', 'listo_location_details_nonce');

		// Mevcut değerleri al
		$country = get_post_meta($post->ID, '_listo_country', true);
		$city = get_post_meta($post->ID, '_listo_city', true);
		$district = get_post_meta($post->ID, '_listo_district', true);
		$phone = get_post_meta($post->ID, '_listo_phone', true);
		$email = get_post_meta($post->ID, '_listo_email', true);
		$address = get_post_meta($post->ID, '_listo_address', true);
		$status = get_post_meta($post->ID, '_listo_status', true);

		// Varsayılan değerler
		if (empty($status)) {
			$status = 'active';
		}
		?>

		<table class="form-table">
			<tr>
				<th><label for="listo_country">Ülke</label></th>
				<td>
					<select name="listo_country" id="listo_country" class="regular-text">
						<option value="">Ülke seçin</option>
						<option value="turkey" <?php selected($country, 'turkey'); ?>>Türkiye</option>
						<option value="usa" <?php selected($country, 'usa'); ?>>Amerika</option>
						<option value="germany" <?php selected($country, 'germany'); ?>>Almanya</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="listo_city">İl</label></th>
				<td>
					<select name="listo_city" id="listo_city" class="regular-text">
						<option value="">İl seçin</option>
						<option value="istanbul" <?php selected($city, 'istanbul'); ?>>İstanbul</option>
						<option value="ankara" <?php selected($city, 'ankara'); ?>>Ankara</option>
						<option value="izmir" <?php selected($city, 'izmir'); ?>>İzmir</option>
						<option value="bursa" <?php selected($city, 'bursa'); ?>>Bursa</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="listo_district">İlçe</label></th>
				<td>
					<select name="listo_district" id="listo_district" class="regular-text">
						<option value="">İlçe seçin</option>
						<option value="kadikoy" <?php selected($district, 'kadikoy'); ?>>Kadıköy</option>
						<option value="besiktas" <?php selected($district, 'besiktas'); ?>>Beşiktaş</option>
						<option value="sisli" <?php selected($district, 'sisli'); ?>>Şişli</option>
						<option value="uskudar" <?php selected($district, 'uskudar'); ?>>Üsküdar</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="listo_phone">Telefon</label></th>
				<td>
					<input type="text" name="listo_phone" id="listo_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" placeholder="0212 xxx xx xx" />
				</td>
			</tr>
			<tr>
				<th><label for="listo_email">E-posta</label></th>
				<td>
					<input type="email" name="listo_email" id="listo_email" value="<?php echo esc_attr($email); ?>" class="regular-text" placeholder="info@firma.com" />
				</td>
			</tr>
			<tr>
				<th><label for="listo_address">Adres</label></th>
				<td>
					<textarea name="listo_address" id="listo_address" rows="3" class="large-text" placeholder="Tam adres bilgisi..."><?php echo esc_textarea($address); ?></textarea>
				</td>
			</tr>
			<tr>
				<th><label for="listo_status">Durum</label></th>
				<td>
					<select name="listo_status" id="listo_status">
						<option value="active" <?php selected($status, 'active'); ?>>Aktif</option>
						<option value="inactive" <?php selected($status, 'inactive'); ?>>Pasif</option>
					</select>
					<p class="description">Sadece aktif konumlar frontend'te görünür.</p>
				</td>
			</tr>
		</table>

		<?php
	}

	/**
	 * Meta box verilerini kaydet
	 */
	public function save_meta_boxes($post_id) {

		// Nonce kontrolü
		if (!isset($_POST['listo_location_details_nonce']) || !wp_verify_nonce($_POST['listo_location_details_nonce'], 'listo_location_details')) {
			return;
		}

		// Autosave kontrolü
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// Yetki kontrolü
		if (isset($_POST['post_type']) && 'listo' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return;
			}
		} else {
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}
		}

		// Verileri kaydet
		$fields = array('country', 'city', 'district', 'phone', 'email', 'address', 'status');

		foreach ($fields as $field) {
			if (isset($_POST['listo_' . $field])) {
				update_post_meta($post_id, '_listo_' . $field, sanitize_text_field($_POST['listo_' . $field]));
			}
		}
	}
}
