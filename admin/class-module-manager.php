<?php
/**
 * Listo Module Manager
 * Modülleri yöneten sınıf
 */

// Direkt erişimi engelle
if (!defined('ABSPATH')) {
	exit;
}

class Listo_Module_Manager {

	private $modules = array();
	private $active_modules = array();

	public function __construct() {
		add_action('init', array($this, 'load_modules'), 5);
		add_action('admin_menu', array($this, 'add_modules_page'));
	}

	/**
	 * Modülleri yükle
	 */
	public function load_modules() {
		$modules_dir = LISTO_PLUGIN_PATH . 'modules/';

		// Aktif modülleri al
		$this->active_modules = get_option('listo_active_modules', array('basic'));

		// Modül klasörlerini tara
		if (is_dir($modules_dir)) {
			$module_folders = array_diff(scandir($modules_dir), array('.', '..'));

			foreach ($module_folders as $folder) {
				$module_path = $modules_dir . $folder . '/';
				$module_file = $module_path . 'class-' . $folder . '-module.php';

				if (file_exists($module_file)) {
					$this->register_module($folder, $module_file);
				}
			}
		}

		// Aktif modülleri başlat
		$this->load_active_modules();
	}

	/**
	 * Modül kaydet
	 */
	private function register_module($name, $file) {
		$this->modules[$name] = array(
			'name' => $name,
			'file' => $file,
			'active' => in_array($name, $this->active_modules)
		);
	}

	/**
	 * Aktif modülleri yükle
	 */
	private function load_active_modules() {
		foreach ($this->modules as $module) {
			if ($module['active']) {
				require_once $module['file'];

				// Modül sınıfını başlat
				$class_name = 'Listo_' . ucfirst($module['name']) . '_Module';
				if (class_exists($class_name)) {
					new $class_name();
				}
			}
		}
	}

	/**
	 * Admin menüye modül sayfası ekle
	 */
	public function add_modules_page() {
		add_submenu_page(
			'edit.php?post_type=listo',
			'Modüller',
			'Modüller',
			'manage_options',
			'listo-modules',
			array($this, 'modules_page_callback')
		);
	}

	/**
	 * Modüller sayfası
	 */
	public function modules_page_callback() {
		if (isset($_POST['listo_save_modules'])) {
			$active_modules = isset($_POST['active_modules']) ? $_POST['active_modules'] : array();
			update_option('listo_active_modules', $active_modules);
			echo '<div class="notice notice-success"><p>Modül ayarları kaydedildi.</p></div>';

			// Sayfayı yenile
			$this->active_modules = $active_modules;
		}

		?>
		<div class="wrap">
			<h1>Listo Modüller</h1>
			<p>Aşağıdaki modülleri aktif/pasif edebilirsiniz:</p>

			<form method="post" action="">
				<table class="wp-list-table widefat fixed striped">
					<thead>
					<tr>
						<th>Aktif</th>
						<th>Modül Adı</th>
						<th>Açıklama</th>
						<th>Durum</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($this->modules as $module_key => $module): ?>
						<tr>
							<td>
								<input type="checkbox"
									   name="active_modules[]"
									   value="<?php echo esc_attr($module_key); ?>"
									<?php checked(in_array($module_key, $this->active_modules)); ?> />
							</td>
							<td><strong><?php echo esc_html(ucfirst($module_key)); ?></strong></td>
							<td>
								<?php
								if ($module_key == 'basic') {
									echo 'Temel mağaza listeleme modülü';
								} else {
									echo 'Modül açıklaması';
								}
								?>
							</td>
							<td>
								<?php echo $module['active'] ? '<span style="color: green;">Aktif</span>' : '<span style="color: red;">Pasif</span>'; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>

				<p class="submit">
					<input type="submit" name="listo_save_modules" class="button-primary" value="Ayarları Kaydet" />
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Aktif modül listesini döndür
	 */
	public function get_active_modules() {
		return $this->active_modules;
	}

	/**
	 * Tüm modülleri döndür
	 */
	public function get_all_modules() {
		return $this->modules;
	}
}
