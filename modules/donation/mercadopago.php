<?php
(!isLoggedIn()) ? redirect(1,'login') : null;


// Mercado Pago SDK
include 'api/mercadopago/vendor/autoload.php';


// Load Mercadopago Settings Settings
loadModuleConfigs('mercadopago_currency');

$common = new common();
$accountInfo = $common->accountInformation($_SESSION['userid']);

for ($i = 0;$i <= 10; $i++){

	$precio = (int)mconfig('pack_'.$i.'_price');
	$monto = (int)mconfig('pack_'.$i.'_credits');

	if($precio ==! 0 && $monto ==! 0){

		$cantidadbotones = $i;
        $precios[] = $precio;
		$montos[] = $monto;

	}
}

$token = mconfig('access_token');
$titulo = mconfig('mercadopago_title');
$description= mconfig('mercadopago_description');
$tipoDeMoneda = mconfig('mercadopago_currency'); 
$user = $accountInfo[_CLMN_USERNM_];
$success =  mconfig('mercadopago_return_url');  
$returnApi = mconfig('mercadopago_api_return_url'); 
$creditSelected = mconfig('credit_selected'); 




        // Add Your credentials
        MercadoPago\SDK::setAccessToken($token);
        $preference = new MercadoPago\Preference();
        $item = new MercadoPago\Item();
        $item->id = "12345";
        $item->description = $description;
        $item->category_id = "home";
        $item->quantity = 1;
        $preference->back_urls = array(
            "success" => $success,
            "failure" => $success,
            "pending" => $success
        );
        $preference->auto_return = "approved";

        $preference->notification_url = $returnApi;
           

echo '<div class="page-content">';  
      echo '<div class="page-title"><span> Dona por WCoinC</span></div>';  

	            for($i = 0; $i < $cantidadbotones; $i++){

	                $item->title = $user.'|'.$montos[$i].'|'.$titulo;
	                $item->unit_price = $precios[$i];
	                $preference->items = array($item);
	                $preference->save();

                    echo '<div class="paypal-gateway-container">';  
                        echo '<div class="paypal-gateway-content">';  
                            echo '<div class="mercadopago-gateway-logo"></div>';
                	        echo '<div class="paypal-gateway-form"><div>$'.$precios[$i].' = '.$montos[$i].' '.$creditSelected.'</div></div>';
                	        echo '<div class="paypal-gateway-continue">
                           <a class="btn btn-success" href="'.$preference->init_point.'" target="_blank">Donar!</a>
                		          </div>';
                        echo '</div>';
                    echo '</div><br>';
	            }

echo '</div>';

?>
