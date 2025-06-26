<h1 class="page-header">MercadoPago Donations</h1>
<?php
try {
	$database = (config('SQL_USE_2_DB',true) ? $dB2 : $dB);
	
	$mercadopagolDonations = $database->query_fetch("SELECT * FROM ".WEBENGINE_MERCADOPAGO_TRANSACTIONS." ORDER BY id DESC");
	if(!is_array($mercadopagolDonations)) throw new Exception("There are no MercadoPago transactions in the database.");
	
	echo '<table id="paypal_donations" class="table table-condensed table-hover">';
	echo '<thead>';
		echo '<tr>';
			echo '<th>Transaction ID</th>';
			echo '<th>Account</th>';
			echo '<th>Amount</th>';
			echo '<th>User MP</th>';
			echo '<th>Date</th>';
			echo '<th>Status</th>';
		echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	foreach($mercadopagolDonations as $data) {
		$userData = $common->accountInformation($data['userID']);
		$donation_status = ($data['state_compra'] == "approved" ? '<span class="badge badge-success">ok</span>' : '<span class="badge badge-important">reversed</span>');
        
		if($data['dato_aprobado']){
			$fecha = $data['dato_aprobado'];
		}else{
			$fecha = $data['card_date_create'];
		}
		$convert = date('d-m-Y H:i:s', strtotime($fecha));

		echo '<tr>'; 
			echo '<td>'.$data['id_compra'].'</td>';
			echo '<td><a href="'.admincp_base("accountinfo&id=".$data['userID']).'">'.$userData[_CLMN_USERNM_].'</a></td>';
			echo '<td>$'.$data['card_mount'].'</td>';
			echo '<td>'.$data['user_mercadoPago'].'</td>';
			echo '<td>'.$convert.'</td>';
			echo '<td>'.$donation_status.'</td>';
		echo '</tr>';
	}
	echo '
	</tbody>
	</table>';
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}
?>