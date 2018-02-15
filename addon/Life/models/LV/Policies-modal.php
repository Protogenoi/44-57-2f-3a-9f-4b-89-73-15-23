<?php

class LVPoliciesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLVPolicies($search) {

        $stmt = $this->pdo->prepare("SELECT DISTINCT
                client_policy.policy_number, 
                client_policy.type, 
                client_policy.application_number, 
                client_policy.CommissionType, 
                client_policy.polterm, 
                lv_financial_indemnity, 
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
                lv_financial
            ON 
                client_policy.policy_number = lv_financial.lv_financial_policy
            WHERE 
                client_policy.client_id =:CID
            AND 
                insurer='LV' 
            GROUP BY 
                client_policy.policy_number");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>