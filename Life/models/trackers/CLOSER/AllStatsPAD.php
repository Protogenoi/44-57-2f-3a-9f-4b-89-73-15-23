<?php

    class AllSTATSPadModal {

        protected $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function AllgetSTATSPad($datefrom, $CLOSER) {
if (isset($datefrom)) {
            $stmt = $this->pdo->prepare("SELECT 
    count(mtg) AS mtg
FROM
    closer_trackers
WHERE
    DATE(date_added) = :datefrom
        AND mtg='Yes'");
            $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
if (!isset($datefrom)) {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(mtg) AS mtg
FROM
    closer_trackers
WHERE
    mtg = 'Yes'
        AND DATE(date_added) = CURDATE()");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
    }

?>