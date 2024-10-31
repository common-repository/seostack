<div class="wrap">
	<?php
	include( 'elements/logo_bar.php' );
	?>

	<form method="post" action="admin.php?page=seostack_live_search">
		<?php wp_nonce_field( 'seostack_settings', 'seostack_settings_nonce' ); ?>

		<h3><?= __( 'Live search suggest design', 'seostack' ) ?></h3>

		<table class="form-table">
			<tr>
				<th scope="row"><?= __( 'Background color', 'seostack' ) ?>:</th>
				<td>
					<input type="text" name="seostack[live_search][bg_color]" value="<?= esc_attr( $vars['live_search']['bg_color'] ) ?>" class="seostack-color-picker" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?= __( 'Border color', 'seostack' ) ?>:</th>
				<td>
					<input type="text" name="seostack[live_search][border_color]" value="<?= esc_attr( $vars['live_search']['border_color'] ) ?>" class="seostack-color-picker" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?= __( 'Border size', 'seostack' ) ?>:</th>
				<td>
					<input type="number" size="3" name="seostack[live_search][border_size]" value="<?= esc_attr( $vars['live_search']['border_size'] ) ?>" style="width: 45px;" /> px
				</td>
			</tr>
			<tr>
				<th scope="row"><?= __( 'Link color', 'seostack' ) ?>:</th>
				<td>
					<input type="text" name="seostack[live_search][link_color]" value="<?= esc_attr( $vars['live_search']['link_color'] ) ?>" class="seostack-color-picker" />
				</td>
			</tr>
			<tr>
				<th scope="row"><?= __( 'Link color (:active, :hover)', 'seostack' ) ?>:</th>
				<td>
					<input type="text" name="seostack[live_search][link_color_hover]" value="<?= esc_attr( $vars['live_search']['link_color_hover'] ) ?>" class="seostack-color-picker" />
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" name="submit" value="<?= __( 'Save Changes' ) ?>" class="button button-primary" />
		</p>
	</form>
</div>