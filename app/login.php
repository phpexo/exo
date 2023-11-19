<?php
session_start();
// Datenbankverbindungsdaten laden
require_once(dirname(__DIR__).'../config/autoload.config.php');


// Datenbankverbindungsklasse erstellen
$db = new Database();

// Login-Klasse erstellen
$login = new Login($db);

// CSRF-Token prüfen
if (!isset($_POST['csrf_token']) || !$login->validateCSRFToken($_POST['csrf_token'])) {
    header('Location: /?csrf_token=error');

}

// Benutzernamen und Passwort aus Formulardaten lesen
$username = $_POST['username'];
$password = $_POST['password'];

// Login durchführen
if ($login->login($username, $password)) {
    // Login erfolgreich
    header('Location: index.php');
} else {
    // Login fehlgeschlagen
    header('Location: /?login=error');

}

?>