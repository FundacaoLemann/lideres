<?php
if(!defined('WPINC'))
{
	exit ('Please do not access our files directly.');
}

function buddypress_members_rss_restricts_setting()
{
	global $wpdb;

	if (isset($_POST['bprssrestrictssubmit']))
	{
		
		check_admin_referer( 'bprssrestrictsnonce' );
		if (isset($_POST['bprssrestrictscontent']))
		{
			$bprssrestrictscontent = $_POST['bprssrestrictscontent'];
			update_option('bprssrestrictscontent',$bprssrestrictscontent);
		}
		else
		{
			delete_option('bprssrestrictscontent');
		}

		if (isset($_POST['bpenablerssrestricts']))
		{
			$bpenablerssrestricts = $_POST['bpenablerssrestricts'];
			update_option('bpenablerssrestricts',$bpenablerssrestricts);
		}
		else
		{
			delete_option('bpenablerssrestricts');
		}

		$bpmoMessageString =  __( 'Your changes has been saved.', 'bp-members-only' );
		buddypress_members_only_pro_message($bpmoMessageString);
	}
	echo "<br />";
	?>

<div style='margin:10px 5px;'>
<div style='float:left;margin-right:10px;'>
<img src='<?php echo get_option('siteurl');  ?>/wp-content/plugins/buddypress-members-only-pro/images/new.png' style='width:30px;height:30px;'>
</div> 
<div style='padding-top:5px; font-size:22px;'>Buddypress Members Only RSS Restricts Settings:</div>
</div>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle' style='padding: 20px; !important'>
									<span>
									<?php 
											echo  __( 'RSS Restricts Settings Panel :', 'bp-members-only' );
									?>
									</span>
									</h3>
								
									<div class="inside" style='padding-left:10px;'>
										<form id="bpmoform" name="bpmoform" action="" method="POST">
										<table id="bpmotable" width="100%">
										
										<tr style="margin-top:30px;">
										<td width="30%" style="padding: 20px;" valign="top">
										<?php 
											echo  __( 'Enable RSS Restricts:', 'bp-members-only' );
										?>
										</td>
										<td width="70%" style="padding: 20px;">
										<?php 
										$bpenablerssrestricts = get_option('bpenablerssrestricts'); 
										if (!(empty($bpenablerssrestricts)))
										{
											
										}
										else
										{
											$bpenablerssrestricts = '';
										}
										?>
										<?php 
										if (!(empty($bpenablerssrestricts)))
										{
											echo '<input type="checkbox" id="bpenablerssrestricts" name="bpenablerssrestricts"  style="" value="yes"  checked="checked"> Enable RSS Restricts ';
										}
										else 
										{
											echo '<input type="checkbox" id="bpenablerssrestricts" name="bpenablerssrestricts"  style="" value="yes" > Enable RSS Restricts ';
										}
										?>
										<p><font color="Gray"><i>
										<?php 
											echo  __( '# If you enabled this option,  ', 'bp-members-only' );
											echo  __( ' we will restricts wordpress post feed, comment feed, bbpress forums feed, you can add restricts notifycation as feed content in the editor at below.', 'bp-members-only' );
										?>
										</i></p>
										</td>
										</tr>
										<tr>
										<td width="30%" style="padding: 30px 20px 20px 20px; " valign="top">
										<?php 
											echo  __( 'RSS Restricts Notification Content:', 'bp-members-only' );
										?>
										</td>
										<td width="70%" style="padding: 20px;">
										<?php 
										$bprssrestrictscontent = get_option('bprssrestrictscontent');
										$bprssrestrictscontent = stripslashes($bprssrestrictscontent);
										echo '<div>';
										wp_editor($bprssrestrictscontent, 'bprssrestrictscontent');
										echo '</div>';
										?>
										<p><font color="Gray"><i>
										<?php 
										echo  __( '# You can add your restricts notification in here, support links, images, videos, font style like H2, H3... and so on,  this notification will shown in content of your site feed. ', 'bp-members-only') ;
										?></i></p>
										</td>
										</tr>

																				
										</table>
										<br />
										<?php
											wp_nonce_field('bprssrestrictsnonce');
										?>
										<input type="submit" id="bprssrestrictssubmit" name="bprssrestrictssubmit" value=" Submit " style="margin:1px 20px;">
										</form>
										
										<br />
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
		<br />
		<?php
	
	
}
?>