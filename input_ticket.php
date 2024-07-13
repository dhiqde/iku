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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_submitted = date('Y-m-d');
    $requester_name = $_POST["requester_name"];
    $department = $_POST["department"];
    $contact_info = $_POST["contact_info"];
    $request_type = $_POST["request_type"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $priority = $_POST["priority"];
    $expected_action = $_POST["expected_action"];
    $deadline = $_POST["deadline"];
    $additional_info = $_POST["additional_info"];
    $status = "Baru";
    $technician_name = "";
    $completion_date = "0000-00-00";
    $resolution_comments = "";
    
    // Menghitung IKU yang dicapai
    $iku_achieved = calculateIKU($priority, $date_submitted, $deadline);

    $achievement = $_POST["achievement"];
    $comments = $_POST["comments"];

    // Tentukan formula IKU berdasarkan prioritas
    switch ($priority) {
        case 'Rendah':
            $iku_formula = "Waktu Penyelesaian (hari) <= 7";
            break;
        case 'Sedang':
            $iku_formula = "Waktu Penyelesaian (hari) <= 5";
            break;
        case 'Tinggi':
            $iku_formula = "Waktu Penyelesaian (hari) <= 3";
            break;
        case 'Kritis':
            $iku_formula = "Waktu Penyelesaian (hari) <= 1";
            break;
        default:
            $iku_formula = "Waktu Penyelesaian (hari) <= 7";
            break;
    }

    $sql = "INSERT INTO tickets (date_submitted, requester_name, department, contact_info, request_type, title, description, priority, expected_action, deadline, additional_info, status, iku_achieved, iku_formula, achievement, comments, technician_name, completion_date, resolution_comments)
    VALUES ('$date_submitted', '$requester_name', '$department', '$contact_info', '$request_type', '$title', '$description', '$priority', '$expected_action', '$deadline', '$additional_info', '$status', '$iku_achieved', '$iku_formula', '$achievement', '$comments', '$technician_name', '$completion_date', '$resolution_comments')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit(); // pastikan skrip berhenti setelah pengalihan
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

function calculateIKU($priority, $date_submitted, $deadline) {
    $submission_date = new DateTime($date_submitted);
    $deadline_date = new DateTime($deadline);
    $interval = $submission_date->diff($deadline_date);
    $days = $interval->days;

    switch ($priority) {
        case 'Rendah':
            return ($days <= 7) ? 'Tercapai' : 'Tidak Tercapai';
        case 'Sedang':
            return ($days <= 5) ? 'Tercapai' : 'Tidak Tercapai';
        case 'Tinggi':
            return ($days <= 3) ? 'Tercapai' : 'Tidak Tercapai';
        case 'Kritis':
            return ($days <= 1) ? 'Tercapai' : 'Tidak Tercapai';
        default:
            return ($days <= 7) ? 'Tercapai' : 'Tidak Tercapai';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Tiket IT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 60%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }
        form input[type="text"],
        form input[type="date"],
        form select,
        form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        form textarea {
            height: 100px;
            resize: vertical;
        }
        form select {
            font-size: 14px;
            height: 34px;
        }
        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        form input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* CSS untuk tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 180px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -90px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        .back-button {
            text-align: center;
            margin-top: 20px;
        }
        .back-button a {
            text-decoration: none;
            color: #fff;
            background-color: #333;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Formulir Tiket IT</h2>

    <form id="ticketForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="requester_name">Nama Pemohon:</label>
        <input type="text" id="requester_name" name="requester_name" required>

        <label for="department">Departemen/Unit:</label>
        <input type="text" id="department" name="department" required>

        <label for="contact_info">Kontak Pemohon:</label>
        <input type="text" id="contact_info" name="contact_info" required>

        <label for="request_type">Jenis Permintaan:</label>
        <select id="request_type" name="request_type" required onchange="updateBaselineDescription()">
            <option value="Permintaan Dukungan Teknis">Permintaan Dukungan Teknis</option>
            <option value="Permintaan Instalasi Perangkat Keras/Perangkat Lunak">Permintaan Instalasi Perangkat Keras/Perangkat Lunak</option>
            <option value="Pelaporan Insiden Keamanan">Pelaporan Insiden Keamanan</option>
            <option value="Pembaruan Sistem/Perangkat Lunak">Pembaruan Sistem/Perangkat Lunak</option>
            <option value="Permintaan Pelatihan">Permintaan Pelatihan</option>
            <option value="Proyek IT Baru">Proyek IT Baru</option>
            <option value="Lainnya">Lainnya</option>
        </select>

        <label for="title">Judul Permintaan:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Deskripsi Detil:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="priority">Prioritas Permintaan:</label>
        <select id="priority" name="priority" required onchange="updateBaselineDescription()">
            <option value="Rendah">Rendah</option>
            <option value="Sedang">Sedang</option>
            <option value="Tinggi">Tinggi</option>
            <option value="Kritis">Kritis</option>
        </select>
        <div class="tooltip">
            <span class="tooltiptext">Capaian diharapkan: Rendah (<= 7 hari), Sedang (<= 5 hari), Tinggi (<= 3 hari), Kritis (<= 1 hari)</span>
        </div>

        <label for="expected_action">Deskripsi Tindakan yang Diharapkan:</label>
        <textarea id="expected_action" name="expected_action" required></textarea>

        <label for="deadline">Batas Waktu yang Diinginkan:</label>
        <input type="date" id="deadline" name="deadline" required>

        <label for="additional_info">Informasi Tambahan:</label>
        <textarea id="additional_info" name="additional_info"></textarea>

        <label for="achievement">Capaian (10%-100%):</label>
        <textarea id="achievement" name="achievement"></textarea>
        <div class="tooltip">
            <span class="tooltiptext">Capaian yang dicapai dalam presentase.</span>
        </div>

        <label for="baseline">Baseline:</label>
        <textarea id="baseline" name="baseline" readonly></textarea>

        <label for="comments">Komentar:</label>
        <textarea id="comments" name="comments"></textarea>

        <input type="submit" value="Ajukan Tiket">
    </form>
    
    <div class="back-button">
        <a href="index.php">Kembali ke Halaman Utama</a>
    </div>
</div>

<script>
    function updateBaselineDescription() {
        var priority = document.getElementById("priority").value;
        var baselineDescription = "";

        switch (priority) {
            case "Rendah":
                baselineDescription = "Waktu Penyelesaian (hari) <= 7";
                break;
            case "Sedang":
                baselineDescription = "Waktu Penyelesaian (hari) <= 5";
                break;
            case "Tinggi":
                baselineDescription = "Waktu Penyelesaian (hari) <= 3";
                break;
            case "Kritis":
                baselineDescription = "Waktu Penyelesaian (hari) <= 1";
                break;
            default:
                baselineDescription = "";
                break;
        }

        document.getElementById("baseline").value = baselineDescription;
    }
</script>

</body>
</html>

