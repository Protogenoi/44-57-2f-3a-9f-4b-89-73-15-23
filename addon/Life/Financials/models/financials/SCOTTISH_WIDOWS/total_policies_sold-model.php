<?php

class SW_Total_Policies_SoldModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function SW_getTotal_Policies_Sold($SW_DATE_FROM, $SW_DATE_TO) {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(*) AS policies_sold
FROM
    client_policy
WHERE
    DATE(client_policy.sale_date) BETWEEN :DATEFROM AND :DATETO
        AND policystatus = 'Live'
        AND insurer = 'Scottish Widows'
        AND CommissionType='Indemnity'");
        $stmt->bindParam(':DATEFROM', $SW_DATE_FROM, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $SW_DATE_TO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>