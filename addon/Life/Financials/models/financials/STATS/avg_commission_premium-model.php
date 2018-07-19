<?php

class Comm_Prem_Stats_Model {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function VIT_Comm_Prem_Stats($DATEFROM, $DATETO) {

        $stmt = $this->pdo->prepare("SELECT 
    insurer,
    AVG(commission) AS avg_comm,
    AVG(premium) AS avg_prem,
    COUNT(id) AS policies_sold
FROM
    client_policy
WHERE
    DATE(sale_date) BETWEEN :DATEFROM AND :DATETO
AND
    CommissionType='Indemnity'
AND
    policystatus='Live'
GROUP BY insurer");
        $stmt->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}