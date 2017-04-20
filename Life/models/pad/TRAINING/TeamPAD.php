<?php

    class TRAININGTeamPadModal {

        protected $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function TRAININGgetTeamPad($datefrom) {
if (isset($datefrom)) {
            $stmt = $this->pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM,
    AVG(pad_statistics_col) AS AVG,
    pad_statistics_group
FROM
    pad_statistics
WHERE
   DATE(pad_statistics_added_date)=:datefrom AND pad_statistics_group='TRAINING'");
            $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        if (!isset($datefrom)) {

            $stmt = $this->pdo->prepare("SELECT 
    SUM(pad_statistics_col) AS COMM,
    AVG(pad_statistics_col) AS AVG,
    pad_statistics_group
FROM
    pad_statistics
WHERE
    pad_statistics_added_date >= CURDATE() AND pad_statistics_group='TRAINING'");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


}
    }
?>