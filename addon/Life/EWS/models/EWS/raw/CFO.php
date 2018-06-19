<?php

class RawCFOModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getRawCFO($EWS_DATE) {

        $stmt = $this->pdo->prepare('SELECT 
    COUNT(ews_status_status) AS EWS_STATUS_CFO
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE
        AND ews_status_status = "CFO"');
        $stmt->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>