<?php

class POD4TeamPadModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function POD4getTeamPad() {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM,
    AVG(pad_statistics_col) AS AVG,
    pad_statistics_group
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='POD 4' GROUP BY pad_statistics_group");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>