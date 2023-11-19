<?php

require_once(dirname(__DIR__).'/config/autoload.config.php');


$db = new Database();
$login = new Login($db);

#
// Datenbank anlegen
if (!$db->query('CREATE DATABASE IF NOT EXISTS `my_database`;')) {
    die('Datenbank konnte nicht angelegt werden.');
}

// Datenbank auswählen
$db->query('USE `my_database`;');

// Tabelle für Benutzer anlegen
if (!$db->query('CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `role` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);')) {
    die('Tabelle `users` konnte nicht angelegt werden.');
}

// Tabelle für Gruppen anlegen
if (!$db->query('CREATE TABLE IF NOT EXISTS `groups` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
);')) {
    die('Tabelle `groups` konnte nicht angelegt werden.');
}

// Tabelle für Artikel anlegen
if (!$db->query('CREATE TABLE IF NOT EXISTS `items` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `unique_id` varchar(255) NOT NULL,
    `barcode` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `serial` varchar(255) NOT NULL,
    `quantity` int(11) NOT NULL,
    `group_id` int(11) NOT NULL,
    `date` datetime NOT NULL,
    `active` tinyint(1) NOT NULL,
    PRIMARY KEY (`id`)
);')) {
    die('Tabelle `items` konnte nicht angelegt werden.');
}



$password = password_hash('admin', PASSWORD_DEFAULT);

$sql = 'INSERT INTO `users` (
    `username`,
    `password`,
    `role`
) VALUES (
    ?,
    ?,
    ?
);';

// SQL-Anweisung vorbereiten
$stmt = $db->prepare($sql);

// Parameter binden
$stmt->bindValue(1, 'admin');
$stmt->bindValue(2, $password);
$stmt->bindValue(3, 'admin');

// Abfrage ausführen
$stmt->execute();

echo 'Die Installation ist erfolgreich abgeschlossen.';

?>
