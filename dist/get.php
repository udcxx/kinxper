<?php

    $params = json_decode(file_get_contents('php://input'), true);
    $url = 'https://'.$params['domain'].'.cybozu.com/k/v1/record.json?app='.$params['appId'].'&id='.$params['recordNo'];

    $headers = array(
        "X-Cybozu-API-Token:".$params['token']
    );

    // curl開始
    $curl = curl_init($url);

    // リクエストのオプションをセットしていく
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET'); // メソッド指定
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // レスポンスを文字列で受け取る
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    // レスポンスを $response へ入れる
    $response = curl_exec($curl);

    // curl終了
    curl_close($curl);

    // $response を返す
    echo($response);

?>
