<?php

if(!defined('CARREIRA_GROUP_ID')){
    define('CARREIRA_GROUP_ID', 14);
}
$carreira_empty = true;
while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

    <?php 
    if ( bp_profile_group_has_fields() ) : 
        global $group;
        if($group->id == CARREIRA_GROUP_ID){
            $carreira_empty = false;
        }
        ?>

		<?php
		/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
		do_action( 'bp_before_profile_field_content' ); ?>

		<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">

			<h2><?php bp_the_profile_group_name(); ?></h2>

			<table class="profile-fields">

				<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

					<?php if ( bp_field_has_data() ) : ?>

						<tr <?php bp_field_css_class(); ?>>

							<td class="label"><?php bp_the_profile_field_name(); ?></td>

							<td class="data"><?php bp_the_profile_field_value(); ?></td>

						</tr>

					<?php endif; ?>

					<?php
					/**
					 * Fires after the display of a field table row for profile data.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_profile_field_item' ); ?>

				<?php endwhile; ?>

			</table>
		</div>

		<?php
		/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
		do_action( 'bp_after_profile_field_content' ); ?>

	<?php endif; ?>

<?php endwhile; ?>

<?php if($carreira_empty && (bp_displayed_user_id() == get_current_user_id())): ?>
<div class="bp-widget carreira empty-carreira">
    <h2>Carreira</h2>
    <div>
        <p>Você ainda não publicou nada neste campo</p>
        <p><a class="btn" href="./profile/edit/group/<?php echo CARREIRA_GROUP_ID ?>/">Editar Carreira</a></p>
    </div>
</div>
<?php endif; ?>

<?php
/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_profile_field_buttons' ); ?>
