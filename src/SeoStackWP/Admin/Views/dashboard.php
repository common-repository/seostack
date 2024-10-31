<div class="wrap">
	<?php
	include( 'elements/logo_bar.php' );
	?>

	<div style="width: 100%;max-width: 390px;margin-right:10px;float: left;">
		<div style="border: 1px solid #ccc; margin-top: 10px; background-color: #fff;">
			<h3 style="border-bottom: 1px solid #ccc;margin:0;padding: 10px;"><?= __( 'Your API key', 'seostack' ) ?></h3>

			<table width="100%" style="padding: 10px;margin:0;">
				<tr>
					<th align="left"><?= __( 'Status', 'seostack' ) ?></th>
					<td align="right"><?= __( 'Active', 'seostack' ) ?></td>
				</tr>
				<tr>
					<th align="left"><?= __( 'Documents indexed', 'seostack' ) ?></th>
					<td align="right">
						<?= number_format_i18n( $vars['api_key_info']->doc_count, 0 ) ?>
					</td>
				</tr>
				<tr>
					<th align="left"><?= __( 'Documents on this site', 'seostack' ) ?></th>
					<td align="right">
						<?= number_format_i18n( $vars['total_posts'], 0 ) ?>
					</td>
				</tr>
				<tr>
					<th align="left"><?= __( 'Documents limit', 'seostack' ) ?></th>
					<td align="right">
						<?= number_format_i18n( $vars['api_key_info']->doc_limit, 0 ) ?>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-top:20px;padding-bottom:20px;text-align:center;">
						<a href="https://seostack.io/hosted-site-search/?key=<?= esc_html( $vars['api_key'] ) ?>" target="_blank" style="background-color: #ffa238;color: #fff;border-color: #ffa238;text-decoration: none;padding:10px;font-size:1.2em;    -webkit-box-shadow: 0 1px 0 #ccc;box-shadow: 0 1px 0 #ccc;border-radius:3px;">
							<?= __( 'Upgrade your document limit', 'seostack' ) ?> &raquo;
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div style="border: 1px solid #ccc; margin-top: 10px; background-color: #fff;">
			<h3 style="border-bottom: 1px solid #ccc;margin:0;padding: 10px;"><?= __( 'Popular search terms', 'seostack' ) ?></h3>

			<p style="padding: 10px;margin:0;"><i>Stats will be displayed soon!</i></p>
		</div>
	</div>
	<div style="width: 100%;max-width: 390px;margin-left:10px;float: left;">
		<div style="border: 1px solid #ccc; margin-top: 10px; background-color: #fff;">
			<h3 style="border-bottom: 1px solid #ccc;margin:0;padding: 10px;"><?= __( 'Support', 'seostack' ) ?></h3>

			<ul style="padding: 10px;margin:0;">
				<li>
					<a href="https://wordpress.org/plugins/seostack" target="_blank"><?= __( 'WordPress Support forum', 'seostack' ) ?></a>
				</li>
				<li>
					<a href="https://seostack.io/support" target="_blank"><?= __( 'Documentation', 'seostack' ) ?></a>
				</li>
				<li>
					<a href="https://github.com/seostack/seostack-for-wordpress/issues" target="_blank"><?= __( 'Report an issue', 'seostack' ) ?></a>
				</li>
				<li>
					<a href="https://twitter.com/seostackio" target="_blank"><?= __( '@seostackio on Twitter', 'seostack' ) ?></a>
				</li>
			</ul>
		</div>
	</div>

	<div style="clear:both;"></div>
</div>
