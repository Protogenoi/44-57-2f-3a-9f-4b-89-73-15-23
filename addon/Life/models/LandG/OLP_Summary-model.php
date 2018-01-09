<?php

class OLP_SUMModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getOLP_SUM($search) {

        $stmt = $this->pdo->prepare("SELECT policy_number FROM client_policy WHERE insurer='Legal and General' AND client_id= :CID");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>