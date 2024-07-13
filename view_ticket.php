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
            font-size: 10px;
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
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #333;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a:hover {
            background-color: #ddd;
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
            table {
                font-size: 8px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Daftar Tiket IT</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
        </ul>
    </header>

    <div class="content">
        <h2>Data Tiket IT</h2>
        <table>
            <thead>
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
                    <th>Status</th>
                    <th>technician_name</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Buat koneksi
                $servername = "localhost";
                $username = "root";
                $password = "avbkiller99!";
                $dbname = "it_tickets";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Pagination
                $limit = 5; // Number of rows per page
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $start_from = ($page - 1) * $limit;
                
                $sql = "SELECT * FROM tickets LIMIT $start_from, $limit";
                $result = $conn->query($sql);
                
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
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $baseline = getBaselineDescription($row["priority"]);
                
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["requester_name"] . "</td>";
                        echo "<td>" . $row["department"] . "</td>";
                        echo "<td>" . $row["request_type"] . "</td>";
                        echo "<td>" . $row["priority"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["iku_achieved"] . "</td>";
                        echo "<td>" . $row["iku_formula"] . "</td>";
                        echo "<td>" . $baseline . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["technician_name"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>Tidak ada tiket ditemukan.</td></tr>";
                }

                // Close the connection after fetching results for the current page
                $conn->close();
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            // Re-open the connection to calculate total pages
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            $sql = "SELECT COUNT(id) FROM tickets";
            $result = $conn->query($sql);
            $row = $result->fetch_row();
            $total_records = $row[0];
            $total_pages = ceil($total_records / $limit);

            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='view_ticket.php?page=".$i."'";
                if ($i == $page) echo " class='current'";
                echo ">" . $i . "</a> ";
            }

            // Close the connection again after calculating pagination
            $conn->close();
            ?>
        </div>

        <div class="back-button">
            <a href="index.php">Kembali ke Halaman Utama</a>
        </div>
    </div>
</div>

<footer>
    <p>© 2024 Daftar Tiket IT. All Rights Reserved.</p>
</footer>

</body>
</html>
