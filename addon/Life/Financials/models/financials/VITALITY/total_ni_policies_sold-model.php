<?php

class VIT_Total_NI_Policies_SoldModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function VIT_getTotal_NI_Policies_Sold($DATEFROM, $DATETO) {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(*) AS policies_sold
FROM
    adl_policy
        JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
WHERE
    DATE(adl_policy_sub_date) BETWEEN :DATEFROM AND :DATETO
        AND adl_policy_insurer = 'Vitality'
        AND adl_policy_status = 'Live'
        AND vitality_policy_comms_type='Non Indemnity'");
        $stmt->bindParam(':DATEFROM', $DATEFROM, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $DATETO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>