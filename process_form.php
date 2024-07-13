<?php
// Pastikan Anda memiliki koneksi database di sini
$servername = "localhost";
$username = "root";
$password = "avbkiller99!";
$dbname = "it_tickets";

// Ambil nilai dari formulir
$requester_name = $_POST['requester_name'];
$department = $_POST['department'];
$contact_info = $_POST['contact_info'];
$request_type = $_POST['request_type'];
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$expected_action = $_POST['expected_action'];
$deadline = $_POST['deadline'];
$additional_info = $_POST['additional_info'];
$status = 'Diajukan'; // Misalnya, status default saat diajukan
$achievement = $_POST['achievement'];
$comments = $_POST['comments'];

// Tentukan formula IKU berdasarkan prioritas
switch ($priority) {
    case 'Rendah':
        $iku_formula = "Formula Rendah: (parameter 1 + parameter 2) / 2";
        break;
    case 'Sedang':
        $iku_formula = "Formula Sedang: (parameter 1 + parameter 2 + parameter 3) / 3";
        break;
    case 'Tinggi':
        $iku_formula = "Formula Tinggi: (parameter 1 + parameter 2 + parameter 3 + parameter 4) / 4";
        break;
    case 'Kritis':
        $iku_formula = "Formula Kritis: parameter 1 * parameter 2 * parameter 3 * parameter 4";
        break;
    default:
        $iku_formula = "Formula Default";
        break;
}

// Query SQL untuk menyimpan data ke dalam tabel
$sql = "INSERT INTO tickets (date_submitted, requester_name, department, contact_info, request_type, title, description, priority, expected_action, deadline, additional_info, status, iku_formula, achievement, comments)
    VALUES (NOW(), '$requester_name', '$department', '$contact_info', '$request_type', '$title', '$description', '$priority', '$expected_action', '$deadline', '$additional_info', '$status', '$iku_formula', '$achievement', '$comments')";

// Jalankan query
if ($conn->query($sql) === TRUE) {
    echo "Tiket berhasil diajukan!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
