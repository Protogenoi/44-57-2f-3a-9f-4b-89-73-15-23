<?php

if (isset($datafrom)) {

    class TeamPadModal {

        protected $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getTeamPad($datefrom, $TEAM) {

            $stmt = $this->pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM,
    AVG(pad_statistics_col) AS AVG,
    pad_statistics_group
FROM
    pad_statistics
WHERE
    pad_statistics_added_date=:datefrom AND pad_statistics_group=:team GROUP BY pad_statistics_group");
            $stmt->bindParam(':team', $TEAM, PDO::PARAM_STR);
            $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }

} else {

    class TeamPadModal {

        protected $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getTeamPad($TEAM) {

            $stmt = $this->pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM,
    AVG(pad_statistics_col) AS AVG,
    pad_statistics_group
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group=:team GROUP BY pad_statistics_group");
            $stmt->bindParam(':team', $TEAM, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }

}
?>