<?php
require 'vendor/autoload.php'; // Pastikan library PhpSpreadsheet sudah terinstall

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Koneksi database
$conn = new mysqli("localhost", "root", "", "iot_project");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari database
$sql = "SELECT * FROM sensor_data";
$result = $conn->query($sql);

// Buat spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$sheet->setCellValue('D3', 'Nomor');
$sheet->setCellValue('E3', 'Analog Value');
$sheet->setCellValue('F3', 'Lux Value');
$sheet->setCellValue('G3', 'Lamp Percentage / Status');

// Styling header
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ]
];
$sheet->getStyle('D3:G3')->applyFromArray($headerStyle); // Terapkan style di D3:G3

// Tambahkan data dari database
$rowNumber = 4; // Mulai dari baris ke-4 setelah header
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Menyusun status lampu berdasarkan nilai lamp_percentage
        if ($row['lamp_percentage'] == 0) {
            $lamp_status = "Off";
        } elseif ($row['lamp_percentage'] == 50) {
            $lamp_status = "50%";
        } elseif ($row['lamp_percentage'] == 100) {
            $lamp_status = "100%";
        } else {
            $lamp_status = "Unknown"; // Jika ada nilai lain
        }

        // Menyisipkan data ke dalam sheet
        $sheet->setCellValue('D' . $rowNumber, $row['Nomor']);
        $sheet->setCellValue('E' . $rowNumber, $row['analog_value']);
        $sheet->setCellValue('F' . $rowNumber, $row['lux_value']);
        $sheet->setCellValue('G' . $rowNumber, $lamp_status);
        
        // Menambahkan style pada data
        $sheet->getStyle('D' . $rowNumber . ':G' . $rowNumber)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        $rowNumber++;
    }
}

// Set nama file Excel
$fileName = "Data_Sensor_Lampu.xlsx";

// Menyesuaikan lebar kolom secara otomatis
foreach (range('D', 'G') as $columnID) { // Perbaiki range kolom
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Kirim file Excel sebagai download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

// Tulis dan kirim file Excel ke browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
