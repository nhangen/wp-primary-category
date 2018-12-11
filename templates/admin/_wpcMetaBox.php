<div class="components-panel__row">
	<div class="components-base-control">
		<div class="components-base-control__field">
			<label class="components-base-control__Label" for="wpc-select"><?php _e('Select Primary Category', 'wpc'); ?></label>
			<select id="wpc-select" name="wpc_select" class="components-select-control__input">
				<?php if (!empty($categories)) {
					foreach ($categories as $category) {
						echo '<option value="'.$category->term_id.'" '.(!empty($primary) && $primary == $category->term_id ? 'selected' : '').'>'.$category->name.'</option>';
					}
				} ?>
			</select>
		</div>
	</div>
</div>