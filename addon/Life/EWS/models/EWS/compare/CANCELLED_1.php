<?php

class COMPARECANCELLEDModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getCOMPARECANCELLED($EWS_DATE) {

        $stmt = $this->pdo->prepare('SELECT 
    COUNT(ews_status_status) AS EWS_STATUS_CANCELLED,
    SUM(clawback_due) AS EWS_CFO_LAPSED_SUM
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE
        AND warning IN ("CFO","Lapsed")');
        $stmt->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>