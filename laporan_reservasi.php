<?php
require('fpdf/fpdf.php');
include 'koneksi.php';

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'LAPORAN RESERVASI PLAYSTATION', 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(45, 10, 'Pelanggan', 1);
$pdf->Cell(40, 10, 'Unit PS', 1);
$pdf->Cell(35, 10, 'Tgl Reservasi', 1);
$pdf->Cell(25, 10, 'Durasi', 1);
$pdf->Cell(40, 10, 'Total Bayar', 1);
$pdf->Cell(35, 10, 'Status', 1);

$pdf->Ln();

$query = mysqli_query($koneksi, "
SELECT
    r.*,
    p.nama_pelanggan,
    u.nama_unit,
    u.harga_sewa
FROM Tb_Reservasi r
JOIN Tb_Pelanggan p
    ON r.id_pelanggan = p.id_pelanggan
JOIN Tb_Unit_PlayStation u
    ON r.id_paket = u.id_paket
ORDER BY r.id_reservasi DESC
");

$no = 1;

$pdf->SetFont('Arial', '', 10);

while ($row = mysqli_fetch_assoc($query)) {

    $total = $row['lama_sewa'] * $row['harga_sewa'];

    $pdf->Cell(10, 10, $no++, 1);
    $pdf->Cell(45, 10, $row['nama_pelanggan'], 1);
    $pdf->Cell(40, 10, $row['nama_unit'], 1);
    $pdf->Cell(35, 10, $row['tgl_reservasi'], 1);
    $pdf->Cell(25, 10, $row['lama_sewa'] . ' Hari', 1);
    $pdf->Cell(40, 10, 'Rp ' . number_format($total, 0, ',', '.'), 1);
    $pdf->Cell(35, 10, $row['status_reservasi'], 1);

    $pdf->Ln();
}

$pdf->Output();
