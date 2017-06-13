<?php

class TotalWILL_REDRAWModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalWILL_REDRAW($datefrom, $dateto) {

        $stmt = $this->pdo->prepare('SELECT 
    COUNT(warning) AS EWS_STATUS_WILL_REDRAW
FROM
    ews_data
WHERE
    DATE(date_added) BETWEEN :datefrom AND :dateto
        AND warning = "WILL REDRAW"');
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>