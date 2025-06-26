<?php
(!isLoggedIn()) ? redirect(1,'login') : null;

// Load PayPal Settings
loadModuleConfigs('donation.paypal');
$precio = null;
$monto = null;
$precios = [];
$montos = [];
for ($i = 0;$i <= 10; $i++){

	$precio = (int)mconfig('pack_'.$i.'_price');
	$monto = (int)mconfig('pack_'.$i.'_credits');

	if($precio ==! 0 && $monto ==! 0){

		$cantidadbotones = $i;
        $precios[] = $precio;
		$montos[] = $monto;

	}
}
$tipoDeMoneda = mconfig('paypal_currency');
$CantidadBtns = $cantidadbotones;
$valorWcoinc = $json_datos['valorWcoinc'];
$creditSelected = mconfig('credit_selected'); 

	
echo '<div class="page-content">';  
echo '<div class="page-title">'.lang('module_titles_txt_11',true).' &rarr; '.lang('module_titles_txt_21',true).'</div>'; 

if(mconfig('active')) {
						
						if(mconfig('paypal_enable_sandbox')) {
							echo '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';
						} else {
							echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">';
						}
							
							$order_id = md5(time());
							
							echo '
							<input type="hidden" name="cmd" value="_xclick" />
							<input type="hidden" name="business" value="'.mconfig('paypal_email').'" />
							<input type="hidden" name="item_name" value="'.mconfig('paypal_title').'" />
							<input type="hidden" name="item_number" value="'.$order_id.'" />
							<input type="hidden" name="currency_code" value="'.mconfig('paypal_currency').'" />';
							
							for($i = 0; $i < $CantidadBtns; $i++){
								
                    			echo '<div class="paypal-gateway-container">';  
                    			    echo '<div class="paypal-gateway-content">';  
                    			        echo '<div class="mercadopago-gateway-logo"></div>';
                				        echo '<div class="paypal-gateway-form"><div>$'.$precios[$i].' = '.$montos[$i].' '.$creditSelected.'</div></div>';
                				        echo '<div class="paypal-gateway-continue">
										           <button class="btn btn-success button" type="submit" name="amount" id="amount" value="'.$precios[$i].'" class="btn">Donar!</button>
                					          </div>';
                    			    echo '</div>';
								

                    			echo '</div><br>';
					  		 }
							
					
				  			echo '
							  <input type="hidden" name="no_shipping" value="1" />
							  <input type="hidden" name="shipping" value="0.00" />
							  <input type="hidden" name="return" value="'.mconfig('paypal_return_url').'" />
							  <input type="hidden" name="cancel_return" value="'.mconfig('paypal_return_url').'" />
							  <input type="hidden" name="notify_url" value="'.mconfig('paypal_notify_url').'" />
							  <input type="hidden" name="custom" value="'.Encode($_SESSION['userid']).'" />
							  <input type="hidden" name="no_note" value="1" />
							  <input type="hidden" name="tax" value="0.00" />
						</form>';
	
?>

<script type="text/javascript">
	document.getElementById('amount').onkeyup = function(ev) {
	  var num = 0;
	  var c = 0;
	  var event = window.event || ev;
	  var code = (event.keyCode) ? event.keyCode : event.charCode;
	  for(num=0;num<this.value.length;num++) {
		c = this.value.charCodeAt(num);
		if(c<48 || c>57) {
		  document.getElementById('result').innerHTML = '0';
		  return false;
		}
	  }
	  num = parseInt(this.value);
	  if(isNaN(num)) {
		document.getElementById('result').innerHTML = '0';
	  } else {
		var result = (<?php echo mconfig('paypal_conversion_rate'); ?>*num).toString();
		document.getElementById('result').innerHTML = result;
	  }
	}
	</script>
	
<?php
	
} else {
	message('error', lang('error_47',true));
}

echo '</div>';
	
?>