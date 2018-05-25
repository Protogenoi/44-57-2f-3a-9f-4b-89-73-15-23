<?php

class SCOTTISH_WIDOWS_TotalMissingWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function SCOTTISH_WIDOWS_getTotalMissingWithDates($datefrom, $dateto) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(client_policy.commission) AS commission
FROM
    client_policy
        LEFT JOIN
    lv_financial ON lv_financial.lv_financial_policy_number = client_policy.policy_number
WHERE
    DATE(client_policy.sale_date) BETWEEN :datefrom AND :dateto
        AND client_policy.policy_number NOT IN (SELECT 
            lv_financial.lv_financial_policy_number
        FROM
            lv_financial)
        AND client_policy.insurer = 'Scottish Widows'
        AND client_policy.policystatus = 'Live'");
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>