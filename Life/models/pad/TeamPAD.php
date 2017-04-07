<?php

class TeamPadModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTeamPad() {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM,
    AVG(pad_statistics_col) AS AVG,
    pad_statistics_group
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() GROUP BY pad_statistics_group");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>