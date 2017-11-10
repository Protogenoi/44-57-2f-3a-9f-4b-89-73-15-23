<?php

class WOLtransModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getWOLtrans($search) {

        $stmt = $this->pdo->prepare("SELECT
            financials.financials_insert, 
            financials.financials_payment, 
            client_policy.type, 
            client_policy.policy_number, 
            client_policy.policystatus, 
            client_policy.closer, 
            client_policy.lead, 
            client_policy.id AS POLID 
        FROM 
            financials 
        JOIN 
            client_policy
        ON 
            financials.financials_policy = client_policy.policy_number 
        WHERE
            client_policy.client_id=:CID
        AND 
            financials.financials_provider='One Family'
        GROUP BY 
            financials.financials_id
    ");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>