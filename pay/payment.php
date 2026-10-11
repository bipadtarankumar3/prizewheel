<?php 

$curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://pay.walletmaxpay.com/checkout/payment/create',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query(array('cus_name' => 'Mahadi','cus_email' => 'm@g.com','amount' => '10','success_url' => 'http://127.0.0.1:8000/success.php','cancel_url' => 'http://127.0.0.1:8000/cancel.php')),
                CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'app-key: Toml6uZtOuSco',
                'client-key: 7aESrCcsPOYdyw',
                'client-secret: 38003715',
                'client-position: http://127.0.0.1:8000',
                'Cookie: v10_session=6em4ldlc7vtd19mnso5sa163e285u8nt'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;
?>