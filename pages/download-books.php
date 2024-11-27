<?php
require('../fpdf/fpdf.php');

$pdo = new PDO('mysql:host=localhost;dbname=project-211', 'root', '');

$stmt = $pdo->query("
SELECT 
    books.name, books.price, 
    authors.name AS author_name, 
    genres.name AS genre_name
FROM books
LEFT JOIN authors ON books.author_id = authors.id
LEFT JOIN genres ON books.genre_id = genres.id
");
$books = $stmt->fetchAll(PDO::FETCH_OBJ);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Book List');

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);

foreach ($books as $book) {
    $pdf->Cell(0, 10, "{$book->name} - {$book->author_name} - {$book->genre_name} - \${$book->price}", 0, 1);
}

$pdf->Output('D', 'book_list.pdf'); 
?>
