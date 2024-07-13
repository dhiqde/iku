<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen IKU Universitas Indonesia Maju</title>
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
            background: #444;
            color: #fff;
            padding: 10px 0;
            border-bottom: #0779e4 3px solid;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
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
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        header li {
            margin: 0 15px;
        }
        header .branding {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
        header .branding h1 {
            margin: 0 0 0 20px;
            padding: 0;
            font-size: 24px;
        }
        header .branding img {
            height: 80px;
        }
        .content {
            padding: 20px;
            background: #fff;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #444;
            color: #fff;
            margin-top: 20px;
        }
        nav ul {
            text-align: center;
        }
        nav ul li {
            margin: 0 10px;
        }
        @media (max-width: 768px) {
            header ul {
                flex-direction: column;
                text-align: center;
            }
            header li {
                margin: 10px 0;
            }
            header .branding h1 {
                font-size: 18px;
                text-align: center;
                margin: 10px 0;
            }
            header .branding img {
                margin: 0 auto;
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="branding">
                <img src="img/logo_uima.png" alt="Logo Universitas Indonesia Maju">
                <h1>Manajemen IKU Universitas Indonesia Maju</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="input_ticket.php">Tambah IKU Baru</a></li>
                    <li><a href="view_ticket.php">Lihat Daftar IKU</a></li>
                    <li><a href="login.php">Update Ticket IKU</a></li>
                    <li><a href="report.php">Laporan IKU</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="content">
            <h2>Selamat Datang di Sistem Manajemen IKU Universitas Indonesia Maju</h2>
            <p>Sistem ini digunakan untuk mengelola Indikator Kinerja Utama (IKU) di universitas. Anda dapat menambahkan IKU baru atau melihat daftar IKU yang ada.</p>
        </div>
    </div>
    <footer>
        <p>Manajemen IKU Universitas Indonesia Maju (UIMA) &copy; 2024</p>
    </footer>
</body>
</html>
