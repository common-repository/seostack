<div class="wrap">
	<?php
	include( 'elements/logo_bar.php' );
	?>

	<?php $active = 1;
	include( 'elements/installation_bar.php' ); ?>

	<?php if ( $vars['api_key_info'] === null ): ?>
		<form method="post" action="admin.php?page=seostack_settings_first&step=second">
			<?php wp_nonce_field( 'seostack_settings', 'seostack_settings_nonce' ); ?>


			<table class="form-table">
				<tr>
					<th scope="row">Webmaster contact email:</th>
					<td>
						<input type="text" name="seostack[email]" value="<?= esc_attr( $vars['email_webmaster'] ) ?>" class="regular-text" />
						<p class="description" style="max-width: 350px;"><?= __( 'Your email is used to generate a API key for the SeoStack services. We will never sell or share your email address. This key is only used for securing your documents in our search engine.', 'seostack' ) ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">Newsletter:</th>
					<td>
						<label>
							<input type="checkbox" name="seostack[newsletter]" value="1" />
							<?= __( 'Yes, I want to receive the newsletter from seostack.io on a regular basis', 'seostack' ) ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">&nbsp;</th>
					<td>
						<input type="submit" name="submit" value="<?= __( 'Generate free API key & continue to step 2', 'seostack' ) ?> &raquo;" class="button button-primary" />
					</td>
				</tr>
			</table>
		</form>
	<?php else: ?>
		<p><?= __( "We've found an existing API key on this WordPress site. This API key will be used for the installation.", 'seostack' ) ?></p>

		<table class="form-table">
			<tr>
				<th scope="row">Webmaster contact email:</th>
				<td>
					<input type="text" name="seostack[email]" value="<?= esc_attr( $vars['api_key_info']->email ) ?>" class="regular-text" disabled="disabled" />
				</td>
			</tr>
			<tr>
				<th scope="row">API Key:</th>
				<td>
					<input type="text" name="seostack[api_key]" value="<?= esc_attr( $vars['api_key'] ) ?>" class="regular-text" disabled="disabled" />
				</td>
			</tr>
			<tr>
				<th scope="row">Document limit:</th>
				<td>
					<?= esc_attr( $vars['api_key_info']->doc_limit ) ?>
				</td>
			</tr>
			<tr>
				<th scope="row">&nbsp</th>
				<td>
					<input type="button" name="button" value="<?= __( 'Continue to step 2', 'seostack' ) ?> &raquo;" class="button button-primary" onclick="location.href='admin.php?page=seostack_settings_first&step=second';" />
				</td>
			</tr>
		</table>
	<?php endif; ?>
</div>