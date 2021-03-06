<?php

class WOL_TotalAwaitingWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function WOL_getTotalAwaitingWithDates($datefrom, $dateto) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(client_policy.commission) AS commission
FROM
    client_policy
        LEFT JOIN
    one_family_financial ON one_family_financial.one_family_financial_policy_id = client_policy.policy_number
WHERE
    DATE(client_policy.submitted_date) BETWEEN :datefrom AND :dateto
        AND client_policy.insurer = 'One Family'
        AND client_policy.policystatus = 'Awaiting'");
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>