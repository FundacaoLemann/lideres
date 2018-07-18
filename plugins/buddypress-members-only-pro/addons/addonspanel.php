<?php
if (!defined('ABSPATH'))
{
	exit;
}

function BPMOPROAddonSettings()
{
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2>BuddyPress Members Only Pro Addon Settings</h2>
</div>
<?php 
$addonPanelTitle = 'Enable / Disable Buddypress Members Only Approve User Addon';
$addonOptionTitle = 'approveuser';
$addonName = 'approveuser';
$addonItemTitle = 'Approve User Addon';
$addonEnableOption = 'enableBPMOPROAddonApproveUser';
$addonPath = BPMOPRO_ADDONS_PATH.'bpmopro_approve.php';
BPMOPROAddonPanel($addonName,$addonPath, $addonEnableOption, $addonPanelTitle,$addonItemTitle);
}
?>

<?php 
function BPMOPROAddonPanel($addonName, $addonPath, $addonEnableOption,$addonPanelTitle,$addonItemTitle)
{
	if (empty($addonPath))
	{
		return;
	}
	
	if (isset($_POST['enableBPMOPROAddonapproveuserSubmit']))
	{
		if (isset($_POST['enableBPMOPROAddonapproveuser']))
		{
			update_option("enableBPMOPROAddonapproveuser",$_POST['enableBPMOPROAddonapproveuser']);
		}

		if (file_exists($addonPath))
		{
			$tooltipsMessageProString =  __( 'Approve User Addon Enabled', 'wordpress-tooltips' );
		}
		else
		{
			$tooltipsMessageProString =  __( 'Changes saved but you did not installed "approve user addon of buddypress members only pro" yet, please contact membersonly.top support, thanks', 'wordpress-tooltips' );
		}
		buddypress_members_only_pro_message($tooltipsMessageProString);
	}
	
	$addonEnableOptionVar = get_option($addonEnableOption); 
	if (empty($addonEnableOptionVar)) $addonEnableOptionVar = 'NO';
	?>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='hndle' style='padding: 10px 0px;'><span>
									<?php
										echo __( $addonPanelTitle, 'wordpress-tooltips' )."<i> <font color='Gray'></font></i>";
									?>
									</span>
									</h3>
									<div class="inside" style='padding-left:5px;'>
										<form class="toolstipsform" name="toolstipsform" action="" method="POST">
										<table id="toolstipstable" width="100%">
										<tr style="text-align:left;">
										<td width="25%"  style="text-align:left;">
										<?php
											echo __( $addonItemTitle, 'wordpress-tooltips' ).':';
										?>
										</td>
										<td width="40%"  style="text-align:left;">
										<select id="enableBPMOPROAddon<?php echo $addonName; ?>" name="enableBPMOPROAddon<?php echo $addonName; ?>" style="width:400px;">
										<option id="enableBPMOPROAddon<?php echo $addonName; ?>Option" value="YES" <?php if ($addonEnableOptionVar == 'YES') echo "selected";   ?>> <?php echo __("Enable $addonItemTitle of BuddyPress Members Only", "wordpress-tooltips");?> </option>
										<option id="enableBPMOPROAddon<?php echo $addonName; ?>Option" value="NO" <?php if ($addonEnableOptionVar == 'NO') echo "selected";   ?>>   <?php echo __("Disable $addonItemTitle of BuddyPress Members Only", "wordpress-tooltips");?> </option>
										</select>
										</td>
										<td width="30%"  style="text-align:left;">
										<input type="submit" class="button-primary" id="enableBPMOPROAddon<?php echo $addonName; ?>Submit" name="enableBPMOPROAddon<?php echo $addonName; ?>Submit" value=" <?php echo __('Update Now', "wordpress-tooltips");?> ">
										</td>
										</tr>

										</table>
										</form>
										
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

BPMOPROAddonSettings();
