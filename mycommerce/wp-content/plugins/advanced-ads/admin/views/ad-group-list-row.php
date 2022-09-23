<?php
/**
 * Template for a single row in the group list
 *
 * @package   Advanced_Ads_Admin
 * @author    Thomas Maier <support@wpadvancedads.com>
 * @license   GPL-2.0+
 * @link      https://wpadvancedads.com
 * @copyright since 2013 Thomas Maier, Advanced Ads GmbH
 *
 * @var Advanced_Ads_Group       $group ad group object.
 * @var Advanced_Ads_Groups_List $this  Groups list table object.
 */
?><tr class="advads-group-row">
	<td>
		<strong><a class="row-title" href="#"><?php echo esc_html( $group->name ); ?></a></strong>
		<?php
		// escaping done by the function.
		// phpcs:ignore
		echo $this->render_action_links( $group ); ?>
		<?php
		$modal_slug = esc_attr( $group->id . '-usage' );
		ob_start();
		?>
		<div class="advads-usage">
			<h2><?php esc_attr_e( 'shortcode', 'advanced-ads' ); ?></h2>
				<code><input type="text" onclick="this.select();" value='[the_ad_group id="<?php echo absint( $group->id ); ?>"]' readonly /></code>
			<h2><?php esc_html_e( 'template (PHP)', 'advanced-ads' ); ?></h2>
				<code><input type="text" onclick="this.select();" value="the_ad_group(<?php echo absint( $group->id ); ?>);" readonly /></code>
		</div>
		<?php
		$modal_content = ob_get_clean();
		$modal_title  = esc_html__( 'Usage', 'advanced-ads' );
		include ADVADS_BASE_PATH . 'admin/views/modal.php';
		?>
	</td>
	<td>
		<ul><?php $_type = isset( $this->types[ $group->type ]['title'] ) ? $this->types[ $group->type ]['title'] : 'default'; ?>
			<li><strong>
			<?php
			/*
			 * translators: %s is the name of a group type
			 */
			printf( esc_html__( 'Type: %s', 'advanced-ads' ), esc_html( $_type ) );
			?>
			</strong></li>
			<li>
			<?php
			/*
			 * translators: %s is the ID of an ad group
			 */
			printf( esc_attr__( 'ID: %s', 'advanced-ads' ), absint( $group->id ) );
			?>
			</li>
		</ul>
	</td>
	<td class="advads-ad-group-list-ads"><?php $this->render_ads_list( $group ); ?></td>
</tr>
