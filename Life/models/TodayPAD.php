<?php

class TodayPadModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTodayPad($search) {

        $stmt = $this->pdo->prepare("SELECT pad_statistics_id, pad_statistics_lead, pad_statistics_closer, pad_statistics_notes, pad_statistics_status, pad_statistics_col FROM pad_statistics ORDER BY pad_statistics_update_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>