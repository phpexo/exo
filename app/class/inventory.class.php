<?php

class Lagerverwaltung {

private $db;
private $rights;
private $user_id;

public function __construct($db) {
    $this->db = $db;
    $this->rights = new Rights($db);
    $this->user_id = $_SESSION['user_id'];

}

// Gruppe erstellen

public function createGruppe($name) {
    if (!$this->rights->hasPermission('group', 'create')) {
        throw new Exception('nope');
    }
    $sql = "INSERT INTO gruppen (name) VALUES (?)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(1, $name);
    $stmt->execute();

    return $this->db->lastInsertId();
}

// Gruppe finden

public function getGruppe($id) {
    $sql = "SELECT * FROM gruppen WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    return $stmt->fetch();
}


function getGroupsForSelect() {
    $db = new Database();

    // Alle Gruppen abfragen
    $sql = "SELECT * FROM groups";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // Ergebnisse in einem Array speichern
    $groups = [];
    while ($row = $stmt->fetch()) {
        $groups[] = $row;
    }

    // Optionen für das Auswahlfeld generieren
    $options = '';
    foreach ($groups as $group) {
        $options .= '<option value="' . $group['id'] . '">' . $group['name'] . '</option>';
    }

    return $options;
}

// Gruppenliste abrufen

public function getallGruppen() {
    $sql = "SELECT * FROM gruppen";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

// Gruppe aktualisieren

public function updateGruppe($id, $name) {
    if (!$this->rights->hasPermission('group', 'update')) {
        throw new Exception('nope');
    }
    $sql = "UPDATE gruppen SET name = ? WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $id);
    $stmt->execute();
}

// Gruppe löschen

public function deleteGruppe($id) {
    if (!$this->rights->hasPermission('group', 'delete')) {
        throw new Exception('nope');
    }
    $sql = "DELETE FROM gruppen WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
}

// Item erstellen

public function createItem($unique_id, $barcode, $name, $serial, $quantity, $group_id, $date, $active) {
    if (!$this->rights->hasPermission('item', 'create')) {
        throw new Exception('nope');
    }

    // Prüfen, ob alle erforderlichen Parameter vorhanden sind

    if (!isset($unique_id) || !isset($barcode) || !isset($name) || !isset($quantity) || !isset($group_id)) {
        return false;
    }

    // SQL-Statement erstellen

    $sql = "INSERT INTO items (barcode, name, serial, quantity, group_id, date, active) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Parameter an das SQL-Statement binden

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(1, $barcode);
    $stmt->bindParam(2, $name);
    $stmt->bindParam(3, $serial);
    $stmt->bindParam(4, $quantity);
    $stmt->bindParam(5, $group_id);
    $stmt->bindParam(6, $date);
    $stmt->bindParam(7, $active);

    // SQL-Statement ausführen

    $stmt->execute();

    // ID des neu erstellten Items zurückgeben

    return $this->db->lastInsertId();
}


// Item finden

public function getItem($id) {
    $sql = "SELECT * FROM items WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    return $stmt->fetch();
}

// Itemliste abrufen

public function getallItems() {
    $sql = "SELECT * FROM items";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll();
}

public function getGroupNameById($id) {
    // Gruppe mit der ID abfragen
    $sql = "SELECT name FROM groups WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Ergebnisse in einem Array speichern
    $groups = [];
    while ($row = $stmt->fetch()) {
        $groups[] = $row;
    }

    // Gruppe zurückgeben
    return $groups[0]['name'];
}


public function getItemsTable() {
    if (!$this->rights->hasPermission('item', 'view')) {
        throw new Exception('nope');
    }
    // Nur aktive Items abfragen
    $sql = "SELECT * FROM items WHERE active = 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    // Ergebnisse in einem Array speichern
    $items = [];
    while ($row = $stmt->fetch()) {
        $items[] = $row;
    }
    $table = NULL;
    foreach ($items as $item) {
        $table .= '<tr>';
        $table .= '<td>' . $item['barcode'] . '</td>';
        $table .= '<td>' . $item['name'] . '</td>';
        $table .= '<td>' . $item['serial'] . '</td>';
        $table .= '<td>' . $item['quantity'] . '</td>';
        $table .= '<td>' . $this->getGroupNameById($item['group_id']) . '</td>';
        $table .= '</tr>';
    }

    return $table;
}

public function getmyItemsTable() {
    // Nur aktive Items abfragen
    $sql = "SELECT * FROM items_user WHERE active = 1 AND user_id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Ergebnisse in einem Array speichern
    $items = [];
    while ($row = $stmt->fetch()) {
        $items[] = $row;
    }
    $table = NULL;
    foreach ($items as $objekt) {
        $item = $this->getItem($objekt['item_id']);
        $table .= '<tr>';
        $table .= '<td>' . $item['barcode'] . '</td>';
        $table .= '<td>' . $item['name'] . '</td>';
        $table .= '<td>' . $item['serial'] . '</td>';
        $table .= '<td>' . $objekt['return_date'] . '</td>';
        $table .= '</tr>';
    }

    return $table;
}

// Item aktualisieren

public function updateItem($id, $unique_id, $barcode, $name, $serial, $quantity, $group_id, $date, $active) {
    if (!$this->rights->hasPermission('group', 'update')) {
        throw new Exception('nope');
    }

    // Prüfen, ob alle erforderlichen Parameter vorhanden sind

    if (!isset($id) || !isset($unique_id) || !isset($barcode) || !isset($name) || !isset($quantity) || !isset($group_id)) {
        return false;
    }

    // SQL-Statement erstellen

    $sql = "UPDATE items SET barcode = ?, name = ?, serial = ?, quantity = ?, group_id = ?, date = ?, active = ? WHERE id = ?";

    // Parameter an das SQL-Statement binden

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(1, $barcode);
    $stmt->bindParam(2, $name);
    $stmt->bindParam(3, $serial);
    $stmt->bindParam(4, $quantity);
    $stmt->bindParam(5, $group_id);
    $stmt->bindParam(6, $date);
    $stmt->bindParam(7, $active);
    // SQL-Statement ausführen

    $stmt->execute();

    // Anzahl der betroffenen Zeilen zurückgeben

    return $stmt->rowCount();
}

public function searchItems($searchTerm) {

    // SQL-Statement erstellen

    $sql = "SELECT * FROM items WHERE MATCH (name, unique_id, barcode, serial) AGAINST (? IN BOOLEAN MODE)";

    // Parameter an das SQL-Statement binden

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(1, $searchTerm);

    // SQL-Statement ausführen

    $stmt->execute();

    // Ergebnisse zurückgeben

    return $stmt->fetchAll();
}




}
?>