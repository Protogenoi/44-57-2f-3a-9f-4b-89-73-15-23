<?php

class TotalREDRAWNModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalREDRAWN($datefrom, $dateto) {

        $stmt = $this->pdo->prepare('SELECT 
    COUNT(warning) AS EWS_STATUS_REDRAWN
FROM
    ews_data
WHERE
    DATE(date_added) BETWEEN :datefrom AND :dateto
        AND warning = "REDRAWN"');
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>