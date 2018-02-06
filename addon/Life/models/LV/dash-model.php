<?php

class LV_DASH_Modal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLV_DASH($search) {

        $stmt = $this->pdo->prepare("SELECT application_number FROM client_policy WHERE insurer='LV' AND client_id= :CID");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>