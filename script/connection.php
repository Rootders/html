<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $binaryContent = file_get_contents($file);
    $textContent = '';

    // Проверка расширения файла и чтение его содержимого
    if ($fileExtension === 'txt') {
        $textContent = file_get_contents($file); // Чтение текстового файла
    } elseif ($fileExtension === 'docx') {
        // Чтение содержимого DOCX
        $phpWord = IOFactory::load($file);
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $textContent .= $element->getText() . " ";
                }
            }
        }
    } elseif ($fileExtension === 'pdf') {
        // Чтение содержимого PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($file);
        $textContent = $pdf->getText();
    } else {
        // Для других типов файлов берем только бинарное содержимое
        $textContent = '';
    }

    // Подсчитываем частоту символов
    $entropyText = calculate_entropy($textContent);
    $distributionText = calculate_char_distribution($textContent);

    $entropyBinary = calculate_entropy($binaryContent);
    $distributionBinary = calculate_char_distribution($binaryContent);

    // Выводим результаты
    echo "<h1>Results for Text Content (if applicable)</h1>";
    echo "<h2>Entropy (Text): " . number_format($entropyText, 4) . "</h2>";
    echo "<h3>Character distribution (Text):</h3>";
    if (!empty($distributionText)) {
        echo render_distribution_table($distributionText);
    } else {
        echo "<p>No readable text content in this file.</p>";
    }

    echo "<h1>Results for Binary Content</h1>";
    echo "<h2>Entropy (Binary): " . number_format($entropyBinary, 4) . "</h2>";
    echo "<h3>Character distribution (Binary):</h3>";
    echo render_distribution_table($distributionBinary);

} else {
    echo "No file uploaded.";
}

// Функция для расчета энтропии
function calculate_entropy($data) {
    if (strlen($data) == 0) {
        return 0;
    }
    
    $char_count = array_count_values(str_split($data));
    $total_chars = strlen($data);
    $entropy = 0.0;

    foreach ($char_count as $count) {
        $probability = $count / $total_chars;
        $entropy -= $probability * log($probability, 2);
    }

    return $entropy;
}

// Функция для расчета распределения символов
function calculate_char_distribution($data) {
    if (strlen($data) == 0) {
        return [];
    }

    $char_count = array_count_values(str_split($data));
    $total_chars = strlen($data);
    $distribution = [];

    foreach ($char_count as $char => $count) {
        $distribution[$char] = ($count / $total_chars) * 100;
    }

    return $distribution;
}

// Функция для отображения распределения символов в таблице
function render_distribution_table($distribution) {
    $table = "<table border='1' cellpadding='10'>";
    $table .= "<tr><th>Character</th><th>Percentage</th></tr>";

    foreach ($distribution as $char => $percent) {
        $display_char = htmlspecialchars($char); // Преобразуем спецсимволы
        $table .= "<tr><td>'" . ($display_char === ' ' ? 'Space' : $display_char) . "'</td><td>" . number_format($percent, 2) . "%</td></tr>";
    }

    $table .= "</table>";
    return $table;
}
?>

