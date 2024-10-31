<div class="wrap">
	<?php
	include( 'elements/logo_bar.php' );
	?>

	<form method="post" action="admin.php?page=seostack_settings_first&step=third">
		<?php wp_nonce_field( 'seostack_settings', 'seostack_settings_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th scope="row">Your API key:</th>
				<td>
					<input type="text" name="seostack[api_key]" value="<?= esc_attr( $vars['api_key'] ) ?>" class="regular-text" disabled="disabled" />
				</td>
			</tr>
			<tr>
				<th scope="row">Current status:</th>
				<td>
					<p><strong style="color: red;"><?= __('Failed', 'seostack') ?></strong> <?= __('You have too many documents on this site. Please upgrade your API key to continue.') ?></p>

					<div style="border: 1px solid #ccc; margin-top: 10px; background-color: #fff; text-align:center;max-width:450px; padding:5px;">
						<p>The API key can be upgraded on our website. After upgrading, the new document limit is available directly.</p>

						<p>
							<a href="https://seostack.io/hosted-site-search/?key=<?= esc_html( $vars['api_key'] ) ?>" target="_blank" style="background-color: #ffa238;color: #fff;border-color: #ffa238;text-decoration: none;padding:10px;font-size:1.2em;    -webkit-box-shadow: 0 1px 0 #ccc;box-shadow: 0 1px 0 #ccc;border-radius:3px;margin-top: 20px; margin-bottom: 20px;display:inline-block">
								<?= __( 'Upgrade now', 'seostack' ) ?> &raquo;
							</a>
						</p>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><?= __('Documents on this site', 'seostack') ?>:</th>
				<td>
					<?= esc_html($vars['total_posts']); ?> documents
				</td>
			</tr>
			<tr>
				<th scope="row"><?= __('Documents limit', 'seostack') ?>:</th>
				<td>
					<span style="padding-top:4px;display:inline-block;margin-right: 20px;"><?= esc_attr($vars['api_limit']) ?> documents</span>
				</td>
			</tr>
			<tr id="submit-area">
				<th scope="row">&nbsp;</th>
				<td>
					<input type="submit" name="submit" id="submit" value="<?= __( 'Complete reindex', 'seostack' ) ?> &raquo;" class="button button-primary" disabled="disabled" />
				</td>
			</tr>
		</table>
	</form>
</div>