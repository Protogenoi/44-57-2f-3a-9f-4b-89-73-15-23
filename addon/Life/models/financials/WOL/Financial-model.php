<?php

class WOLtransModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getWOLtrans($search) {

        $stmt = $this->pdo->prepare("SELECT
            one_family_financial.one_family_financial_uploaded_date, 
            one_family_financial.one_family_financial_commission_amount, 
            one_family_financial.one_family_financial_transaction_type, 
            client_policy.policy_number, 
            client_policy.policystatus, 
            client_policy.closer, 
            client_policy.lead, 
            client_policy.id AS POLID 
        FROM 
            one_family_financial 
        JOIN 
            client_policy
        ON 
            one_family_financial.one_family_financial_policy_id = client_policy.policy_number 
        WHERE
            client_policy.client_id=:CID
        AND 
            client_policy.insurer='One Family'
        GROUP BY 
            one_family_financial.one_family_financial_id
    ");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>