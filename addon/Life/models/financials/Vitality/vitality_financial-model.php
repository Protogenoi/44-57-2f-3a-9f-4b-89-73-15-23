<?php

class VIT_NEW_TRANModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getVIT_NEW_TRAN($search) {

        $stmt = $this->pdo->prepare("SELECT 
    vitality_financial.vitality_financial_uploaded_date,
    vitality_financial.vitality_financial_amount,
    vitality_policy.vitality_policy_type,
    adl_policy.adl_policy_ref,
    adl_policy.adl_policy_status,
    adl_policy.adl_policy_closer,
    adl_policy.adl_policy_agent,
    adl_policy.adl_policy_id AS POLID
FROM
    vitality_financial
        JOIN
    adl_policy ON vitality_financial.vitality_financial_policy_number = adl_policy.adl_policy_ref
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
WHERE
	adl_policy.adl_policy_client_id_fk=:CID
AND
    adl_policy.adl_policy_insurer = 'Vitality'
GROUP BY vitality_financial.vitality_financial_id
    ");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>