<?php

class AEGON_PoliciesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAEGONPolicies($search) {

        $stmt = $this->pdo->prepare("SELECT 
    aegon_policy.aegon_policy_ref,
    aegon_policy.aegon_policy_type,
    aegon_policy.aegon_policy_cover_amount,
    aegon_policy.aegon_policy_id,
    aegon_policy.aegon_policy_policy_term,
    aegon_policy.aegon_policy_premium,
    adl_policy.adl_policy_client_id_fk,
    adl_policy.adl_policy_policy_holder,
    adl_policy.adl_policy_status,
    adl_policy.adl_policy_ref,
    adl_policy.adl_policy_id,
    aegon_policy.aegon_policy_premium,
    aegon_policy.aegon_policy_comms
FROM
    adl_policy
		JOIN
    aegon_policy ON adl_policy.adl_policy_id = aegon_policy.aegon_policy_id_fk
            LEFT JOIN
    vitality_financial ON adl_policy.adl_policy_ref = vitality_financial.vitality_financial_policy_number
WHERE
    adl_policy_client_id_fk = :CID
        AND adl_policy.adl_policy_insurer = 'Aegon'
GROUP BY
adl_policy_ref");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>