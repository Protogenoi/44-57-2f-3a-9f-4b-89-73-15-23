<?php

class HistoryTrackingModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getHistoryTracking($TRACKING_USER,$TRACKING_DATE, $TRACKING_DATE_TO) {

        $stmt = $this->pdo->prepare("SELECT 
tracking_history_user
    tracking_history_user,
    tracking_history_url,
    INET6_NTOA(tracking_history_ip) AS tracking_history_ip,
    tracking_history_date
FROM
   tracking_history
WHERE
    DATE(tracking_history_date) BETWEEN :DATE AND :DATETO
AND
    tracking_history_user=:USER
    ORDER BY
        tracking_history_date");
        $stmt->bindParam(':USER', $TRACKING_USER, PDO::PARAM_STR);
        $stmt->bindParam(':DATE', $TRACKING_DATE, PDO::PARAM_STR);
        $stmt->bindParam(':DATETO', $TRACKING_DATE_TO, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>