<?php

class VITALITY_NEW_PoliciesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getVITALITYPolicies($search) {

        $stmt = $this->pdo->prepare("SELECT 
    vitality_policy.vitality_policy_ref,
    vitality_policy.vitality_policy_plan,
    vitality_policy.vitality_policy_type,
    vitality_policy.vitality_policy_cover,
    vitality_policy.vitality_policy_cover_amount,
    vitality_policy.vitality_policy_id,
    vitality_policy.vitality_policy_policy_term,
    vitality_policy.vitality_policy_term_prem,
    vitality_policy.vitality_policy_premium,
    vitality_policy.vitality_policy_wellness,
    vitality_policy.vitality_policy_sic_opt,
    adl_policy.adl_policy_client_id_fk,
    adl_policy.adl_policy_policy_holder,
    adl_policy.adl_policy_status,
    adl_policy.adl_policy_ref,
    adl_policy.adl_policy_id,
    vitality_policy.vitality_policy_premium,
    vitality_policy.vitality_policy_comms,
    vitality_financial_amount,
    vitality_income_benefit_id
FROM
    adl_policy
		JOIN
    vitality_policy ON adl_policy.adl_policy_id = vitality_policy.vitality_policy_id_fk
            LEFT JOIN
    vitality_financial ON adl_policy.adl_policy_ref = vitality_financial.vitality_financial_policy_number
    LEFT  JOIN
    vitality_income_benefit ON adl_policy.adl_policy_id = vitality_income_benefit.vitality_income_benefit_id_fk
WHERE
    adl_policy_client_id_fk = :CID
        AND adl_policy.adl_policy_insurer = 'Vitality'");
        $stmt->bindParam(':CID', $search, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>