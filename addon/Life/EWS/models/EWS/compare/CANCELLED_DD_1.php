<?php

class COMPARECANCELLED_DDModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getCOMPARECANCELLED_DD($EWS_DATE) {

        $stmt = $this->pdo->prepare('SELECT 
    COUNT(ews_status_status) AS EWS_STATUS_CANCELLED_DD
FROM
    ews_data
WHERE
    DATE(date_added) =:EWS_DATE
        AND warning ="CANCELLED DD"');
        $stmt->bindParam(':EWS_DATE', $EWS_DATE, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>