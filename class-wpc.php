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
		add_action('add_meta_boxes', array($this, 'add_meta_box'));
		add_action('save_post', array($this, 'save_meta_box'));
	}

	function add_meta_box() {
		add_meta_box('wpc-meta-box', __('Primary Category', 'wpc'), array($this, 'wpc_metabox'), null, 'side', 'core');
	}

	function wpc_metabox() {

		global $post;

		$primary = null;
		if (!empty($post->ID)) {
			$primary = get_post_meta($post->ID, 'wpc_selected', true);
		}
		$categories = get_categories();
		
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
}

$wpc = new WPC();

?>