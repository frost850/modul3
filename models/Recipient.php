<?php
class Recipient {
    public static function all() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM recipients");
        return $stmt->fetchAll();
    }

    public static function create($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO recipients (nik, name, address, category) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $data['nik'],
            $data['name'],
            $data['address'] ?? '',
            $data['category']
        ]);
        return ['id' => $pdo->lastInsertId()] + $data;
    }
}
