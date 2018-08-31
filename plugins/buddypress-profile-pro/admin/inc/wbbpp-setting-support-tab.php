<?php
/**
 * Exit if accessed directly.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="bprm-adming-setting">
	<div class="bprm-tab-header">
		<h3><?php esc_html_e( 'FAQ(s) ', 'buddypress-profile-pro' ); ?></h3>
		<input type="hidden" class="bprm-tab-active" value="support"/>
	</div>

	<div class="bprm-admin-settings-block">
		<div id="bprm-settings-tbl" class="bprm-table">
			<div class="bprm-admin-row border">
				<div class="bprm-admin-col-12">
				 <button class="bprm-accordion">
					<?php esc_html_e( 'Does BuddyPress Profile Pro plugin require BuddyPress?', 'buddypress-profile-pro' ); ?>
				</button>
				<div class="wbbpp-panel">
					<p>
						<?php esc_html_e( 'Yes, BuddyPress is a mandatory plugin, and It needs you to have BuddyPress installed and activated.', 'buddypress-profile-pro' ); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="bprm-admin-row border">
			<div class="bprm-admin-col-12">
				<button class="bprm-accordion">
					<?php esc_html_e( 'Where can I view and edit members extended fields?', 'buddypress-profile-pro' ); ?>
				</button>
				<div class="wbbpp-panel">
					<p>
						<?php esc_html_e( 'You can edit and view saved extended fields at BuddyPress profile under Profile menu tab.', 'buddypress-profile-pro' ); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="bprm-admin-row border">
			<div class="bprm-admin-col-12">
				<button class="bprm-accordion">
					<?php esc_html_e( 'What is the use of API Key option provided in general settings section?', 'buddypress-profile-pro' ); ?>
				</button>
				<div class="wbbpp-panel">
					<p>
						<?php esc_html_e( 'Inside Profile Pro we have options to add location fields and these fields can be filled with an auto-suggestion. Google Places API key is used to fill places with google autocomplete. ', 'buddypress-profile-pro' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'To use the Google Autocomplete Field Type in the resume, you must register your app project on the Google API Console and get a Google API key which you can add there.', 'buddypress-profile-pro' ); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="bprm-admin-row border">
			<div class="bprm-admin-col-12">
				<button class="bprm-accordion">
					<?php esc_html_e( 'How to keep only desired fields in the form?', 'buddypress-profile-pro' ); ?>
				</button>
				<div class="wbbpp-panel">
					<p>
						<?php esc_html_e( 'You can set fields in the form by selecting desired fields in admin settings under Field Settings tab.', 'buddypress-profile-pro' ); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="bprm-admin-row border">
			<div class="bprm-admin-col-12">
				<button class="bprm-accordion">
					<?php esc_html_e( 'How can I create a new extended field the form ?', 'buddypress-profile-pro' ); ?>
				</button>
				<div class="wbbpp-panel">
					<p>
						<?php esc_html_e( 'You can create a new field in form with help of the form provided under Field Settings tab.', 'buddypress-profile-pro' ); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="bprm-admin-row border">
			<div class="bprm-admin-col-12">
				<button class="bprm-accordion">
					<?php esc_html_e( 'How can I keep some field required for the profile field?', 'buddypress-profile-pro' ); ?>
				</button>
				<div class="wbbpp-panel">
					<p>
						<?php esc_html_e( 'You can set required fields in form by checking Required setting for any invidual fields under Field Settings section.', 'buddypress-profile-pro' ); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="bprm-admin-row border">
			<div class="bprm-admin-col-12">
				<button class="bprm-accordion">
					<?php esc_html_e( 'What is the use of Repeater setting provided for fields under Field Settings section?', 'buddypress-profile-pro' ); ?>
				</button>
				<div class="wbbpp-panel">
					<p>
						<?php esc_html_e( 'Fields which are saved with Repeater option checked, provides option to users to fill data for that particular field multiple times.', 'buddypress-profile-pro' ); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
