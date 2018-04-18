<?php

class TotalAwaitingWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalAwaitingWithDates($datefrom, $dateto) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(vitality_policy.vitality_policy_comms) AS commission
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
WHERE
    DATE(adl_policy_sub_date) BETWEEN :DATEFROM AND :DATETO
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status = 'Awaiting'");
        $stmt->bindParam(':DATEFROM', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>