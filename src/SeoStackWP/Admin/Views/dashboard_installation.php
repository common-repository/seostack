<div class="wrap">
	<?php
	include( 'elements/logo_bar.php' );
	?>

	<div style="width: 100%;max-width: 800px;margin-right:10px;float: left;">
		<div style="border: 1px solid #ccc; margin-top: 10px; background-color: #fff;">
			<h3 style="border-bottom: 1px solid #ccc;margin:0;padding: 10px;"><?= __( 'Your API key', 'seostack' ) ?></h3>

			<table width="100%" style="padding: 10px;margin:0;">
				<tr>
					<th align="left"><?= __( 'Status', 'seostack' ) ?></th>
					<td align="right"><?= __( 'Inactive', 'seostack' ) ?></td>
				</tr>
				<tr>
					<td colspan="2" style="padding-top:20px;padding-bottom:20px;text-align:center;">
						<a href="admin.php?page=seostack_settings_first" style="background-color: #ffa238;color: #fff;border-color: #ffa238;text-decoration: none;padding:10px;font-size:1.2em;    -webkit-box-shadow: 0 1px 0 #ccc;box-shadow: 0 1px 0 #ccc;border-radius:3px;">
							<?= __( 'Start the installation', 'seostack' ) ?> &raquo;
						</a>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div style="clear:both;"></div>
</div>
