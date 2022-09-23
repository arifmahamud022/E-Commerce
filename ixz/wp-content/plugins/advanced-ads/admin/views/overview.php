<?php
/**
 * Advanced Ads overview page in the dashboard
 */

?>
<div class="wrap">
	<div id="advads-overview">
		<?php Advanced_Ads_Overview_Widgets_Callbacks::setup_overview_widgets(); ?>
	</div>
	<?php do_action( 'advanced-ads-admin-overview-after' ); ?>
</div>
