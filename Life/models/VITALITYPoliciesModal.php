<?php

class VITALITYPoliciesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getVITALITYPolicies($search) {

        $stmt = $this->pdo->prepare("SELECT DISTINCT client_policy.policy_number, client_policy.type, client_policy.CommissionType, client_policy.polterm, client_policy.insurer, vitality_financials.vitality_comm, ews_data.ews_status_status AS ADLSTATUS, client_policy.id, client_policy.polterm, ews_data.warning, client_policy.closer, client_policy.covera, client_policy.lead, client_policy.client_id, client_policy.client_name, client_policy.premium, client_policy.submitted_by, client_policy.CommissionType, client_policy.PolicyStatus, client_policy.commission FROM client_policy LEFT JOIN vitality_financials ON client_policy.policy_number = vitality_financials.vitality_policy LEFT JOIN ews_data ON client_policy.policy_number = ews_data.policy_number WHERE client_policy.client_id =:CID AND insurer='Vitality' GROUP BY client_policy.policy_number");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>