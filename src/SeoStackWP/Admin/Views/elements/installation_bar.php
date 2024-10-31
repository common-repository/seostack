<?php
$color_active   = 'background: #fff; color: #000;';
$color_inactive = 'bbackground: #fff;';
?>

<div style="width: auto; max-width: 800px; border: 1px solid #aaa; display:table;">
	<div style="width:29%;border-right: 1px solid #ccc; <?php if ( $active === 1 ) {
		echo $color_active;
	} else {
		echo $color_inactive;
	} ?> padding: 2%; display:table-cell;">
		<h3 style="margin: 0px; padding 4px;<?php if ( $active === 1 ) {
			echo $color_active;
		} else {
			echo $color_inactive;
		} ?>border-bottom: 1px solid #ccc;padding-bottom: 15px;"><?= __( 'Step 1: Free API key', 'seostack' ) ?></h3>
		<p><?= __( 'Get a free API key for using our services. This is needed for indexing your website.', 'seostack' ) ?></p>
	</div>
	<div style="width:29%;border-right: 1px solid #ccc; <?php if ( $active === 2 ) {
		echo $color_active;
	} else {
		echo $color_inactive;
	} ?> padding: 2%;display:table-cell;">
		<h3 style="margin: 0px; padding 4px;<?php if ( $active === 2 ) {
			echo $color_active;
		} else {
			echo $color_inactive;
		} ?>border-bottom: 1px solid #ccc;padding-bottom: 15px;"><?= __( 'Step 2: Indexing your site', 'seostack' ) ?></h3>
		<p><?= __( 'Our search engine has to know your website. Indexing is a process that does that for you.', 'seostack' ) ?></p>
	</div>
	<div style="width:29%; <?php if ( $active === 3 ) {
		echo $color_active;
	} else {
		echo $color_inactive;
	} ?> padding: 2%;display:table-cell;">
		<h3 style="margin: 0px; padding 4px;<?php if ( $active === 3 ) {
			echo $color_active;
		} else {
			echo $color_inactive;
		} ?>border-bottom: 1px solid #ccc;padding-bottom: 15px;"><?= __( 'Step 3: Done!', 'seostack' ) ?></h3>
		<p><?= __( 'You\'re now good to go! Use the default search widget on your website. The results should be better!', 'seostack' ) ?></p>
	</div>
</div>