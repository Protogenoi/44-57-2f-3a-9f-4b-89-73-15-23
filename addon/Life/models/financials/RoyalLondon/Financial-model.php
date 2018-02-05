<?php

class RLtransModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getRLtrans($search) {

        $stmt = $this->pdo->prepare("SELECT
            royal_london_financial.royal_london_financial_uploaded_date, 
            royal_london_financial.royal_london_financial_commission_credit_amount, 
            royal_london_financial.royal_london_financial_commission_debits_amount,
            royal_london_financial.royal_london_financial_commission_type, 
            client_policy.policy_number, 
            client_policy.policystatus, 
            client_policy.closer, 
            client_policy.lead, 
            client_policy.id AS POLID 
        FROM 
            royal_london_financial 
        JOIN 
            client_policy
        ON 
            royal_london_financial.royal_london_financial_plan_number = client_policy.policy_number 
        WHERE
            client_policy.client_id=:CID
        AND 
            client_policy.insurer='Royal London'
        GROUP BY 
            royal_london_financial.royal_london_financial_id
    ");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>