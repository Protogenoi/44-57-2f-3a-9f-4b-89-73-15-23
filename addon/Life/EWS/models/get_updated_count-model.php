<?php

class ews_updated_stats_model {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function get_ews_updated_stats_model() {

        $stmt = $this->pdo->prepare("SELECT 
    COUNT(*) AS TOTAL,
    SUM(CASE
        WHEN adl_ews_status = 'RE-INSTATED' THEN 1
        ELSE 0
    END) REINSTATED,
    SUM(CASE
        WHEN
            adl_ews_status = 'WILL CANCEL'
        THEN
            1
        ELSE 0
    END) WILL_CANCEL,
    SUM(CASE
        WHEN
            adl_ews_status = 'Redrawn'
        THEN
            1
        ELSE 0
    END) REDRAWN,
    SUM(CASE
        WHEN
            adl_ews_status = 'WILL REDRAW'
        THEN
            1
        ELSE 0
    END) WILL_REDRAW,
    SUM(CASE
        WHEN
            adl_ews_status = 'CANCELLED'
        THEN
            1
        ELSE 0
    END) CANCELLED,
    SUM(CASE
        WHEN
            adl_ews_status = 'FUTURE CALLBACK'
        THEN
            1
        ELSE 0
    END) FUTURE_CALLBACK
FROM
    adl_ews
");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}