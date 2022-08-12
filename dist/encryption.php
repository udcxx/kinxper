<?php

    $params = json_decode(file_get_contents('php://input'), true);
    $plain_api = $params['api'];

    $str = 'abcdefghijklmnopqrstuvwxyz0123456789!#$%&-*+?~';
    $rand = rand(10, 49);
    $Key = substr(str_shuffle(str_repeat($str, 10)), 0, $rand);
    $DispKey = substr(str_shuffle(str_repeat($str, 10)), 0, 5);

    require('secret.php');

    //暗号化
    $crypt_api = openssl_encrypt($data, 'AES-256-CBC', $Key, 0, $iv);

    // 有効期限設定
    $time = time() + (1 * 60 * 60 * 24);
    $exDate = date("Y-m-d", $time);

    // DB使用開始
    $db_info = 'mysql:dbname='.$db_name.';host='.$db_host.';charset=utf8mb4;';
    $pdo = new PDO($db_info, $db_user, $db_pass);

    // 登録
    try {
        $create =  $pdo->prepare("INSERT INTO api (`DispKey`, `Key`, `ExpirationDate`) VALUES(:DispKey, :Key, :ExpirationDate)");
        $create->bindValue(':DispKey', $DispKey, PDO::PARAM_STR);
        $create->bindValue(':Key', $Key, PDO::PARAM_STR);
        $create->bindValue(':ExpirationDate', $exDate, PDO::PARAM_STR);
        $create->execute();

        echo '{"disp-Key":"'.$DispKey.'", "token":"'.$crypt_api.'"}';
    } catch (PDOException $e) {
        // デバッグ用
        // echo '{"disp-Key":"'.$DispKey.'", "crypt":"'.$crypt_api.'", "Key":"'.$Key.'", "error😱":"'.$e.'", "db_name":"'.$db_name.'"}';
    }
?>
