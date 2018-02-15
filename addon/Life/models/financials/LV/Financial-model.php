<?php

class LVtransModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLVtrans($search) {

        $stmt = $this->pdo->prepare("SELECT
            lv_financial.lv_financial_uploaded_date, 
            lv_financial.lv_financial_indemnity, 
            lv_financial.lv_financial_type, 
            client_policy.policy_number, 
            client_policy.policystatus, 
            client_policy.closer, 
            client_policy.lead, 
            client_policy.id AS POLID 
        FROM 
            lv_financial 
        JOIN 
            client_policy
        ON 
            lv_financial.lv_financial_policy = client_policy.policy_number 
        WHERE
            client_policy.client_id=:CID
        AND 
            client_policy.insurer='LV'
        GROUP BY 
            lv_financial.lv_financial_id
    ");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>