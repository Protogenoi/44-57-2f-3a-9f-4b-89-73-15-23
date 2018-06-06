<?php

class RL_Total_Policies_SoldModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function RL_getTotal_Policies_Sold($RL_DATE_FROM, $RL_DATE_TO) {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(*) AS policies_sold
FROM
    client_policy
WHERE
    DATE(client_policy.sale_date) BETWEEN :DATEFROM AND :DATETO
        AND policystatus = 'Live'
        AND insurer = 'Royal London'
        AND CommissionType='Indemnity'");
        $stmt->bindParam(':DATEFROM', $RL_DATE_FROM, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $RL_DATE_TO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>