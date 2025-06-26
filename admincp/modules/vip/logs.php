<?php
/**
 * VIP
 * https://webenginecms.org/
 * 
 * @version 1.0.0
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2019 Lautaro Angelico, All Rights Reserved
 * @build wfd094c4936ed5b6323fd0fcab72ef68
 */

echo '<h1 class="page-header">VIP Credit System Logs</h1>';

$creditSystem = new CreditSystem();

echo '<div class="row">';

	echo '<div class="col-md-12">';
		
		echo '<div class="panel panel-default">';
		echo '<div class="panel-heading">Logs</div>';
		echo '<div class="panel-body">';
			$creditsLogs = $creditSystem->getLogs();
			if(is_array($creditsLogs)) {
				echo '<table id="credits_logs" class="table table-condensed table-hover">';
				echo '<thead>';
					echo '<tr>';
						echo '<th>Config</th>';
						echo '<th>Identifier Value</th>';
						echo '<th>Credits</th>';
						echo '<th>Transaction</th>';
						echo '<th>Date</th>';
						echo '<th>Module</th>';
						echo '<th>Ip</th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				foreach($creditsLogs as $data) {
					if($data['log_module'] != 'vip/order') continue;
					
					echo '<tr>';
						echo '<td>'.$data['log_config'].'</td>';
						echo '<td>'.$data['log_identifier'].'</td>';
						echo '<td>'.$data['log_credits'].'</td>';
						echo '<td><span class="label label-danger">Subtract</span></td>';
						echo '<td>'.date("Y-m-d H:i", $data['log_date']).'</td>';
						echo '<td>'.$data['log_module'].'</td>';
						echo '<td>'.$data['log_ip'].'</td>';
					echo '</tr>';
				}
				echo '
				</tbody>
				</table>';
			} else {
				message('warning', 'There are no logs to display.');
			}
		echo '</div>';
		echo '</div>';
		
	echo '</div>';
echo '</div>';