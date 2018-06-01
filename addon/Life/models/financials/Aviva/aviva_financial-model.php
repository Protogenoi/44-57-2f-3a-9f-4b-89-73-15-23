<?php

class AVIVA_transModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAVIVA_trans($search) {

        $stmt = $this->pdo->prepare("SELECT
            aviva_financial.aviva_financial_uploaded_date, 
            aviva_financial.aviva_financial_amount,
            aviva_financial.aviva_financial_type, 
            client_policy.policy_number, 
            client_policy.policystatus, 
            client_policy.closer, 
            client_policy.lead, 
            client_policy.id AS POLID 
        FROM 
            aviva_financial 
        JOIN 
            client_policy
        ON 
            aviva_financial.aviva_financial_policy = client_policy.policy_number 
        WHERE
            client_policy.client_id=:CID
        AND 
            client_policy.insurer='Aviva'
        GROUP BY 
            aviva_financial.aviva_financial_id
    ");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>