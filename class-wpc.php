<?php 

class WPC {
	
	function __construct() {
		$this->autoload();
		$this->set_filters();
	}

	function autoload() {
		// autoload dirs here
	}

	function set_filters() {
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
		add_action('add_meta_boxes', array($this, 'add_meta_box'));
		add_action('save_post', array($this, 'save_meta_box'));
		add_action('wp_ajax_wpc_get_categories', array($this, 'wpc_get_categories'));
	}

	function enqueue_admin_scripts() {
		wp_register_script('wpc-admin', plugins_url('js/admin/wpc-admin-min.js', __FILE__), array('jquery'));
		wp_enqueue_script('wpc-admin');
		$ajax_url = admin_url('admin-ajax.php');
		wp_localize_script('wpc-admin', 'wpc_ajaxurl', $ajax_url);
	}

	function add_meta_box() {
		$post_types = get_post_types(
			array(
				'_builtin' => false
			)
		);
		$post_types[] = 'post';
		add_meta_box('wpc-meta-box', __('Primary Category', 'wpc'), array($this, 'wpc_metabox'), $post_types, 'side', 'high');
	}

	function wpc_metabox() {

		global $post;

		$primary = null;
		if (!empty($post->ID)) {
			$primary = get_post_meta($post->ID, 'wpc_selected', true);
		}
		$categories = get_terms(
			array(
				'taxonomy' => 'category',
				'hide_empty' => false
			)
		);
		include_once(WPC_PATH.'/templates/admin/_wpcMetabox.php');
	}

	function save_meta_box($post_id) {
		if (empty($post_id)) {
			return;
		}

		if (empty($_POST['wpc_select'])) {
			return;
		}

		$primary = absint($_POST['wpc_select']);

		update_post_meta($post_id, 'wpc_selected', $primary);
	}

	function wpc_get_categories() {
		$categories = get_terms(
			array(
				'taxonomy' => 'category',
				'hide_empty' => false
			)
		);
		print_r(json_encode($categories));
		exit;
	}
}

$wpc = new WPC();

?>