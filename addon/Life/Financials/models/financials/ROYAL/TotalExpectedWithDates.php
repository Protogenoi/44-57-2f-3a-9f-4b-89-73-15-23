<?php

class RL_TotalExpectedWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function RL_getTotalExpectedWithDates($RL_DATE_FROM, $RL_DATE_TO) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Royal London'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND client_policy.insurer = 'Royal London'
        AND policystatus = 'Awaiting'
        ");
        $stmt->bindParam(':datefrom', $RL_DATE_FROM, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $RL_DATE_TO, PDO::PARAM_STR);
        $stmt->bindParam(':datefrom2', $RL_DATE_FROM, PDO::PARAM_STR);
        $stmt->bindParam(':dateto2', $RL_DATE_TO, PDO::PARAM_STR);       
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>