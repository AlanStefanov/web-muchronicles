<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 1.2.0
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2019 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */
?>
<h1 class="page-header">PayPal Settings</h1>
<?php
function saveChanges() {
	global $_POST;
	foreach($_POST as $setting) {
		if(!check_value($setting)) {
			message('error','Missing data (complete all fields).');
			return;
		}
	}
	
	// PAYPAL
	$xmlPath = __PATH_MODULE_CONFIGS__.'donation.paypal.xml';
	$xml = simplexml_load_file($xmlPath);
	$xml->active = $_POST['setting_2'];
	$xml->paypal_enable_sandbox = $_POST['setting_3'];
	$xml->paypal_email = $_POST['setting_4'];
	$xml->paypal_title = $_POST['setting_5'];
	$xml->paypal_currency = $_POST['setting_6'];
	$xml->paypal_return_url = $_POST['setting_7'];
	$xml->paypal_notify_url = $_POST['setting_8'];
	$xml->credit_config = $_POST['setting_9'];
	$xml->credit_selected = $_POST['setting_10'];
	
	$xml->pack_1_price = $_POST['setting_12'];
	$xml->pack_1_credits = $_POST['setting_13'];
	$xml->pack_2_price = $_POST['setting_14'];
	$xml->pack_2_credits = $_POST['setting_15'];
	$xml->pack_3_price = $_POST['setting_16'];
	$xml->pack_3_credits = $_POST['setting_17'];
	$xml->pack_4_price = $_POST['setting_18'];
	$xml->pack_4_credits = $_POST['setting_19'];
	$xml->pack_5_price = $_POST['setting_20'];
	$xml->pack_5_credits = $_POST['setting_21'];
	$xml->pack_6_price = $_POST['setting_22'];
	$xml->pack_6_credits = $_POST['setting_23'];
	$xml->pack_7_price = $_POST['setting_24'];
	$xml->pack_7_credits = $_POST['setting_25'];
	$xml->pack_8_price = $_POST['setting_26'];
	$xml->pack_8_credits = $_POST['setting_27'];
	$xml->pack_9_price = $_POST['setting_28'];
	$xml->pack_9_credits = $_POST['setting_29'];
	$xml->pack_10_price = $_POST['setting_30'];
	$xml->pack_10_credits = $_POST['setting_31'];
	$save2 = $xml->asXML($xmlPath);
	

	if($save2) {
		message('success','[PayPal] Settings successfully saved.');
	} else {
		message('error','[PayPal] There has been an error while saving changes.');
	}

}

if(check_value($_POST['submit_changes'])) {
	saveChanges();
}

loadModuleConfigs('donation.paypal');

$creditSystem = new CreditSystem();
?>
<form action="" method="post">
	<table class="table table-striped table-bordered table-hover module_config_tables">
		<tr>
			<th>Status<br/><span>Enable/disable the paypal donation gateway.</span></th>
			<td>
				<? enabledisableCheckboxes('setting_2',mconfig('active'),'Enabled','Disabled'); ?>
			</td>
		</tr>
		<tr>
			<th>PayPal Sandbox Mode<br/><span>Enable/disable PayPal's IPN testing mode.<br/><br/>More info:<br/><a href="https://developer.paypal.com/" target="_blank">https://developer.paypal.com/</a></span></th>
			<td>
				<? enabledisableCheckboxes('setting_3',mconfig('paypal_enable_sandbox'),'Enabled','Disabled'); ?>
			</td>
		</tr>
		<tr>
			<th>PayPal Email<br/><span>PayPal email where you will receive the donations.</span></th>
			<td>
				<input style="width: 100%;" class="input-xxlarge" type="text" name="setting_4" value="<?=mconfig('paypal_email')?>"/>
			</td>
		</tr>
		<tr>
			<th>PayPal Donations Title<br/><span>Title of the PayPal donation. Example: "Donation for MU Credits".</span></th>
			<td>
				<input style="width: 100%;" class="input-xxlarge" type="text" name="setting_5" value="<?=mconfig('paypal_title')?>"/>
			</td>
		</tr>
		<tr>
			<th>Currency Code<br/><span>List of available PayPal currencies: <a href="https://cms.paypal.com/uk/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes" target="_blank">click here</a>.</span></th>
			<td>
				<input style="width: 100%;" class="input-xxlarge" type="text" name="setting_6" value="<?=mconfig('paypal_currency')?>"/>
			</td>
		</tr>
		<tr>
			<th>Return/Cancel URL<br/><span>URL where the client will be redirected to if the donation is cancelled or completed.</span></th>
			<td>
				<input style="width: 100%;" class="input-xxlarge" type="text" name="setting_7" value="<?=mconfig('paypal_return_url')?>"/>
			</td>
		</tr>
		<tr>
			<th>IPN Notify URL<br/><span>URL of WebEngine's PayPal API.<br/><br/> By default it has to be in: <b>http://YOURWEBSITE.COM/api/paypal.php</b></span></th>
			<td>
				<input style="width: 100%;" class="input-xxlarge" type="text" name="setting_8" value="<?=mconfig('paypal_notify_url')?>"/>
			</td>
		</tr>
		<tr>
			<th>Credit Configuration<br/><span>Elije el tipo de credito que el comprador va a recibir<br></span></th>
			<td>
				<?php echo $creditSystem->buildSelectInput("setting_9", mconfig('credit_config'), "form-control"); ?>
	   			 <input type="hidden" id="creditsValue" name="setting_10" value="<?=mconfig('credit_selected')?>" />
			</td>
		</tr>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script>
			$(".form-control").on('click', function(event){
				credits = $(".form-control option:selected").text();
 				document.getElementById("creditsValue").value = credits;
			});
		</script>
		
		<tr>
			<th>Configurar Pack 1<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_12" value="<?=mconfig('pack_1_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_13" value="<?=mconfig('pack_1_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 2<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_14" value="<?=mconfig('pack_2_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_15" value="<?=mconfig('pack_2_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 3<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_16" value="<?=mconfig('pack_3_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_17" value="<?=mconfig('pack_3_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 4<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_18" value="<?=mconfig('pack_4_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_19" value="<?=mconfig('pack_4_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 5<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_20" value="<?=mconfig('pack_5_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_21" value="<?=mconfig('pack_5_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 6<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_22" value="<?=mconfig('pack_6_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_23" value="<?=mconfig('pack_6_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 7<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_24" value="<?=mconfig('pack_7_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_25" value="<?=mconfig('pack_7_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 8<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_26" value="<?=mconfig('pack_8_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_27" value="<?=mconfig('pack_8_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 9<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_28" value="<?=mconfig('pack_9_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_29" value="<?=mconfig('pack_9_credits')?>"/>
			</td>
		</tr>
		<tr>
			<th>Configurar Pack 10<br/><span>Elije el precio y los Creditos que el cliente recibira al pagar  (0 = Deshabilita el pack)<br></span></th>
			<td>
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_30" value="<?=mconfig('pack_10_price')?>"/><br/>
		
				<input style="width: 20%;" class="input-xxlarge" type="text" name="setting_31" value="<?=mconfig('pack_10_credits')?>"/>
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit_changes" value="Save Changes" class="btn btn-success"/></td>
		</tr>
	</table>
</form>