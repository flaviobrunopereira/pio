<?php


require_once '..\config\config.php';

function getData() {

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $CFG->backend,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => $CFG->backend_timeout,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\r\n\t\"ou\":\"ISCAC\",\r\n\t\"academicSystem\":\"nonio\",\r\n\t\"language\":\"PT\"\r\n\t\r\n}",
        CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            "Accept-Encoding: gzip, deflate",
            "Authorization: Basic aXNjYWM6Zmhoam1jMzQ0JiZIb3BkcDQ1",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Content-Length: 69",
            "Content-Type: application/json",
            "Cookie: ROUTEID=.node1",
            "Host: pio.intranet.ipc.pt",
            "Postman-Token: 1170d5f5-efc4-4479-83dc-e8a615785775,2fe30e27-7fca-40c5-97b2-3717ce71e196",
            "cache-control: no-cache"
        ),
    ));


    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {

        return $response;
    }
}



 getData();