<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_ticket'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);
    $technician_name = $conn->real_escape_string($_POST['technician_name']);
    $completion_date = $conn->real_escape_string($_POST['completion_date']);
    $resolution_comments = $conn->real_escape_string($_POST['resolution_comments']);

    $sql_update = "UPDATE tickets SET status='$status', technician_name='$technician_name', completion_date='$completion_date', resolution_comments='$resolution_comments' WHERE id='$id'";

    if ($conn->query($sql_update) === TRUE) {
        $success = "Ticket updated successfully.";
    } else {
        $error = "Error updating ticket: " . $conn->error;
    }
}

$sql = "SELECT * FROM tickets";
$tickets_result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Ticket</title>
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
        .content {
            padding: 20px;
            background: #fff;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-inline {
            display: flex;
            flex-direction: column;
        }
        .form-inline label {
            margin-top: 10px;
        }
        .form-inline input[type="text"], .form-inline input[type="date"], .form-inline textarea, .form-inline select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-top: 5px;
        }
        .update-button {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .success {
            color: green;
            margin-bottom: 15px;
            text-align: center;
        }
        @media (max-width: 768px) {
            .form-inline {
                flex-direction: column;
            }
        }
        .logout-button {
            background: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">
        <h2>Update Ticket</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if ($tickets_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Tiket</th>
                        <th>Status</th>
                        <th>Nama Teknisi</th>
                        <th>Tanggal Penyelesaian</th>
                        <th>Komentar Penyelesaian</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($ticket = $tickets_result->fetch_assoc()): ?>
                    <tr>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <td>
                                <input type="text" name="id" value="<?php echo htmlspecialchars($ticket['id']); ?>" readonly>
                            </td>
                            <td>
                                <?php if ($ticket['status'] == 'Closed'): ?>
                                    <input type="text" name="status" value="<?php echo htmlspecialchars($ticket['status']); ?>" readonly>
                                <?php else: ?>
                                    <select name="status" required>
                                        <option value="Open" <?php echo ($ticket['status'] == 'Open') ? 'selected' : ''; ?>>Open</option>
                                        <option value="In Progress" <?php echo ($ticket['status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="Closed" <?php echo ($ticket['status'] == 'Closed') ? 'selected' : ''; ?>>Closed</option>
                                    </select>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ticket['status'] == 'Closed'): ?>
                                    <input type="text" name="technician_name" value="<?php echo htmlspecialchars($ticket['technician_name']); ?>" readonly>
                                <?php else: ?>
                                    <input type="text" name="technician_name" value="<?php echo htmlspecialchars($ticket['technician_name']); ?>">
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ticket['status'] == 'Closed'): ?>
                                    <input type="date" name="completion_date" value="<?php echo htmlspecialchars($ticket['completion_date']); ?>" readonly>
                                <?php else: ?>
                                    <input type="date" name="completion_date" value="<?php echo htmlspecialchars($ticket['completion_date']); ?>">
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ticket['status'] == 'Closed'): ?>
                                    <textarea name="resolution_comments" readonly><?php echo htmlspecialchars($ticket['resolution_comments']); ?></textarea>
                                <?php else: ?>
                                    <textarea name="resolution_comments"><?php echo htmlspecialchars($ticket['resolution_comments']); ?></textarea>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ticket['status'] != 'Closed'): ?>
                                    <input type="hidden" name="update_ticket" value="1">
                                    <input type="submit" value="Update Tiket" class="update-button">
                                <?php endif; ?>
                            </td>
                        </form>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="error">Tidak ada tiket yang ditemukan.</div>
        <?php endif; ?>
        <form method="post" action="logout.php">
            <input type="submit" value="Logout" class="logout-button">
        </form>
    </div>
</div>

</body>
</html>
