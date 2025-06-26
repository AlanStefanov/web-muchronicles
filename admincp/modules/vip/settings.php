<?php
/**
 * VIP
 * https://webenginecms.org/
 * 
 * @version 1.1.0
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2020 Lautaro Angelico, All Rights Reserved
 * @build wfd094c4936ed5b6323fd0fcab72ef68
 */

function saveChanges() {
    global $_POST;
	
    $xmlPath = __PATH_VIP_ROOT__.'config.xml';
    $xml = simplexml_load_file($xmlPath);
	
	if(!is_writable($xmlPath)) throw new Exception('The configuration file is not writable.');
	
	// bronze
	
	if(!Validator::UnsignedNumber($_POST['setting_1'])) throw new Exception('Submitted setting is not valid (enable_vip_type_1)');
	if(!in_array($_POST['setting_1'], array(1, 0))) throw new Exception('Submitted setting is not valid (enable_vip_type_1)');
	$xml->enable_vip_type_1 = $_POST['setting_1'];
	
	if(!preg_match('/^\d+(?:,\d+)*$/', $_POST['setting_2'])) throw new Exception('Submitted setting is not valid (vip_packages_1)');
	$xml->vip_packages_1 = $_POST['setting_2'];
	
	if(!preg_match('/^\d+(?:,\d+)*$/', $_POST['setting_14'])) throw new Exception('Submitted setting is not valid (vip_discount_1)');
	$xml->vip_discount_1 = $_POST['setting_14'];
	
	if(!Validator::UnsignedNumber($_POST['setting_3'])) throw new Exception('Submitted setting is not valid (vip_cost_per_day_1)');
	$xml->vip_cost_per_day_1 = $_POST['setting_3'];
	
	// silver
	
	if(!Validator::UnsignedNumber($_POST['setting_4'])) throw new Exception('Submitted setting is not valid (enable_vip_type_2)');
	if(!in_array($_POST['setting_4'], array(1, 0))) throw new Exception('Submitted setting is not valid (enable_vip_type_2)');
	$xml->enable_vip_type_2 = $_POST['setting_4'];
	
	if(!preg_match('/^\d+(?:,\d+)*$/', $_POST['setting_5'])) throw new Exception('Submitted setting is not valid (vip_packages_2)');
	$xml->vip_packages_2 = $_POST['setting_5'];
	
	if(!preg_match('/^\d+(?:,\d+)*$/', $_POST['setting_15'])) throw new Exception('Submitted setting is not valid (vip_discount_2)');
	$xml->vip_discount_2 = $_POST['setting_15'];
	
	if(!Validator::UnsignedNumber($_POST['setting_6'])) throw new Exception('Submitted setting is not valid (vip_cost_per_day_2)');
	$xml->vip_cost_per_day_2 = $_POST['setting_6'];
	
	// gold
	
	if(!Validator::UnsignedNumber($_POST['setting_7'])) throw new Exception('Submitted setting is not valid (enable_vip_type_3)');
	if(!in_array($_POST['setting_7'], array(1, 0))) throw new Exception('Submitted setting is not valid (enable_vip_type_3)');
	$xml->enable_vip_type_3 = $_POST['setting_7'];
	
	if(!preg_match('/^\d+(?:,\d+)*$/', $_POST['setting_8'])) throw new Exception('Submitted setting is not valid (vip_packages_3)');
	$xml->vip_packages_3 = $_POST['setting_8'];
	
	if(!preg_match('/^\d+(?:,\d+)*$/', $_POST['setting_16'])) throw new Exception('Submitted setting is not valid (vip_discount_3)');
	$xml->vip_discount_3 = $_POST['setting_16'];
	
	if(!Validator::UnsignedNumber($_POST['setting_9'])) throw new Exception('Submitted setting is not valid (vip_cost_per_day_3)');
	$xml->vip_cost_per_day_3 = $_POST['setting_9'];
	
	// platinum
	
	if(!Validator::UnsignedNumber($_POST['setting_10'])) throw new Exception('Submitted setting is not valid (enable_vip_type_4)');
	if(!in_array($_POST['setting_10'], array(1, 0))) throw new Exception('Submitted setting is not valid (enable_vip_type_4)');
	$xml->enable_vip_type_4 = $_POST['setting_10'];
	
	if(!preg_match('/^\d+(?:,\d+)*$/', $_POST['setting_11'])) throw new Exception('Submitted setting is not valid (vip_packages_4)');
	$xml->vip_packages_4 = $_POST['setting_11'];
	
	if(!preg_match('/^\d+(?:,\d+)*$/', $_POST['setting_17'])) throw new Exception('Submitted setting is not valid (vip_discount_4)');
	$xml->vip_discount_4 = $_POST['setting_17'];
	
	if(!Validator::UnsignedNumber($_POST['setting_12'])) throw new Exception('Submitted setting is not valid (vip_cost_per_day_4)');
	$xml->vip_cost_per_day_4 = $_POST['setting_12'];
	
	// credits
	
	if(!Validator::UnsignedNumber($_POST['setting_13'])) throw new Exception('Submitted setting is not valid (credit_config)');
	$xml->credit_config = $_POST['setting_13'];
	
    $save = @$xml->asXML($xmlPath);
	if(!$save) throw new Exception('There has been an error while saving changes.');
}

