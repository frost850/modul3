<?php
class RecipientModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Tambah penerima baru (hanya admin)
    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO recipients (nama, alamat) 
            VALUES (?, ?)
        ");
        $stmt->execute([$data['nama'], $data['alamat']]);
        return $this->conn->lastInsertId();
    }

    // Ambil data penerima (bisa semua atau by ID)
    public function get($id = null) {
        if ($id) {
            $stmt = $this->conn->prepare("
                SELECT * FROM recipients 
                WHERE id = ? AND is_active = TRUE
            ");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $this->conn->query("
            SELECT * FROM recipients 
            WHERE is_active = TRUE
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update data penerima (hanya admin)
    public function update($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE recipients 
            SET nama = ?, alamat = ? 
            WHERE id = ? AND is_active = TRUE
        ");
        return $stmt->execute([$data['nama'], $data['alamat'], $id]);
    }

    // Soft delete (hanya admin)
    public function delete($id) {
        $stmt = $this->conn->prepare("
            UPDATE recipients 
            SET is_active = FALSE 
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

    // Restore penerima yang dihapus (hanya admin)
    public function restore($id) {
        $stmt = $this->conn->prepare("
            UPDATE recipients 
            SET is_active = TRUE 
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
?>