<?php

class ews_stats_model {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function get_ews_stats_model() {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(*) AS TOTAL,
    SUM(CASE
        WHEN adl_ews_status = 'NEW' THEN 1
        ELSE 0
    END) EWS_NEW,
    SUM(CASE
        WHEN
            adl_ews_status = 'NEW'
                AND adl_ews_orig_status LIKE '%lapse%'
        THEN
            1
        ELSE 0
    END) EWS_LAPSED,
    SUM(CASE
        WHEN
            adl_ews_status = 'NEW'
                AND adl_ews_orig_status LIKE '%DD Cancellation%'
                OR adl_ews_orig_status = 'Instruction cancelled by payer'
        THEN
            1
        ELSE 0
    END) EWS_DD_CANCELLED,
    SUM(CASE
        WHEN
            adl_ews_status = 'NEW'
                AND adl_ews_orig_status LIKE '%DD Rejection%'
                OR adl_ews_orig_status = 'Returned DD'
        THEN
            1
        ELSE 0
    END) EWS_DD_REJECT,
    SUM(CASE
        WHEN
            adl_ews_status = 'NEW'
                AND adl_ews_orig_status LIKE '%cancelled%'
        THEN
            1
        ELSE 0
    END) EWS_CANCELLED,
    SUM(CASE
        WHEN
            adl_ews_status = 'NEW'
                AND adl_ews_orig_status = 'Outstanding Premium'
        THEN
            1
        ELSE 0
    END) EWS_OUTSTANDING
FROM
    adl_ews
");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}