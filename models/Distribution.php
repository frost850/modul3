<?php
class Distribution {
    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM distributions");
        return $stmt->fetchAll();
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO distributions (donation_id, schedule_date, status, location, admin_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['donation_id'],
            $data['schedule_date'],
            $data['status'] ?? 'PLANNED',
            $data['location'],
            $data['admin_id']
        ]);
        return ['id' => $pdo->lastInsertId()] + $data;
    }
}
