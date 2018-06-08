<?php

class AUDIT_COUNT_Model {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getSingleClient() {

        $stmt = $this->pdo->prepare("SELECT 
    adl_audits_auditor, COUNT(*) AS adl_audits_count
FROM
    adl_audits
    WHERE adl_audits_date_added >= curdate()
GROUP BY adl_audits_auditor;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>