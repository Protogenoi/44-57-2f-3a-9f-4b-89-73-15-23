<?php

class TotalCANCELLEDModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalCANCELLED($datefrom, $dateto) {

        $stmt = $this->pdo->prepare('SELECT 
    COUNT(ews_status_status) AS EWS_STATUS_CANCELLED,
    SUM(clawback_due) AS EWS_CFO_LAPSED_SUM
FROM
    ews_data
WHERE
    DATE(date_added) BETWEEN :datefrom AND :dateto
        AND warning IN ("CFO NEW","Lapsed NEW")');
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>