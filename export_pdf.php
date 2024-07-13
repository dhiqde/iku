<?php
require 'plugin/dompdf/vendor/autoload.php';

use Dompdf\Dompdf;

// Buat koneksi
$servername = "localhost";
$username = "root";
$password = "avbkiller99!";
$dbname = "it_tickets";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tickets";
$result = $conn->query($sql);

$html = '<h2>Laporan IKU</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nama Pemohon</th>
        <th>Departemen</th>
        <th>Jenis Permintaan</th>
        <th>Prioritas</th>
        <th>Deskripsi</th>
        <th>IKU Achieved</th>
        <th>IKU Formula</th>
        <th>Baseline</th>
        <th>Target</th>
        <th>Status</th>
    </tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $baseline = getBaselineDescription($row["priority"]);

        $html .= "<tr>";
        $html .= "<td>" . $row["id"] . "</td>";
        $html .= "<td>" . $row["requester_name"] . "</td>";
        $html .= "<td>" . $row["department"] . "</td>";
        $html .= "<td>" . $row["request_type"] . "</td>";
        $html .= "<td>" . $row["priority"] . "</td>";
        $html .= "<td>" . $row["description"] . "</td>";
        $html .= "<td>" . $row["iku_achieved"] . "</td>";
        $html .= "<td>" . $row["iku_formula"] . "</td>";
        $html .= "<td>" . $baseline . "</td>";
        $html .= "<td>" . $row["achievement"] . "</td>";
        $html .= "<td>" . $row["status"] . "</td>";
        $html .= "</tr>";
    }
} else {
    $html .= "<tr><td colspan='10'>Tidak ada tiket ditemukan.</td></tr>";
}

$html .= '</table>';

$conn->close();

// Instansiasi dan gunakan dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Opsional) Atur ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'landscape');

// Render HTML sebagai PDF
$dompdf->render();

// Output ke browser
$dompdf->stream("laporan_iku.pdf", ["Attachment" => 1]);

function getBaselineDescription($priority) {
    switch ($priority) {
        case 'Rendah':
            return "Waktu Penyelesaian (hari) <= 7";
        case 'Sedang':
            return "Waktu Penyelesaian (hari) <= 5";
        case 'Tinggi':
            return "Waktu Penyelesaian (hari) <= 3";
        case 'Kritis':
            return "Waktu Penyelesaian (hari) <= 1";
        default:
            return "";
    }
}
?>
