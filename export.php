<?php
require_once "vendor/autoload.php";
require_once "inc/db.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$Excel_writer = new Xlsx($spreadsheet);

$spreadsheet->setActiveSheetIndex(0);
$activeSheet = $spreadsheet->getActiveSheet();
$activeSheet->setCellValue('A1', 'ID');
$activeSheet->setCellValue('B1', 'Jméno');
$activeSheet->setCellValue('C1', 'Příjmení');
$activeSheet->setCellValue('D1', 'Narození');
$activeSheet->setCellValue('E1', 'Bydliště');
$activeSheet->setCellValue('F1', 'Turnus');
$activeSheet->setCellValue('G1', 'Jméno rodiče');
$activeSheet->setCellValue('H1', 'Příjmení rodiče');
$activeSheet->setCellValue('I1', 'Telefon');
$activeSheet->setCellValue('J1', 'Email');
$activeSheet->setCellValue('K1', 'Jméno rodiče');
$activeSheet->setCellValue('L1', 'Příjmení rodiče');
$activeSheet->setCellValue('M1', 'Telefon');
$activeSheet->setCellValue('N1', 'Email');
$activeSheet->setCellValue('N1', 'Podání');

$year= ('%' . $_GET['year'] . '%');

$query=$db->prepare('SELECT * FROM `dite` join prihlaska on (dite.id = prihlaska.dite_id) join turnus on (turnus.turnus_id = prihlaska.turnus_id) where created like ?;');
$query->bind_param('s', $year);
$query->execute(); 
$result = $query ->get_result();
if ($result->num_rows > 0) {
    $i = 2;
    while ($row =  $result->fetch_assoc()) {
        $activeSheet->setCellValue('A' . $i, $row['prihlaska_id']);
        // $activeSheet->setCellValueExplicit('B' . $i, $row['jmeno'],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
        $activeSheet->setCellValue('B' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['jmeno']));
        $activeSheet->setCellValue('C' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['prijmeni']));
        $activeSheet->setCellValue('D' . $i, $row['narozeni']);
        $activeSheet->setCellValue('E' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['bydliste']));
        $activeSheet->setCellValue('F' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['turnus']));
        $activeSheet->setCellValue('G' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['rjmeno']));
        $activeSheet->setCellValue('H' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['rprijmeni']));
        $activeSheet->setCellValue('I' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['rtelefon']));
        $activeSheet->setCellValue('J' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['remail']));
        $activeSheet->setCellValue('K' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['rjmeno2']));
        $activeSheet->setCellValue('L' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['rprijmeni2']));
        $activeSheet->setCellValue('M' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['rtelefon2']));
        $activeSheet->setCellValue('N' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['remail2']));
        $activeSheet->setCellValue('N' . $i, iconv('Windows-1250', 'UTF-8//TRANSLIT', $row['created']));
        $i++;
    }
}
$filename = 'prihlasky.xlsx';

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Encoding: UTF-8');
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');


$Excel_writer->save('php://output');


