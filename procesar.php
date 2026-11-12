<?php
/**
 * API Endpoint: Generador de NDA
 * Autor: [Tu Nombre] - Alumno 2º DAW
 * Descripción: Recibe datos vía POST, inserta registro de auditoría en DB (PDO) y genera PDF.
 */

$host = 'localhost';
$dbname = 'legaltech';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    http_response_code(500);
    die("Error de conexión a DB. Verifica credenciales en procesar.php.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $titulo = htmlspecialchars(trim($_POST['titulo'] ?? ''), ENT_QUOTES, 'UTF-8');
    $cliente = htmlspecialchars(trim($_POST['cliente'] ?? ''), ENT_QUOTES, 'UTF-8');
    $clausulas = htmlspecialchars(trim($_POST['clausulas'] ?? ''), ENT_QUOTES, 'UTF-8');

    if (empty($titulo) || empty($cliente) || empty($clausulas)) {
        http_response_code(400);
        die("Bad Request: Faltan parámetros requeridos en el payload.");
    }

    try {
        $sql = "INSERT INTO contratos (titulo, cliente, clausulas) VALUES (:titulo, :cliente, :clausulas)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':cliente' => $cliente,
            ':clausulas' => $clausulas
        ]);
        
        $contrato_id = $pdo->lastInsertId();

    } catch (PDOException $e) {
        http_response_code(500);
        die("Error al insertar el registro en la base de datos.");
    }

    require_once('fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode($titulo), 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(44, 62, 80);
    $pdf->Cell(0, 10, utf8_decode("ID de Expediente Seguro: #" . str_pad($contrato_id, 6, "0", STR_PAD_LEFT)), 0, 1);
    $pdf->SetTextColor(0, 0, 0);
    
    $pdf->Cell(0, 10, utf8_decode("Entidad / Parte Reveladora: " . $cliente), 0, 1);
    $pdf->Cell(0, 10, utf8_decode("Fecha de emisión: " . date("d/m/Y H:i:s")), 0, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 11);
    $pdf->MultiCell(0, 8, utf8_decode($clausulas));
    $pdf->Ln(20);
    
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(90, 10, "Firma Parte Reveladora:", 0, 0, 'C');
    $pdf->Cell(90, 10, "Firma Parte Receptora:", 0, 1, 'C');

    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');
    header('Content-type: application/pdf');
    
    $pdf->Output('D', 'acuerdo_confidencialidad.pdf');
    
} else {
    http_response_code(405);
    die("Method Not Allowed");
}
