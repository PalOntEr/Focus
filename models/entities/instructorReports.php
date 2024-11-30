<?php

require_once __DIR__.'/../../config/db.php';

class InstructorReportsModel {
    private $db;

    public function __construct() {
        $config = require __DIR__.'/../../config/config.php';
        $this->db = new Database($config['database']);
    }

    public function getPerCourseSalesFiltered($instructorId, $creationDate, $modificationDate, $categoryId, $courseId) {
        return $this->db->queryFetchAll("CALL sp_InstructorReports(1, ?, ?, ?, ?, ?)", [
            $instructorId,
            $creationDate,
            $modificationDate,
            $categoryId,
            $courseId
        ]);
    }

    public function getPerStudentSalesFiltered($purchaseId, $purchaseDate, $modificationDate, $userId, $courseId, $levelId, $paymentMethod, $paymentType, $paymentAmount) {
        return $this->db->queryFetchAll("CALL sp_Purchase(6, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $purchaseId,
            $purchaseDate,
            $modificationDate,
            $userId,
            $courseId,
            $levelId,
            $paymentMethod,
            $paymentType,
            $paymentAmount
        ]);
    }
}
?>