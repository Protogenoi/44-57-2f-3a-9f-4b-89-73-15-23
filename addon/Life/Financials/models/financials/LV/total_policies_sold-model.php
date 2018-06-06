<?php

class LV_Total_Policies_SoldModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function LV_getTotal_Policies_Sold($LV_DATE_FROM, $LV_DATE_TO) {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(*) AS policies_sold
FROM
    client_policy
WHERE
    DATE(client_policy.sale_date) BETWEEN :DATEFROM AND :DATETO
        AND policystatus = 'Live'
        AND insurer = 'LV'
        AND CommissionType='Indemnity'");
        $stmt->bindParam(':DATEFROM', $LV_DATE_FROM, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $LV_DATE_TO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>