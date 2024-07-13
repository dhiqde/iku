<?php
$servername = "localhost";
$username = "root";
$password = "avbkiller99!";
$dbname = "it_tickets";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination
$limit = 5; // Jumlah baris per halaman
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM tickets LIMIT $start, $limit";
$result = $conn->query($sql);

$sql_count = "SELECT COUNT(id) AS total FROM tickets";
$count_result = $conn->query($sql_count);
$row = $count_result->fetch_assoc();
$total = $row['total'];
$pages = ceil($total / $limit);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan IKU</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px #999;
        }

        .button:hover {background-color: #45a049}

        .button:active {
            background-color: #45a049;
            box-shadow: 0 2px #666;
            transform: translateY(2px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .download-link {
            margin-top: 20px;
            display: block;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            width: fit-content;
            margin: auto;
        }

        .download-link:hover {
            background-color: #45a049;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            color: #333;
            padding: 10px 15px;
            text-decoration: none;
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 0 2px;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .pagination .active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Laporan IKU</h2>

    <div class="back-button">
        <button class="button" onclick="window.location.href='index.php'">Kembali ke Halaman Utama</button>
    </div>

    <table>
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
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["requester_name"] . "</td>";
                echo "<td>" . $row["department"] . "</td>";
                echo "<td>" . $row["request_type"] . "</td>";
                echo "<td>" . $row["priority"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["iku_achieved"] . "</td>";
                echo "<td>" . $row["iku_formula"] . "</td>";
                echo "<td>" . getBaselineDescription($row["priority"]) . "</td>";
                echo "<td>" . $row["achievement"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>Tidak ada tiket ditemukan.</td></tr>";
        }

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
    </table>

    <div class="pagination">
        <?php if($page > 1): ?>
            <a href="?page=<?php echo $page-1; ?>">Previous</a>
        <?php endif; ?>

        <?php for($i = 1; $i <= $pages; $i++): ?>
            <a class="<?php if($i == $page) echo 'active'; ?>" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if($page < $pages): ?>
            <a href="?page=<?php echo $page+1; ?>">Next</a>
        <?php endif; ?>
    </div>

    <br>
    <a class="download-link" href="export_pdf.php">Download Laporan PDF</a>
</div>

</body>
</html>
