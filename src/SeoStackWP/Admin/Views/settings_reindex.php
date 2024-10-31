<div class="wrap">
	<?php
	include( 'elements/logo_bar.php' );
	?>

		<?php wp_nonce_field( 'seostack_settings', 'seostack_settings_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th scope="row"><?= __('Your API key', 'seostack') ?>:</th>
				<td>
					<input type="text" name="seostack[api_key]" value="<?= esc_attr( $vars['api_key'] ) ?>" class="regular-text" disabled="disabled" />
				</td>
			</tr>
			<tr>
				<th scope="row">Current status:</th>
				<td>
					<div style="text-align: center; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; max-width: 350px;">
						<div id="seostack-progressbar" style="color: #fff;line-height: 30px;border-radius: 5px;">&nbsp;</div>
					</div>

					<p><strong><span id="seostack-completed">0</span> / <?= $vars['total_posts'] ?> documents</strong>
					</p>

					<p class="description" style="max-width: 350px;"><?= __( 'Please wait and DO NOT close this window while indexing your site. This may take a few minutes.', 'seostack' ) ?></p>
				</td>
			</tr>
			<tr id="submit-area">
				<th scope="row">&nbsp;</th>
				<td>
					<input type="submit" name="submit" id="submit" value="<?= __( 'Complete reindex', 'seostack' ) ?> &raquo;" class="button button-primary" disabled="disabled" onclick="location.href='admin.php?page=seostack_settings';" />
				</td>
			</tr>
		</table>
</div>


<script type="text/javascript">
	var current_page = 0;

	function startBatch(start) {
		jQuery.ajax({
			type   : "POST",
			url    : ajaxurl,
			data   : {
				action: "seostack_index",
				start : start
			},
			success: function (data) {
				data = jQuery.parseJSON(data);

				jQuery('#seostack-completed').html(data.completed);

				if (data.completed >= <?= $vars['total_posts'] ?> ) {
					jQuery('#seostack-progressbar').css('width', '100%').css('background-color', '#003f63').html('100 %');

					jQuery('#submit').prop("disabled", false);
				}
				else {
					var percentage = 0;
					percentage = Math.round((data.completed / <?= $vars['total_posts'] ?>) * 100);

					jQuery('#seostack-progressbar').css('width', percentage + '%').css('background-color', '#003f63').css('text-align', 'center').html(percentage + ' %');

					current_page++;

					startBatch(current_page);
				}
			},
			error  : function (errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	jQuery(document).ready(function () {
		startBatch(1);
	});
</script>