<?php

class TotalAwaitingWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalAwaitingWithDates($datefrom, $dateto) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(client_policy.commission) AS commission
FROM
    client_policy
        LEFT JOIN
    financial_statistics_history ON financial_statistics_history.policy = client_policy.policy_number
WHERE
    DATE(client_policy.submitted_date) BETWEEN :datefrom AND :dateto
        AND client_policy.insurer = 'Legal and General'
        AND client_policy.policystatus = 'Awaiting'");
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>