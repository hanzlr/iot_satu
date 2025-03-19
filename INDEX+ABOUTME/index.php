<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Sensor Lampu</title>
  <link rel="stylesheet" href="css\styleindex.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" href="Logo_UMB_Putih_besar.webp"> <!-- Untuk perangkat Apple -->
  <link rel="icon" sizes="32x32" href="Logo_UMB_Putih_besar.webp">
  <link rel="icon" sizes="16x16" href="Logo_UMB_Putih_besar.webp">

</head>

<body>
  <div class="container">
    <!-- GAMBAR KIRI -->
    <img src="img\TE.png" alt="Logo Universitas" class="university-logo left-logo">
    <!-- GAMBAR KANAN -->
    <img src="img\WM1.png" alt="Logo Universitas" class="university-logo right-logo">

    <hr class="divider"> <!-- Garis pembatas -->
    <!-- Navigasi -->
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <!--<li>•</li>-->
        <li><a href="about.php">About Me</a></li>
        <!--<li>•</li>-->
        <li><a href="tabel.php">Table</a></li>
      </ul>
    </nav>

    <h1>Data Sensor Lampu</h1>

    <table>
      <thead>
        <tr>
          <th>Nomor</th>
          <th>Analog Value</th>
          <th>Lux Value</th>
          <th>Lamp Percentage / Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Koneksi database
        $conn = new mysqli("localhost", "root", "", "iot_project");

        // Cek koneksi
        if ($conn->connect_error) {
          die("Koneksi gagal: " . $conn->connect_error);
        }

        // Tentukan jumlah data per halaman
        $limit = 5;
        // Ambil halaman saat ini dari URL (default ke 1)
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Ambil data database dengan batasan
        $sql = "SELECT * FROM sensor_data LIMIT $limit OFFSET $offset";
        $result = $conn->query($sql);

        // Tampilkan data
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $lux_value = $row["lux_value"] . " lx";

            if ($row["lamp_percentage"] == 0) {
              $lamp_status = "Off";
              $class = "red"; // Kelas untuk Off
            } elseif ($row["lamp_percentage"] == 50) {
              $lamp_status = "50%";
              $class = "yellow"; // Kelas untuk 50%
            } elseif ($row["lamp_percentage"] == 100) {
              $lamp_status = "100%";
              $class = "green"; // Kelas untuk 100%
            }

            echo "<tr>
                  <td>" . $row["Nomor"] . "</td>
                  <td>" . $row["analog_value"] . "</td>
                  <td>" . $lux_value . "</td>
                  <td class='" . $class . "'>" . $lamp_status . "</td>
                  </tr>";
          }
        } else {
          echo "<tr>
                <td colspan='4'>Tidak ada data</td>
                </tr>";
        }

        // Hitung jumlah total data
        $sql_total = "SELECT COUNT(*) as total FROM sensor_data";
        $result_total = $conn->query($sql_total);
        $total_rows = $result_total->fetch_assoc()['total'];
        $total_pages = ceil($total_rows / $limit); // Hitung jumlah halaman
        
        $conn->close();
        ?>
      </tbody>
    </table>

    <!-- Navigasi Pagination -->
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1; ?>">Sebelumnya</a>
      <?php endif; ?>

      <?php
      // Menentukan batasan pagination
      $start_page = max(1, $page - 2); // Memulai dari 2 halaman sebelum halaman saat ini
      $end_page = min($total_pages, $page + 2); // Mengakhiri 2 halaman setelah halaman saat ini
      
      // Menampilkan halaman pertama
      if ($start_page > 1) {
        echo '<a href="?page=1">1</a>';
        if ($start_page > 2) {
          echo '<span>...</span>'; // Tanda titik
        }
      }

      // Menampilkan tautan untuk halaman
      for ($i = $start_page; $i <= $end_page; $i++): ?>
        <a href="?page=<?= $i; ?>" <?= ($i == $page) ? 'class="active"' : ''; ?>><?= $i; ?></a>
      <?php endfor; ?>

      <!-- Menampilkan halaman terakhir -->
      <?php if ($end_page < $total_pages): ?>
        <?php if ($end_page < $total_pages - 1) {
          echo '<span>...</span>'; // Tanda titik
        }
        echo '<a href="?page=' . $total_pages . '">' . $total_pages . '</a>';
      endif; ?>

      <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1; ?>">Selanjutnya</a>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>