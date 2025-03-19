<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel</title>
    <link rel="stylesheet" href="css\styletabel.css">
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

        <hr class="divider"> <!-- Garis pembatas ditambahkan di sini -->
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <!--<li>•</li>-->
                <li><a href="about.php">About Me</a></li>
                <!--<li>•</li>-->
                <li><a href="tabel.php">Table</a></li>
            </ul>
        </nav>

        <h1>Tabel</h1>
        <p>Tabel berikut ini menunjukkan hubungan antara tingkat iluminasi (lux),
            resistansi (R), dan tingkat tegangan
            pada pin AO ketika GAMMA = 0,7 dan RL10 = 50 (nilai default):
        </p>
        <table>
            <thead>
                <tr>
                    <th>Condition</th>
                    <th>Illumination (lux)</th>
                    <th>LDR Resistance</th>
                    <th>Voltage*</th>
                    <th>analogRead() value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Full moon</td>
                    <td>0.1</td>
                    <td>1.25MΩ</td>
                    <td>4.96</td>
                    <td>1016</td>
                </tr>
                <tr>
                    <td>Deep twilight</td>
                    <td>1</td>
                    <td>250kΩ</td>
                    <td>4.81</td>
                    <td>985</td>
                </tr>
                <tr>
                    <td>Twilight</td>
                    <td>10</td>
                    <td>50kΩ</td>
                    <td>4.17</td>
                    <td>853</td>
                </tr>
                <tr>
                    <td>Computer monitor**</td>
                    <td>50</td>
                    <td>16.2kΩ</td>
                    <td>3.09</td>
                    <td>633</td>
                </tr>
                <tr>
                    <td>Stairway lighting</td>
                    <td>100</td>
                    <td>9.98kΩ</td>
                    <td>2.50</td>
                    <td>511</td>
                </tr>
                <tr>
                    <td>Office lighting</td>
                    <td>400</td>
                    <td>3.78kΩ</td>
                    <td>1.37</td>
                    <td>281</td>
                </tr>
                <tr>
                    <td>Overcast day</td>
                    <td>1,000</td>
                    <td>1.99kΩ</td>
                    <td>0.83</td>
                    <td>170</td>
                </tr>
                <tr>
                    <td>Full daylight</td>
                    <td>10,000</td>
                    <td>397Ω</td>
                    <td>0.19</td>
                    <td>39</td>
                </tr>
                <tr>
                    <td>Direct sunlight</td>
                    <td>100,000</td>
                    <td>79Ω</td>
                    <td>0.04</td>
                    <td>8</td>
                </tr>
            </tbody>
        </table>
        <p>*&nbsp;&nbsp;&nbsp;&nbsp;Ketika VCC = 5V<br>
            **&nbsp;&nbsp;Diukur pada jarak satu meter dari monitor<br></p>
        <hr class="divider"> <!-- Garis pembatas ditambahkan di sini -->
        <p>
            Referensi: <a class="referensi" href="https://docs.wokwi.com/parts/wokwi-photoresistor-sensor"
                target="_blank">
                Wokwi Photoresistor Sensor</a>
        </p>



    </div>
</body>

</html>