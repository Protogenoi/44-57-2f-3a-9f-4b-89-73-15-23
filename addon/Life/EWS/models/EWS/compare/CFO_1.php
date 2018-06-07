<?php

class COMPARECFOModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getCOMPARECFO($EWS_DATE) {

        $stmt = $this->pdo->prepare('SELECT 
    COUNT(ews_status_status) AS EWS_STATUS_CFO
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE
        AND warning ="CFO"');
        $stmt->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>