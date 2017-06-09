<?php

class UserModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getUser() {

        $stmt = $this->pdo->prepare("SELECT company, id, login, pw, access_level, active, real_name FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>