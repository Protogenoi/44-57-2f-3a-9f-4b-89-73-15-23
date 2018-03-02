<?php

class WOLPoliciesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getWOLPolicies($search) {

        $stmt = $this->pdo->prepare("SELECT DISTINCT
                client_policy.policy_number, 
                client_policy.type, 
                client_policy.CommissionType, 
                client_policy.polterm, 
                one_family_financial.one_family_financial_commission_amount, 
                one_family_financial.one_family_financial_transaction_type, 
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
                one_family_financial
            ON 
                client_policy.policy_number = one_family_financial.one_family_financial_policy_id
            WHERE 
                client_policy.client_id =:CID
            AND 
                insurer='One Family' 
            AND one_family_financial_transaction_type IN('BACS_OUT ','INTCOMCB')   
            GROUP BY 
                client_policy.policy_number");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>