if(check_value($_POST['submit_changes'])) {
	try {
		saveChanges();
		message('success', 'Settings successfully saved.');
	} catch (Exception $ex) {
		message('error', $ex->getMessage());
	}
}

if(check_value($_GET['checkusercplinks'])) {
	try {
		$VIP = new \Plugin\VIP\VIP();
		$VIP->checkPluginUsercpLinks();
		message('success', 'UserCP Links Successfully Added!');
	} catch (Exception $ex) {
		message('error', $ex->getMessage());
	}
}

// load configs
$pluginConfig = simplexml_load_file(__PATH_VIP_ROOT__.'config.xml');
if(!$pluginConfig) throw new Exception('Error loading config file.');

// credit system
$creditSystem = new CreditSystem();

// server files
if(strtolower(config('server_files', true)) != 'igcn') {
	message('info', 'By default, the "platinum" VIP type is only available when using IGCN files.');
}
?>
<h2>VIP Settings</h2>
<form action="" method="post">

	<table class="table table-striped table-bordered table-hover module_config_tables">
		<tr>
            <th>Bronze VIP Status<br/><span>Enables / disables the VIP type 1</span></th>
            <td>
				<?php enabledisableCheckboxes('setting_1', $pluginConfig->enable_vip_type_1, 'Enabled', 'Disabled'); ?>
            </td>
        </tr>
        <tr>
            <th>Bronze VIP Packages<br/><span>Amount of days your players will be allowed to purchase this VIP type, separated by commas (no spaces).<br /><br />Example:<br />5,10,15,20,25,30</span></th>
            <td>
				<input class="form-control" type="text" name="setting_2" value="<?php echo $pluginConfig->vip_packages_1; ?>"/>
            </td>
        </tr>
        <tr>
            <th>Bronze VIP Packages Discount %<br/><span>Discount percentage for each package, separated by commas (no spaces).<br /><br />Example:<br />0,5,10,15</span></th>
            <td>
				<input class="form-control" type="text" name="setting_14" value="<?php echo $pluginConfig->vip_discount_1; ?>"/>
            </td>
        </tr>
        <tr>
            <th>Bronze VIP Cost Per Day<br/><span>The daily cost is multiplied by the amount of days available in the package</span></th>
            <td>
				<input class="form-control" type="text" name="setting_3" value="<?php echo $pluginConfig->vip_cost_per_day_1; ?>"/>
            </td>
        </tr>
	</table>
	
	<table class="table table-striped table-bordered table-hover module_config_tables">
		<tr>
            <th>Silver VIP Status<br/><span>Enables / disables the VIP type 2</span></th>
            <td>
				<?php enabledisableCheckboxes('setting_4', $pluginConfig->enable_vip_type_2, 'Enabled', 'Disabled'); ?>
            </td>
        </tr>
		<tr>
            <th>Silver VIP Packages<br/><span>Amount of days your players will be allowed to purchase this VIP type, separated by commas (no spaces).<br /><br />Example:<br />5,10,15,20,25,30</span></th>
            <td>
				<input class="form-control" type="text" name="setting_5" value="<?php echo $pluginConfig->vip_packages_2; ?>"/>
            </td>
        </tr>
		<tr>
            <th>Silver VIP Packages Discount %<br/><span>Discount percentage for each package, separated by commas (no spaces).<br /><br />Example:<br />0,5,10,15</span></th>
            <td>
				<input class="form-control" type="text" name="setting_15" value="<?php echo $pluginConfig->vip_discount_2; ?>"/>
            </td>
        </tr>
		<tr>
            <th>Silver VIP Cost Per Day<br/><span>The daily cost is multiplied by the amount of days available in the package</span></th>
            <td>
				<input class="form-control" type="text" name="setting_6" value="<?php echo $pluginConfig->vip_cost_per_day_2; ?>"/>
            </td>
        </tr>
	</table>
	
	<table class="table table-striped table-bordered table-hover module_config_tables">
		<tr>
            <th>Gold VIP Status<br/><span>Enables / disables the VIP type 3</span></th>
            <td>
				<?php enabledisableCheckboxes('setting_7', $pluginConfig->enable_vip_type_3, 'Enabled', 'Disabled'); ?>
            </td>
        </tr>
		<tr>
            <th>Gold VIP Packages<br/><span>Amount of days your players will be allowed to purchase this VIP type, separated by commas (no spaces).<br /><br />Example:<br />5,10,15,20,25,30</span></th>
            <td>
				<input class="form-control" type="text" name="setting_8" value="<?php echo $pluginConfig->vip_packages_3; ?>"/>
            </td>
        </tr>
		<tr>
            <th>Gold VIP Packages Discount %<br/><span>Discount percentage for each package, separated by commas (no spaces).<br /><br />Example:<br />0,5,10,15</span></th>
            <td>
				<input class="form-control" type="text" name="setting_16" value="<?php echo $pluginConfig->vip_discount_3; ?>"/>
            </td>
        </tr>
		<tr>
            <th>Gold VIP Cost Per Day<br/><span>The daily cost is multiplied by the amount of days available in the package</span></th>
            <td>
				<input class="form-control" type="text" name="setting_9" value="<?php echo $pluginConfig->vip_cost_per_day_3; ?>"/>
            </td>
        </tr>
	</table>
	
	<table class="table table-striped table-bordered table-hover module_config_tables">
		<tr>
            <th>Platinum VIP Status (IGCN ONLY)<br/><span>Enables / disables the VIP type 4</span></th>
            <td>
				<?php enabledisableCheckboxes('setting_10', $pluginConfig->enable_vip_type_4, 'Enabled', 'Disabled'); ?>
            </td>
        </tr>
		<tr>
            <th>Platinum VIP Packages (IGCN ONLY)<br/><span>Amount of days your players will be allowed to purchase this VIP type, separated by commas (no spaces).<br /><br />Example:<br />5,10,15,20,25,30</span></th>
            <td>
				<input class="form-control" type="text" name="setting_11" value="<?php echo $pluginConfig->vip_packages_4; ?>"/>
            </td>
        </tr>
		<tr>
            <th>Platinum VIP Packages Discount %<br/><span>Discount percentage for each package, separated by commas (no spaces).<br /><br />Example:<br />0,5,10,15</span></th>
            <td>
				<input class="form-control" type="text" name="setting_17" value="<?php echo $pluginConfig->vip_discount_4; ?>"/>
            </td>
        </tr>
		<tr>
            <th>Platinum VIP Cost Per Day (IGCN ONLY)<br/><span>The daily cost is multiplied by the amount of days available in the package</span></th>
            <td>
				<input class="form-control" type="text" name="setting_12" value="<?php echo $pluginConfig->vip_cost_per_day_4; ?>"/>
            </td>
        </tr>
	</table>
	
	<table class="table table-striped table-bordered table-hover module_config_tables">
		<tr>
			<th>Credit Configuration<br/><span>Type of credits used to pay for VIP.</span></th>
			<td>
				<?php echo $creditSystem->buildSelectInput("setting_13", $pluginConfig->credit_config, "form-control"); ?>
			</td>
		</tr>
		<tr>
            <td colspan="2"><input type="submit" name="submit_changes" value="Save Changes" class="btn btn-success"/></td>
        </tr>
    </table>
</form>

<hr>

<h2>UserCP Links</h2>
<p>Click the button below to automatically add the plugin's links to the user control panel menu.</p>
<a href="<?php echo admincp_base('vip&page=settings&checkusercplinks=1'); ?>" class="btn btn-primary">Add UserCP Links</a>