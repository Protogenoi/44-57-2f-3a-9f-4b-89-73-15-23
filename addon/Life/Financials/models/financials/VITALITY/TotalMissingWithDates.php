<?php

class TotalMissingWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalMissingWithDates($datefrom, $dateto) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(vitality_policy.vitality_policy_comms) AS commission
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
        LEFT JOIN
    vitality_financial ON vitality_financial.vitality_financial_policy_number = adl_policy_ref
WHERE
    DATE(adl_policy_sub_date) BETWEEN :DATEFROM AND :DATETO
        AND adl_policy_ref NOT IN (SELECT 
            vitality_financial.vitality_financial_policy_number
        FROM
            financials)
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status = 'Live'");
        $stmt->bindParam(':DATEFROM', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>