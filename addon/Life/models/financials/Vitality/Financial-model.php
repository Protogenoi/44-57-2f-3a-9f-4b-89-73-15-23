<?php

class VITtransModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getVITtrans($search) {

        $stmt = $this->pdo->prepare("SELECT
            vitality_financial.vitality_financial_uploaded_date, 
            vitality_financial.vitality_financial_amount, 
            client_policy.type, 
            client_policy.policy_number, 
            client_policy.policystatus, 
            client_policy.closer, 
            client_policy.lead, 
            client_policy.id AS POLID 
        FROM 
            vitality_financial 
        JOIN 
            client_policy
        ON 
            vitality_financial.vitality_financial_policy_number = client_policy.policy_number 
        WHERE
            client_policy.client_id=:CID
        AND 
            client_policy.insurer='Vitality'
        GROUP BY 
            vitality_financial.vitality_financial_id
    ");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>