<?php

class SCOTTISH_WIDOWS_TotalExpectedWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function SCOTTISH_WIDOWS_getTotalExpectedWithDates($datefrom, $dateto) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Scottish Widows'
        AND policystatus = 'Live'
        OR DATE(client_policy.submitted_date) BETWEEN :datefrom2 AND :dateto2
        AND policystatus = 'Awaiting'
        AND insurer = 'Scottish Widows'
        ");
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $stmt->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto2', $dateto, PDO::PARAM_STR);       
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>