<?php

class LGtransModel {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getLGtrans($search) {

        $stmt = $this->pdo->prepare("SELECT 
    financial_statistics_history.*,
    client_policy.policy_number,
    client_policy.CommissionType,
    client_policy.policystatus,
    client_policy.closer,
    client_policy.lead,
    client_policy.id AS POLID
FROM
    financial_statistics_history
        JOIN
    client_policy ON financial_statistics_history.Policy = client_policy.policy_number
WHERE
    client_id = :CID
GROUP BY financial_statistics_history.id
    ");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>