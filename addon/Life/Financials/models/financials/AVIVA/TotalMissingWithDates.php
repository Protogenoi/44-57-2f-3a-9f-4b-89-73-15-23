<?php

class AVI_TotalMissingWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function AVI_getTotalMissingWithDates($datefrom, $dateto) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(client_policy.commission) AS commission
FROM
    client_policy
        LEFT JOIN
    financials ON financials.financials_policy = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
        AND client_policy.policy_number NOT IN (SELECT 
            financials.financials_policy
        FROM
            financials)
        AND client_policy.insurer = 'Aviva'
        AND client_policy.policystatus = 'Live'");
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>