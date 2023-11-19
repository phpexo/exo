<?php

class Rights {

    private $db;
    private $user_id;

    public function __construct(Database $db) {
        $this->db = $db;
        $this->user_id = $_SESSION['user_id'];
    }

       /**
     * Gibt die Rechte für einen Benutzer zurück.
     *
     * @param int $user_id Benutzer-ID
     *
     * @return array Rechte
     */
    public function getRightsForUserId($user_id) {
        $sql = "SELECT * FROM rights WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $rights = [];
        while ($row = $stmt->fetch()) {
            $rights[] = $row['resource'] . ':' . $row['action'];
        }

        return $rights;
    }

    /**
     * Prüft, ob ein Benutzer eine bestimmte Aktion für ein bestimmtes Objekt ausführen darf.
     *
     * @param int $user_id Benutzer-ID
     * @param string $resource Objekt
     * @param string $action Aktion
     *
     * @return bool Erlaubnis
     */
    public function hasPermission($resource, $action) {
        $rights = $this->getRightsForUserId($this->user_id);

        foreach ($rights as $right) {
            if ($right == $resource . ':' . $action) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gewährt einem Benutzer eine bestimmte Aktion für ein bestimmtes Objekt.
     *
     * @param int $user_id Benutzer-ID
     * @param string $resource Objekt
     * @param string $action Aktion
     */
    public function grantPermission($user_id, $resource, $action) {
        if (!$this->hasPermission('Permission', 'grant')) {
            throw new Exception('nope');
        }
        $sql = "INSERT INTO rights (user_id, resource, action) VALUES (:user_id, :resource, :action)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':resource', $resource);
        $stmt->bindParam(':action', $action);
        $stmt->execute();
    }

    /**
     * Entzieht einem Benutzer eine bestimmte Aktion für ein bestimmtes Objekt.
     *
     * @param int $user_id Benutzer-ID
     * @param string $resource Objekt
     * @param string $action Aktion
     */
    public function revokePermission($user_id, $resource, $action) {
        if (!$this->hasPermission('Permission', 'revoke')) {
            throw new Exception('nope');
        }
        $sql = "DELETE FROM rights WHERE user_id = :user_id AND resource = :resource AND action = :action";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':resource', $resource);
        $stmt->bindParam(':action', $action);
        $stmt->execute();
    }
}
?>