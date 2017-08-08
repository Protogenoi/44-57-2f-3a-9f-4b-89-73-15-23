<?php

class HistoryTrackingModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getHistoryTracking() {

        $stmt = $this->pdo->prepare("SELECT 
tracking_history_user
    tracking_history_user,
    tracking_history_url,
    INET6_NTOA(tracking_history_ip) AS tracking_history_ip,
    tracking_history_date
FROM
   tracking_history
    ORDER BY
        tracking_history_date");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>