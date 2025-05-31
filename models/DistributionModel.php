<?php
class DistributionModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function distributeDonation($donasi_id, $recipients, $token = null) {
        $donasi = $this->getDonationFromModul2($donasi_id, $token);
        // if ($donasi['type'] !== 'uang') throw new Exception("Hanya donasi uang yang bisa didistribusikan");

        $total_distributed = array_sum(array_column($recipients, 'amount'));
        if ($total_distributed > $donasi['qty']) throw new Exception("Total distribusi melebihi donasi");

        foreach ($recipients as $recipient) {
            $stmt = $this->conn->prepare("
                INSERT INTO distributions 
                (donasi_id, recipient_id, amount_received, unit, status) 
                VALUES (?, ?, ?, ?, 'diproses')
            ");
            $stmt->execute([
                $donasi_id,
                $recipient['id'],
                $recipient['amount'],
                $donasi['unit']
            ]);
        }

        return [
            'donasi_id' => $donasi['id'], // gunakan 'id' dari API eksternal
            'total_donasi' => $donasi['qty'],
            'total_distributed' => $total_distributed,
            'remaining' => $donasi['qty'] - $total_distributed
        ];
    }

    private function getDonationFromModul2($donasi_id, $token = null) {
        $api_url = "https://api-mdonasi-core.vercel.app/api/donasi/" . $donasi_id;

        $headers = [
            "Accept: application/json"
        ];
        if ($token) {
            // Cek apakah sudah ada kata 'Bearer'
            if (stripos($token, 'Bearer ') === 0) {
                $headers[] = "Authorization: $token";
            } else {
                $headers[] = "Authorization: Bearer $token";
            }
        }

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new Exception("cURL error saat mengambil data donasi: $curlError");
        }

        if ($httpCode === 401) {
            throw new Exception("Unauthorized. Token tidak valid atau tidak disertakan.");
        } elseif ($httpCode >= 400) {
            throw new Exception("HTTP error $httpCode saat mengambil data donasi: $response");
        }

        $data = json_decode($response, true);
        if (!isset($data['data'])) {
            throw new Exception("Data donasi tidak valid: " . $response);
        }

        return $data['data'];
    }
    /**
     * Mengambil daftar distribusi berdasarkan ID donasi
     *
     * @param int $donasi_id ID donasi
     * @return array Daftar distribusi
     */

    public function getDistributionsByDonationId($donasi_id) {
        // Ambil data distribusi
        $stmt = $this->conn->prepare("
            SELECT d.id as distribution_id, r.id as recipient_id, r.nama, r.alamat, d.amount_received, d.unit, d.status
            FROM distributions d
            JOIN recipients r ON d.recipient_id = r.id
            WHERE d.donasi_id = ?
        ");
        $stmt->execute([$donasi_id]);
        $distributions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Hitung total yang sudah didistribusikan
        $total_distributed = 0;
        foreach ($distributions as $dist) {
            $total_distributed += $dist['amount_received'];
        }

        // Ambil info donasi dari modul 2 (API eksternal)
        // Ambil token dari header jika perlu, atau sesuaikan dengan kebutuhan Anda
        $token = getallheaders()['Authorization'] ?? null;
        $donasi = $this->getDonationFromModul2($donasi_id, $token);

        return [
            'donasi_id' => $donasi['id'],
            'total_donasi' => $donasi['qty'],
            'total_distributed' => $total_distributed,
            'remaining' => $donasi['qty'] - $total_distributed,
            'distributions' => $distributions
        ];
    }

    public function updateDistributionStatus($distribution_id, $status) {
        $stmt = $this->conn->prepare("UPDATE distributions SET status = ? WHERE id = ?");
        $stmt->execute([$status, $distribution_id]);
        return $stmt->rowCount() > 0;
    }
}
?>