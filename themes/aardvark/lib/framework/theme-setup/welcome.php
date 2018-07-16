<div class="wrap">

	<div class="gp-tabs">

		<h1><?php esc_html_e( 'Aardvark Setup', 'aardvark' ); ?></h1>

		<ul class="gp-tabs-navigation">
			<li><a data-content="welcome" class="selected" href="#welcome"><span class="count-tab">1</span> <?php esc_html_e( 'Welcome', 'aardvark' ); ?></a></li>
			<li><a data-content="updates" href="#updates"><span class="count-tab">2</span> <?php esc_html_e( 'Updates', 'aardvark' ); ?></a></li>
			<li><a data-content="addons" href="#addons"><span class="count-tab">3</span> <?php esc_html_e( 'Theme Addons', 'aardvark' ); ?></a></li>
			<li><a data-content="demo-data" href="#demo-data"><span class="count-tab">4</span> <?php esc_html_e( 'Import Demo Data', 'aardvark' ); ?></a></li>
			<li><a data-content="support" href="#support"><span class="count-tab">5</span> <?php esc_html_e( 'Support', 'aardvark' ); ?></a></li>
		</ul>

		<ul class="gp-tabs-content">
		
			<li data-content="welcome" class="selected">

				<div class="postbox">
				
					<h3 class="gp-primary-header"><?php esc_html_e( 'Welcome to Aardvark', 'aardvark' ); ?></h3>
					
					<div class="gp-primary-text inside">
					
						<p><?php esc_html_e( 'Please follow the steps on this page to setup your theme. It is completely optional but it will help you get started.', 'aardvark' ); ?></p>
					
						<p><?php esc_html_e( 'First of all make sure all the server statistics below are green, meaning the theme is compatible with your server. If any statistics are red please follow the steps provided to fix this.', 'aardvark' ); ?></p>
						
					</div>
						
				</div>

				<div class="postbox">

					<h3 class="gp-primary-header"><?php esc_html_e( 'Theme Statistics', 'aardvark' ); ?></h3>
					
					<ul class="gp-server-stats-wrapper striped">
						<li class="gp-server-stats-row">
							<div class="gp-server-stats-col gp-server-stats-col-name"><?php echo esc_html__( 'Theme Version', 'aardvark' ); ?></div>
							<div class="gp-server-stats-col"></div>
							<div class="gp-server-stats-col gp-server-stats-col-value"><?php echo AARDVARK_THEME_VERSION; ?></div>
						</li>
					</ul>	
						
				</div>
						
				<div class="postbox">

					<h3 class="gp-primary-header"><?php esc_html_e( 'Server Statistics', 'aardvark' ); ?></h3>
					
					<ul class="gp-server-stats-wrapper striped">

						<?php
						
						$statuses = array();
						
						// WordPress version
						$icon = 'dashicons-yes';
						$color_class = 'gp-server-stats-ok';
						$message = get_bloginfo( 'version' );
						if ( version_compare( get_bloginfo( 'version' ), '3.8', '<' ) ) {
							$icon = 'dashicons-warning';
							$color_class = 'gp-server-stats-notok';
							$message = esc_html__( ' - Please update WordPress as version 3.8 or higher is required.', 'aardvark' );
						}
						$statuses[] = array(
							'name' => esc_html__( 'WordPress Version', 'aardvark' ),
							'title' => esc_html__( 'WordPress version.', 'aardvark' ),
							'icon' => $icon,
							'color_class' => $color_class,
							'message' => $message,
						);
						
						// Writable directory
						$upload_dir = wp_upload_dir();
						$icon = 'dashicons-yes';
						$color_class = 'gp-server-stats-ok';
						$message = esc_html__( 'Uploads folder is writable', 'aardvark' );
						if ( ! wp_is_writable( trailingslashit( $upload_dir['basedir'] ) ) ) {
							$icon = 'dashicons-warning';
							$color_class = 'gp-server-stats-notok';
							$message = esc_html__( 'Uploads folder is not writable. Please check with your hosting provider.', 'aardvark' );
						}
						$statuses[] = array(
							'name' => esc_html__( 'File Permissions', 'aardvark' ),
							'title' => esc_html__( 'Whether or not your uploads folder is writable.', 'aardvark' ),
							'icon' => $icon,
							'color_class' => $color_class,
							'message' => $message,
						);

						// PHP version
						$icon = 'dashicons-yes';
						$color_class = 'gp-server-stats-ok';
						$php_version = phpversion();
						$message = $php_version;
						if ( version_compare( $php_version, '5.6', '<' ) ) {
							$icon = 'dashicons-warning';
							$color_class = 'gp-server-stats-notok';
							$message = esc_html__( ' - You are using an outdated PHP version. A version greater than 5.6 is required.', 'aardvark' );
						}
						$statuses[] = array(
							'name' => esc_html__( 'PHP Version', 'aardvark' ),
							'title' => esc_html__( 'PHP version of your server.', 'aardvark' ),
							'icon' => $icon,
							'color_class' => $color_class,
							'message' => $message

						);

						// Memory limit
						$icon = 'dashicons-yes';
						$color_class = 'gp-server-stats-ok';
						$memory = wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) );
						$message = size_format( $memory );
						if ( $memory < 128000000 ) {
							$icon = 'dashicons-warning';
							$color_class = 'gp-server-stats-notok';
							$message .= esc_html__( ' - We recommend setting the memory limit to at least 128MB, to do this', 'aardvark' ) . ' <a href="' . esc_url( 'http://ghostpool.com/documentation/aardvark/getting-started/importing-demo-data/#1523702282824-0cd1b174-559e' ) . '" target="_blank">' . esc_html__( 'click here', 'aardvark' ) . '</a>.';
						}
						$statuses[] = array(
							'name' => esc_html__( 'PHP Memory Limit', 'aardvark' ),
							'title' => esc_html__( 'The maximum amount of memory that your site can use at one time.', 'aardvark' ),
							'icon' => $icon,
							'color_class' => $color_class,
							'message' => $message

						);
						
						// Max execution time
						$message = '';
						$icon = 'dashicons-yes';
						$color_class = 'gp-server-stats-ok';
						$time_limit = @ini_get( 'max_execution_time' );
						$message = $time_limit;
						if ( $time_limit < 180 && $time_limit != 0 ) {
							$icon = 'dashicons-warning';
							$color_class = 'gp-server-stats-notok';
							$message .= esc_html__( ' - We recommend setting the maximum execution time to at least 180 for importing the demo data, to do this', 'aardvark' ) . ' <a href="' . esc_url( 'http://ghostpool.com/documentation/aardvark/getting-started/importing-demo-data/#1523702282824-0cd1b174-559e' ) . '" target="_blank">' . esc_html__( 'click here', 'aardvark' ) . '</a>.';
						}
						$statuses[] = array(
							'name' => esc_html__( 'PHP Maximum Execution Limit', 'aardvark' ),
							'title' => esc_html__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out.', 'aardvark' ),
							'icon' => $icon,
							'color_class' => $color_class,
							'message' => $message
						);

						// Max input vars
						$icon = 'dashicons-yes';
						$color_class = 'gp-server-stats-ok';
						$input_vars = ini_get('max_input_vars');
						$message = $input_vars;
						if ( $input_vars < 1000 ) {
							$icon = 'dashicons-warning';
							$color_class = 'gp-server-stats-notok';
							$message .= esc_html__( ' - We recommend setting the maximum input vars to at least 1000 otherwise POST data will be truncated, to do this', 'aardvark' ) . ' <a href="' . esc_url( 'http://ghostpool.com/documentation/aardvark/how-to-increase-max-input-vars/' ) . '" target="_blank">' . esc_html__( 'click here', 'aardvark' ) . '</a>.';
						}
						$statuses[] = array(
							'name' => esc_html__( 'PHP Maximum Input Vars', 'aardvark' ),
							'title' => esc_html__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'aardvark' ),
							'icon' => $icon,
							'color_class' => $color_class,
							'message' => $message
						);

						// ZipArchive
						$message = esc_html__( 'Installed' , 'aardvark' );
						$icon = 'dashicons-yes';
						$color_class = 'gp-server-stats-ok';
						if ( ! class_exists( 'ZipArchive' ) ) {
							$icon = 'dashicons-warning';
							$color_class = 'gp-server-stats-notok';
							$message = esc_html__( 'Not installed - ZipArchive is required for importing the demo data. Please contact your server administrator and ask them to enable it.', 'aardvark' );
						}
						$statuses[] = array(
							'name' => esc_html__( 'ZipArchive', 'aardvark' ),
							'title' => esc_html__( 'ZipArchive is required for importing the demo data.', 'aardvark' ),
							'icon' => $icon,
							'color_class' => $color_class,
							'message' => $message
						);

						// WP DEBUG Mode
						$message = esc_html__( 'OK - DEBUG is OFF' , 'aardvark' );
						$icon = 'dashicons-yes';
						$color_class = 'gp-server-stats-ok';
						if ( defined( 'WP_DEBUG' ) && WP_DEBUG === TRUE ) {
							$icon = 'dashicons-warning';
							$color_class = 'gp-server-stats-notok';
							$message = esc_html__( 'DEBUG is ON - It is recommended you disable WordPress debugging on your live site.', 'aardvark' );
						}
						$statuses[] = array(
							'name' => esc_html__( 'WP Debug', 'aardvark' ),
							'title' => esc_html__( 'Whether or not WordPress is in Debug Mode.', 'aardvark' ),
							'icon' => $icon,
							'color_class' => $color_class,
							'message' => $message
						);

						?>

						<?php foreach ( $statuses as $status ) : ?>

							<li class="gp-server-stats-row">
								<div class="gp-server-stats-col gp-server-stats-col-name"><?php echo esc_attr( $status['name'] ); ?></div>
								<div class="gp-server-stats-col"><span class="gp-server-stats-col-icon tooltip-me dashicons-before <?php echo esc_attr( $status['icon'] ); ?>" title="<?php echo esc_attr( $status['title'] );?>"></span></div>
								<div class="gp-server-stats-col gp-server-stats-col-value <?php echo esc_attr( $status['color_class'] ); ?>"><?php echo wp_kses_post( $status['message'] ); ?></div>
							</li>

						<?php endforeach; ?>

					</ul>
				</div>

			</li>

			<li data-content="updates">
				
				<div class="postbox">
					<h3 class="gp-primary-header"><?php esc_html_e( 'Get automatic theme updates', 'aardvark' ); ?></h3>
					<div class="gp-primary-text inside">
						<p><?php esc_html_e( 'To get automatic theme updates do the following:', 'aardvark' ); ?></p>
						<ul class="ul-square">
							<li><?php esc_html_e( 'Enter your ThemeForest (Envato) username.', 'aardvark' ); ?></li>
							<li><?php esc_html_e( 'Generate an API key on ThemeForest and enter it.', 'aardvark' ); ?> <a href="https://ticksy_attachments.s3.amazonaws.com/9076411986.jpg" target="_blank"><?php esc_html_e( 'How do I get my API key?', 'aardvark' ); ?></a></li>
							<li><?php esc_html_e( 'Click the "Register" button.', 'aardvark' ); ?></li>
							<li><?php esc_html_e( 'When an update is available you will see a update icon appear just like you do when plugin updates are available.', 'aardvark' ); ?></li>
						</ul>
					</div>
				</div>

				<div class="postbox">
					<div class="inside">
						<?php
						$tf_username  = ghostpool_option( 'tf_username' );
						$tf_api       = ghostpool_option( 'tf_apikey' );
						?>
						<form action="<?php echo admin_url( 'themes.php?page=' . GhostPool_Setup::getInstance()->slug ); ?>#updates" class="gp-theme-updates-form">
							<div class="gp-setup-form-field">
								<label for="gp-tf-username"><?php esc_html_e( 'ThemeForest (Envato) Username', 'aardvark' ); ?></label>
								<input type="text" id="gp-tf-username" class="gp-theme-updates-form-username" value="<?php echo esc_attr( $tf_username ); ?>" size="50">
							</div>
							<div class="gp-setup-form-field">
								<label for="gp-tf-apikey"><?php esc_html_e( 'Themeforest API Key', 'aardvark' ); ?></label>
								<input type="text" id="gp-tf-apikey" name="gp-tf-apikey" class="gp-theme-updates-form-api" value="<?php echo esc_attr( $tf_api ); ?>" size="50">
							</div>

							<div class="gp-response-area hidden"></div>

							<?php wp_nonce_field( 'ghostpool_theme_updates_action', 'ghostpool_theme_updates_nonce' ); ?>
						
							<input type="submit" class="button button-primary" value="<?php if ( ghostpool_option( 'tf_username' ) && ghostpool_option( 'tf_apikey' ) ) { esc_attr_e( 'Register Again', 'aardvark' ); } else { esc_attr_e( 'Register', 'aardvark' ); } ?>">
						</form>
					</div>
				</div>
				
			</li>

			<li data-content="addons">

				<div class="postbox">
				
					<h3 class="gp-primary-header"><?php esc_html_e( 'Install Addons', 'aardvark' ); ?></h3>
					
					<div class="gp-primary-text inside">
						<p><?php esc_html_e( 'Below you will find a list of required and recommended theme plugins. Please make sure you install all the required plugins before proceeding to the next step.', 'aardvark' ); ?></p>
					</div>
					
				</div>	

				<div class="gp-addons-list">
					<?php foreach ( GhostPool_Addons_Manager()->plugins as $plugin ) : ?>

						<?php
						
						$plugin_status = GhostPool_Addons_Manager()->get_plugin_status( $plugin['slug'] ); ?>
						
						<div class="postbox gp-addon <?php echo esc_attr( $plugin_status['status'] ); ?>" id="addon-<?php echo esc_attr( $plugin['slug'] ); ?>">
				
							<h4 class="gp-addon-title"><?php echo esc_attr( $plugin['name'] ); ?></h4>
							
							<div class="gp-addon-title"><?php echo esc_attr( $plugin['version'] ); ?></div>
							
							<div class="gp-addon-extra<?php if ( isset( $plugin['required'] ) && $plugin['required'] == true ) { echo ' gp-required-addon'; } ?>"><?php echo ( isset( $plugin['required'] ) && $plugin['required'] == true ) ? esc_html__( 'Required', 'aardvark' ) : esc_html__( 'Optional', 'aardvark' ); ?></div>
							
							<?php if ( isset( $plugin['description'] ) ) { ?>
								<span class="gp-addon-desc tooltip-me dashicons-before dashicons-info" title="<?php echo esc_attr( $plugin['description'] ); ?>"></span>
							<?php } ?>
																
							 <a class="gp-addon-button button-primary button" data-action="<?php echo esc_attr( $plugin_status['action'] ); ?>" data-status="<?php echo esc_attr( $plugin_status['status'] ); ?>" data-nonce="<?php echo wp_create_nonce( 'ghostpool_addons_action' ); ?>" href="#" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>"><?php echo esc_attr( $plugin_status['action_text'] ); ?></a><span class="spinner"></span>
							
							<div class="gp-addon-ajax-text"></div>

						</div>
					<?php endforeach; ?>
				</div>
			</li>

			<li data-content="demo-data">

				<?php

				$ghostpoolImport = GhostPool_Importer::getInstance();
				$ghostpoolImport->show_message();

				?>

				<form class="gp-import-form" action="" method="post" onSubmit="if ( ! confirm( 'Really import the data?' ) ) { return false; }">

					<input type="hidden" name="ghostpool_import_nonce" value="<?php echo wp_create_nonce( 'import_nonce' ); ?>" />
					
					<?php $ghostpoolImport->generate_boxes_html(); ?>
					
				</form>
				
			</li>

			<li data-content="support">
				
				<div class="postbox">
					<h3 class="gp-primary-header"><?php esc_html_e( 'Need support?', 'aardvark' ); ?></h3>
					<div class="gp-primary-text inside">
						<p><?php esc_html_e( 'Before you submit a support ticket please check out the theme documentation and knowledge base from the links below.', 'aardvark'  ); ?></p>
						<a href="<?php echo esc_url( 'http://ghostpool.com/documentation/aardvark/' ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Documentation', 'aardvark' ); ?></a>
						<a href="<?php echo esc_url( 'https://ghostpool.ticksy.com/articles/100011787' ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Knowledge Base', 'aardvark' ); ?></a>
						<a href="<?php echo esc_url( 'https://www.youtube.com/playlist?list=PLmhsVOHFNHy9lRHLMmU7Lk6EbMS_CWybq' ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Video Tutorials', 'aardvark' ); ?></a>
					</div>
				</div>
			
				<div class="postbox">
					<h3 class="gp-primary-header"><?php esc_html_e( 'Still need support?', 'aardvark' ); ?></h3>
					<div class="gp-primary-text inside">
						<p><?php esc_html_e( 'If you still need help after reading through the documentation and knowledge base please open up a support ticket and we will reply to your question within 24 hours Monday to Friday.', 'aardvark' ); ?></p>
						<a href="<?php echo esc_url( 'https://ghostpool.ticksy.com' ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Submit A Support Ticket', 'aardvark' ); ?></a>
					</div>
				</div>	
									
			</li>
			
		</ul>
	</div>
	
</div>