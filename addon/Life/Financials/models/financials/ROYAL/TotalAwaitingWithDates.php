<?php

class RL_TotalAwaitingWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function RL_getTotalAwaitingWithDates($RL_DATE_FROM, $RL_DATE_TO) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(client_policy.commission) AS commission
FROM
    client_policy
        LEFT JOIN
    royal_london_financial ON royal_london_financial_plan_number = client_policy.policy_number
WHERE
    DATE(client_policy.submitted_date) BETWEEN :datefrom AND :dateto
        AND client_policy.insurer = 'Royal London'
        AND client_policy.policystatus = 'Awaiting'");
        $stmt->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>