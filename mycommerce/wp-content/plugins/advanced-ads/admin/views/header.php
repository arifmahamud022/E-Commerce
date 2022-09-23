<?php
/**
 * Header on admin pages
 *
 * @var string $title page title.
 * @var string $screen_id ID of the current screen.
 */
?>
<div id="advads-header">
	<div id="advads-header-wrapper">
		<div>
			<svg class="advads-header-logo" xmlns="http://www.w3.org/2000/svg" x="0" y="0" height="30" width="30" viewBox="0 0 351.7 352" xml:space="preserve"><path d="M252.2 149.6v125.1h-174.9v-174.9H202.4c-5.2-11.8-8-24.7-8-38.5s3-26.7 8-38.5h-37.7H0v267.9l8.8 8.8 -8.8-8.8C0 324.5 27.5 352 61.3 352l0 0h103.4 164.5V149.3c-11.8 5.2-25 8.3-38.8 8.3C276.9 157.6 264 154.6 252.2 149.6z" fill="#1C1B3A"/><circle cx="290.4" cy="61.3" r="61.3" fill="#0E75A4"/></svg>
			<h1><?php echo esc_html( $title ); ?></h1>
		</div>
		<div id="advads-header-actions">
			<?php
			// load page-specific information
			$manual_url = 'manual/';
			switch ( $screen_id ) :
				case 'advanced_ads': // ad edit page
				case 'edit-advanced_ads': // ad overview
					?>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=advanced_ads' ) ); ?>" class="header-action button" ><span class="dashicons dashicons-plus"></span><?php esc_html_e( 'New Ad', 'advanced-ads' ); ?></a>
					<?php
					$manual_url = 'manual/first-ad/';
					break;
				case 'advanced-ads_page_advanced-ads-groups': // ad groups
					?>
					<a href="#" id="advads-new-ad-group-link" class="header-action button"><span class="dashicons dashicons-plus"></span><?php esc_html_e( 'New Ad Group', 'advanced-ads' ); ?></a>
					<?php
					$manual_url = 'manual/rotate-ad/';
					break;
				case 'advanced-ads_page_advanced-ads-placements':
					?>
					<a href="#" class="header-action button" title="<?php esc_html_e( 'Create a new placement', 'advanced-ads' ); ?>" onclick="advads_toggle('.advads-placements-new-form'); advads_scroll_to_element('#advads-placements-new-form');"><span class="dashicons dashicons-plus"></span><?php esc_html_e( 'New Placement', 'advanced-ads' ); ?></a>
					<?php
					$manual_url = 'manual/placements/';
					break;
			endswitch;
			$manual_url = apply_filters( 'advanced-ads-admin-header-manual-url', $manual_url, $screen_id );
			?>
		</div>
		<div id="advads-header-links">
			<?php if ( ! defined( 'AAP_VERSION' ) ) : ?>
			<a class="advads-upgrade" href="<?php echo esc_url( ADVADS_URL ); ?>add-ons/?utm_source=advanced-ads&utm_medium=link&utm_campaign=header-upgrade-<?php echo esc_attr( $screen_id ); ?>" target="_blank"><?php esc_html_e( 'See all Add-ons', 'advanced-ads' ); ?></a>
			<?php endif; ?>
			<a href="<?php echo esc_url( ADVADS_URL . $manual_url ); ?>?utm_source=advanced-ads&utm_medium=link&utm_campaign=header-manual-<?php echo esc_attr( $screen_id ); ?>" target="_blank"><?php esc_html_e( 'Manual', 'advanced-ads' ); ?></a>
		</div>
	</div>
</div>
