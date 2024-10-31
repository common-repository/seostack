<div class="wrap">
	<?php
	include( 'elements/logo_bar.php' );
	?>

	<form method="post" action="admin.php?page=seostack_settings">
		<?php wp_nonce_field( 'seostack_settings', 'seostack_settings_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th scope="row"><?= __('API key', 'seostack') ?>:</th>
				<td>
					<input type="text" name="seostack[api_key]" value="<?= esc_attr($vars['api_key']) ?>" disabled="disabled" class="regular-text" />
					<p class="description" style="max-width:350px;"><?= __('This is your auto-generated API key for seostack.io. The api key is used for communication between this website, and our hosted services.', 'seostack') ?></p>
				</td>
			</tr>
		<?php if( !empty( $vars['api_key'] ) ): ?>
			<tr>
				<th scope="row"><?= __('Webmaster contact email', 'seostack') ?>:</th>
				<td><input type="text" name="seostack[email]" value="<?= esc_attr($vars['api_key_info']->email) ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th scope="row"><?= __('Documents limit', 'seostack') ?>:</th>
				<td>
					<span style="padding-top:4px;display:inline-block;margin-right: 20px;"><?= esc_attr($vars['api_key_info']->doc_limit) ?></span>
					<a href="https://seostack.io/upgrade-api-key?key=<?= esc_html( $vars['api_key'] ) ?>" target="_blank" class="button">
						<?= __( 'Upgrade your document limit', 'seostack' ) ?> &raquo;
					</a>
				</td>
			</tr>
			<tr>
				<th scope="row"><?= __('Documents indexed', 'seostack') ?>:</th>
				<td>
					<span style="padding-top:4px;display:inline-block;margin-right: 20px;"><?= esc_attr($vars['api_key_info']->doc_count) ?></span>
					<a href="admin.php?page=seostack_settings&reindex=true" class="button">
						<?= __( 'Start reindex', 'seostack' ) ?>
					</a>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name="submit" value="<?= __('Save Changes') ?>" class="button button-primary" />
		</p>
		<?php else: ?>
				<tr>
					<th scope="row">Webmaster contact email:</th>
					<td>
						<input type="text" name="seostack[email]" value="<?= esc_attr($vars['email_webmaster']) ?>" class="regular-text" />
						<p class="description"><?= __('Your email is used to generate a API key on SeoStack.io. We will never sell or share your email address.', 'seostack') ?></p>
					</td>
				</tr>
		</table>
		<p class="submit">
			<input type="submit" name="submit" value="<?= __('Generate API key') ?>" class="button button-primary" />
		</p>
		<?php endif; ?>
	</form>
</div>