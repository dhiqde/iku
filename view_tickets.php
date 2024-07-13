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

$sql = "SELECT * FROM tickets";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Tiket IT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
            max-width: 1200px;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 0;
            border-bottom: #0779e4 3px solid;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            float: left;
            display: inline;
            padding: 0 20px 0 20px;
        }
        header:after {
            content: "";
            display: table;
            clear: both;
        }
        .content {
            padding: 20px;
            background: #fff;
            margin-top: 20px;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: #fff;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            overflow-x: auto;
            display: block;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .back-button {
            margin-top: 20px;
            text-align: center;
        }
        .back-button a {
            text-decoration: none;
            color: #fff;
            background-color: #333;
            padding: 10px 20px;
            border-radius: 5px;
        }
        @media (max-width: 768px) {
            header li {
                display: block;
                text-align: center;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <div id="branding">
            <h1>Daftar Tiket IT</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container">
    <div class="content">
        <h2>Daftar Tiket IT</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Tanggal Pengajuan</th>
                <th>Nama Pemohon</th>
                <th>Departemen</th>
                <th>Kontak Pemohon</th>
                <th>Jenis Permintaan</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Prioritas</th>
                <th>Tindakan yang Diharapkan</th>
                <th>Batas Waktu</th>
                <th>Informasi Tambahan</th>
                <th>Status</th>
                <th>IKU yang Dicapai</th>
                <th>Formula IKU</th>
                <th>Capaian</th>
                <th>Komentar</th>
                <th>Nama Teknisi</th>
                <th>Tanggal Penyelesaian</th>
                <th>Komentar Penyelesaian</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"]. "</td>";
                    echo "<td>" . $row["date_submitted"]. "</td>";
                    echo "<td>" . $row["requester_name"]. "</td>";
                    echo "<td>" . $row["department"]. "</td>";
                    echo "<td>" . $row["contact_info"]. "</td>";
                    echo "<td>" . $row["request_type"]. "</td>";
                    echo "<td>" . $row["title"]. "</td>";
                    echo "<td>" . $row["description"]. "</td>";
                    echo "<td>" . $row["priority"]. "</td>";
                    echo "<td>" . $row["expected_action"]. "</td>";
                    echo "<td>" . $row["deadline"]. "</td>";
                    echo "<td>" . $row["additional_info"]. "</td>";
                    echo "<td>" . $row["status"]. "</td>";
                    echo "<td>" . $row["iku_achieved"]. "</td>";
                    echo "<td>" . $row["iku_formula"]. "</td>";
                    echo "<td>" . $row["achievement"]. "</td>";
                    echo "<td>" . $row["comments"]. "</td>";
                    echo "<td>" . $row["technician_name"]. "</td>";
                    echo "<td>" . $row["completion_date"]. "</td>";
                    echo "<td>" . $row["resolution_comments"]. "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='20'>No tickets found</td></tr>";
            }
            $conn->close();
            ?>

        </table>

        <div class="back-button">
            <a href="index.php">Kembali ke Home</a>
        </div>
    </div>
</div>

<footer>
    <p>Manajemen IKU Universitas &copy; 2024</p>
</footer>

</body>
</html>
