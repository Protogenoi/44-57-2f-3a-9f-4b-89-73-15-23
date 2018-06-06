<?php

class ZURICH_Total_NI_Policies_SoldModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function ZURICH_getTotal_NI_Policies_Sold($ZURICH_DATE_FROM, $ZURICH_DATE_TO) {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(*) AS policies_sold
FROM
    client_policy
WHERE
    DATE(client_policy.sale_date) BETWEEN :DATEFROM AND :DATETO
        AND policystatus = 'Live'
        AND insurer = 'Zurich'
        AND CommissionType='Non Idenmity'");
        $stmt->bindParam(':DATEFROM', $ZURICH_DATE_FROM, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $ZURICH_DATE_TO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>