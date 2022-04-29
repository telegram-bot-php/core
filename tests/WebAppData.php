<?php
require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$bot_token = 'YOUR_BOT_TOKEN'; // <-- Put your bot token here
$data_check_string = '_auth=query_id%3DAAHXonsPAAAAANeiew9V6BFt%26user%3D%257B%2522id%2522%253A259760855%252C%2522first_name%2522%253A%2522Shahrad%2522%252C%2522last_name%2522%253A%2522Elahi%2522%252C%2522username%2522%253A%2522ShahradElahi%2522%252C%2522language_code%2522%253A%2522en%2522%257D%26auth_date%3D1651256860%26hash%3D3622dcd0a5154867f6a4a589b17d43fc2d0d7a8712902989f39ec689e7bf7add&msg_id=&with_webview=0';

if (\TelegramBot\Telegram::validateWebData($bot_token, $data_check_string)) {
    echo 'SUCCESS: Data is from Telegram';
} else {
    echo 'FAIL: Data is NOT from Telegram';
}
