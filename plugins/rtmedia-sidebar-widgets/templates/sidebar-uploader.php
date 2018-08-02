<?php

/*
 * Template for rtMedia Sidebar uploader widget
 */

if ( is_array( $tabs ) && count( $tabs ) ) { ?>
    <div class="rtmedia-container">
        <div class="rtmedia-uploader no-js">
            <form id="rtmedia-uploader-form-<?php echo $widgetid; ?>" method="post" action="upload" enctype="multipart/form-data">
                <div class="rtm-uploader-widget">
                    <div id="<?php echo 'rtm-' . $mode . '-ui-' . $widgetid; ?>" class="rtm-uploader-wrap">
                            <?php
							echo $privacy_el;
							echo $tabs[ $mode ][ $upload_type ]['content'];
							echo '<input type="hidden" name="mode" value="' . $mode . '" />';
							?>
                    </div>
                </div>
                
                <?php RTMediaWidgetUploaderView::upload_nonce_generator( true );
				?>
                <input type="submit" id='rtMedia-start-upload-<?php echo $widgetid; ?>' name="rtmedia-upload" value="<?php echo RTMEDIA_UPLOAD_LABEL; ?>" />
            </form>
            <?php echo $redirect_el; ?>
        </div>
    </div>
    <?php
}
