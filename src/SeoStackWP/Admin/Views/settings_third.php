<div class="wrap">
	<?php
	include( 'elements/logo_bar.php' );
	?>

	<?php $active = 3;
	include( 'elements/installation_bar.php' ); ?>

	<p><br /></p>

	<p style="max-width: 500px;">
		<strong><?= __( "The SeoStack plugin has been activated successfully. You're now able to use our professional search algorithm and updates.", 'seostack' ) ?></strong>
	</p>

	<p>
		<a href="admin.php?page=seostack_dashboard" class="button button-primary"><?= __( 'Continue to dashboard', 'seostack' ) ?> &raquo;</a>
	</p>

</div>
