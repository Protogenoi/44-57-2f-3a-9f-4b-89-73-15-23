<?php

class RLPoliciesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getRLPolicies($search) {

        $stmt = $this->pdo->prepare("SELECT DISTINCT
                client_policy.policy_number, 
                client_policy.type, 
                client_policy.CommissionType, 
                client_policy.polterm, 
                royal_london_financial.royal_london_financial_commission_credit_amount, 
                royal_london_financial.royal_london_financial_commission_debits_amount, 
                client_policy.id, 
                client_policy.polterm, 
                client_policy.covera, 
                client_policy.client_id, 
                client_policy.client_name, 
                client_policy.premium,  
                client_policy.CommissionType, 
                client_policy.PolicyStatus, 
                client_policy.commission 
            FROM 
                client_policy
            LEFT JOIN 
                royal_london_financial
            ON 
                client_policy.policy_number = royal_london_financial.royal_london_financial_plan_number
            WHERE 
                client_policy.client_id =:CID
            AND 
                insurer='Royal London' 
            GROUP BY 
                client_policy.policy_number");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>