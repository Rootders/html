<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];

    // Проверим, что файл существует и является текстовым
        $content = file_get_contents($file);
        if ($content !== false) {
            // Расчет энтропии
            $entropy = calculate_entropy($content);

            // Расчет распределения символов
            $distribution = calculate_char_distribution($content);

            // Вывод результатов
            echo "<h1>Entropy: " . number_format($entropy, 4) . "</h1>";
            echo "<h2>Character distribution:</h2>";
            echo "<table border='1' cellpadding='10'>";
            echo "<tr><th>Character</th><th>Percentage</th></tr>";

            foreach ($distribution as $char => $percent) {
                $display_char = htmlspecialchars($char); // преобразуем специальные символы для отображения
                echo "<tr><td>'" . ($display_char === ' ' ? 'Space' : $display_char) . "'</td><td>" . number_format($percent, 2) . "%</td></tr>";
        
            echo "</table>";
        } else {
            echo "Error reading the file.";
        }
    } else {
        echo "Please upload a valid text file.";
    }
} else {
    echo "No file uploaded.";
}

// Функция для расчета энтропии
function calculate_entropy($text) {
    $char_count = array_count_values(str_split($text));
    $total_chars = strlen($text);
    $entropy = 0.0;

    foreach ($char_count as $count) {
        $probability = $count / $total_chars;
        $entropy -= $probability * log($probability, 2);
    }

    return $entropy;
}

// Функция для расчета распределения символов
function calculate_char_distribution($text) {
    $char_count = array_count_values(str_split($text));
    $total_chars = strlen($text);
    $distribution = [];

    foreach ($char_count as $char => $count) {
        $distribution[$char] = ($count / $total_chars) * 100;
    }

    return $distribution;
}
?>
