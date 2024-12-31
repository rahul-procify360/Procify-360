<div id="column-modal" class="hidden cost-calculator-modal">
	<form action="#" class="cost-calculator-modal-form" id="column-modal-form">
		<label><?php _e("Column width", 'cost-calculator'); ?></label>
		<select name="width">
			<option value="1/1" selected="selected"><?php _e("Full width", 'cost-calculator'); ?></option>
			<option value="1/2"><?php _e("1/2", 'cost-calculator'); ?></option>
			<option value="1/3"><?php _e("1/3", 'cost-calculator'); ?></option>
			<option value="2/3"><?php _e("2/3", 'cost-calculator'); ?></option>
			<option value="1/4"><?php _e("1/4", 'cost-calculator'); ?></option>
			<option value="3/4"><?php _e("3/4", 'cost-calculator'); ?></option>
			<option value="1/6"><?php _e("1/6", 'cost-calculator'); ?></option>
			<option value="5/6"><?php _e("5/6", 'cost-calculator'); ?></option>
		</select>
		<label><?php _e("Top margin", 'cost-calculator'); ?></label>
		<select name="top_margin">
			<option value="none" selected="selected"><?php _e("None", 'cost-calculator'); ?></option>
			<option value="page-margin-top"><?php _e("Small", 'cost-calculator'); ?></option>
			<option value="page-margin-top-section"><?php _e("Large", 'cost-calculator'); ?></option>
		</select>
		<label><?php _e("Extra class name", 'cost-calculator'); ?></label>
		<input type="text" name="el_class" value="">
		<input type="hidden" name="shortcode" value="vc_column">
		<input type="submit" value="Insert" class="button button-primary">
	</form>
</div>
