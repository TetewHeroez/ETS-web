<?php

use App\Models\GdkFlowchart;

echo "=== Testing GDK Flowchart Dropdown Data ===" . PHP_EOL . PHP_EOL;

$flowcharts = GdkFlowchart::with('metode.materi.nilai')->get();

echo "Total Flowcharts: {$flowcharts->count()}" . PHP_EOL . PHP_EOL;

echo "Dropdown Options:" . PHP_EOL;
echo str_repeat("=", 80) . PHP_EOL;

foreach ($flowcharts as $flowchart) {
    if ($flowchart->metode) {
        $metode = $flowchart->metode;
        $materi = $metode->materi;
        $nilai = $materi->nilai;
        $totalMultiplier = $flowchart->total_multiplier;
        
        $optionText = "{$nilai->nama_nilai} → {$materi->nama_materi} → {$metode->nama_metode} (Multiplier: {$totalMultiplier})";
        
        echo "ID: {$flowchart->id}" . PHP_EOL;
        echo "Text: {$optionText}" . PHP_EOL;
        echo str_repeat("-", 80) . PHP_EOL;
    }
}

echo PHP_EOL . "✅ All flowcharts ready for dropdown!" . PHP_EOL;
