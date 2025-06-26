<?php
   
    require 'class/class.php'; 

    loadModuleConfigs('donation.mercadopago');
    
    $raw_post_data = file_get_contents('php://input');
    $json_string = json_decode($raw_post_data, true);
    
    $myPost = array();
    $id = $json_string['data']['id'];
    $action = $json_string['action'];

    if($action == "payment.created" || $action == "payment.updated"){
     
        $ACCESS_TOKEN = mconfig('access_token');;
        $url = 'https://api.mercadopago.com/v1/payments/'.$id.'?access_token='.$ACCESS_TOKEN;

        $response = file_get_contents($url);

        if($response){
        
            $json = json_decode($response, true);
            
            //IP DEL COMPRADOR
            $check_ip_payed = $json["additional_info"]["ip_address"];
            //USUARIO DE MERCADO PAGO DEL COMPRADOR
            $check_user_mc_payed = $json["statement_descriptor"];
            //ID DE LA COMPRA
            $check_id_bought = $json["id"];
            //DESCRIPCION DE LA COMPRA
            $check_description = $json["description"];
            //NOMBRE DE LA TARJETA UTILIZADA
            $check_card = $json["payment_method_id"];
            //METODO DE PAGO
            $check_method_payed = $json["payment_type_id"];
            //Nombre propietario de la tarjeta
            $check_card_name = $json["card"]["cardholder"]["name"];
            //DNI propietario de la tarjeta
            $check_card_dni = $json["card"]["cardholder"]["identification"]["number"];
            //Fecha de cración
            $check_date_create = $json["date_created"];

            //Fecha de ultima actualización
            $check_last_date_update = $json["card"]["date_last_updated"];
            //MONTO PAGADO
            $check_total_payed = $json["transaction_amount"];
            //TIPO DE MONEDA DE PAGO
            $check_type_coin = $json["currency_id"];
            //ESTADO DE LA COMPRA
            $check_state = $json["status"];
            //DETALLE DEL ESTADO DE LA COMPRA
            $check_detail_state = $json["status_detail"];
            //Dato aprobado
            $check_date_approved = $json["date_approved"];
            
            //SEPARAMOS EL USUARIO Y LOS WCOINC DE LA DESCRIPCION DE LA COMPRA
            $datoCompra = explode ("|", $check_description);
            $userMu = $datoCompra[0];
            $Credits = $datoCompra[1];
            $descript = $datoCompra[2];

            //Buscamos el user Id
            $checkUserID = access_db::userID($userMu);
            foreach($checkUserID as $dat){
                $userID = $dat['memb_guid'];
            }

            //creamos un array con toda la info
            $data = array(
                'ip_payed' => $check_ip_payed,
                'userID' => $userID,
                'user_mercadoPago' => $check_user_mc_payed,
                'id_compra' => $check_id_bought,
                'userMu' => $userMu,
                'Credits' => $Credits,
                'descript' => $descript,
                'card' => $check_card,
                'card_method' => $check_method_payed,
                'card_name' => $check_card_name,
                'card_dni' => $check_card_dni,
                'card_date_create' => $check_date_create,
                'card_date_last_update' => $check_last_date_update,
                'card_mount' => $check_total_payed,
                'type_coin_payed' => $check_type_coin,
                'state_compra' => $check_state,
                'detail_compra' => $check_detail_state,
                'dato_aprobado' => $check_date_approved,
            );

            //Si no existe una base de datos de Mercado Pago La creamos!
            access_db::checkMcDbStatus();

                //BUSCAMOS EN LA DB QUE ESE ID ESTE REGISTRADO
                $checkDbId = access_db::checkDbId($id);

                //BUSCAMOS EN LA DB SI ESTA REGISTRADO COMO PAGADO
                $checkDbStatus = access_db::checkDbStatus($id);


            //MP INFORMA QUE EL PAGO ESTA APROBADO Y ACREDITADO 
            if($check_state === "approved" && $check_detail_state === "accredited"){
                
                //SI NO SE ENCUENTRÒ EL ID EN LA BASE DE DATOS, REGISTRAMOS EL NUEVO PAGO EN CASHOPDATA
                if(!$checkDbId){
                    access_db::success($userID, $Credits);
                    access_db::registerPayDb($data);

                }else{//<--- EL PAGO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS
                    if(!$checkDbStatus){//<-- EL PAGO NO ESTA REGISTRADO COMO Approved EN LA DB
                        access_db::success($userID, $Credits);  
                        access_db::Update($id, $check_state, $check_detail_state, $check_date_approved);
						
                    }
                }
            //Si el pago esta Pendiente u otro Motivo
            }else{
                //SI NO SE ENCUENTRÒ EL ID EN LA BASE DE DATOS, REGISTRAMOS EN LA DB DE MERCADO PAGO (Q EL PAGO NO ESTA SUCCESS)
                if(!$checkDbId){
                    access_db::registerPayDb($data);

                }
            }
           
            

             
        }
     
    }
?>