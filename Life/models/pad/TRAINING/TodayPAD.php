<?php

if (isset($datafrom)) {  
    
    class TRAININGTodayPadModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function TRAININGgetTodayPad($datefrom) {

        $stmt = $this->pdo->prepare("SELECT 
    pad_statistics_group,
    pad_statistics_id,
    pad_statistics_lead,
    pad_statistics_closer,
    pad_statistics_notes,
    pad_statistics_status,
    pad_statistics_col,
    DATE(pad_statistics_update_date) AS pad_statistics_update_date,
    pad_statistics_group
FROM
    pad_statistics
WHERE
    DATE(pad_statistics_update_date)=:datefrom  AND pad_statistics_group='Training'
ORDER BY pad_statistics_added_date DESC");
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
    
} else {

class TRAININGTodayPadModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function TRAININGgetTodayPad() {

        $stmt = $this->pdo->prepare("SELECT 
    pad_statistics_group,
    pad_statistics_id,
    pad_statistics_lead,
    pad_statistics_closer,
    pad_statistics_notes,
    pad_statistics_status,
    pad_statistics_col,
    DATE(pad_statistics_update_date) AS pad_statistics_update_date,
    pad_statistics_group
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='Training'
ORDER BY pad_statistics_added_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

}

?>