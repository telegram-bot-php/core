<?php
require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$bot_token = \TelegramBot\Util\DotEnv::load(__DIR__ . '/../.env')->get('TELEGRAM_API_KEY');
$data_check_string = '_auth=query_id%3DAAHXonsPAAAAANeiew-6zYAa%26user%3D%257B%2522id%2522%253A259760855%252C%2522first_name%2522%253A%2522Shahrad%2522%252C%2522last_name%2522%253A%2522Elahi%2522%252C%2522username%2522%253A%2522ShahradElahi%2522%252C%2522language_code%2522%253A%2522en%2522%257D%26auth_date%3D1651423697%26hash%3D08de7d544550c801a6fdfabc0a1505c311e408ae31f39692940189b4eb898c0e&msg_id=&with_webview=0';

if (\TelegramBot\Telegram::validateWebData($bot_token, $data_check_string)) {
    echo 'Data is from Telegram';
} else {
    echo 'Data is NOT from Telegram';
}