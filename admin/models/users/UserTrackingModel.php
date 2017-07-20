<?php

class UserTrackingModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getUserTracking() {

        $stmt = $this->pdo->prepare("SELECT 
    user_tracking_user,
    user_tracking_url,
    INET6_NTOA(user_tracking_ip) AS user_tracking_ip,
    user_tracking_date
FROM
    user_tracking
WHERE
    user_tracking_date >= CURDATE();");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>