jQuery(document).on('heartbeat-send', function(e, data) {

	if (jQuery('#wpc-select').length >= 1) {
		jQuery.ajax({
			url: wpc_ajaxurl,
			type: 'POST',
			data: {action: 'wpc_get_categories'},
			success: function(res) {
				if (typeof(res) !== 'undefined') {
					var json = JSON.parse(res);
					var jsonCount = json.length;
					var wpcCount = jQuery('#wpc-select option').length;
					if (jsonCount !== wpcCount) {
						jQuery('#wpc-select').empty();
						jQuery.each(json, function() {
							jQuery('#wpc-select').append(jQuery('<option/>', {
								value: this.term_id,
								text: this.name
							}));
						});
					}
				}
			}
		});
	}
});