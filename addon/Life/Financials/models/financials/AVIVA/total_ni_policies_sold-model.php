<?php

class AVI_Total_NI_Policies_SoldModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function AVI_getTotal_NI_Policies_Sold($AVI_DATE_FROM, $AVI_DATE_TO) {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(*) AS policies_sold
FROM
    client_policy
WHERE
    DATE(client_policy.sale_date) BETWEEN :DATEFROM AND :DATETO
        AND policystatus = 'Live'
        AND insurer = 'Aviva'
        AND CommissionType='Non Idenmity'");
        $stmt->bindParam(':DATEFROM', $AVI_DATE_FROM, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $AVI_DATE_TO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>