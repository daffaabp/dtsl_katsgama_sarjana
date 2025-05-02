<?php

function angkatan()
{
    $start = 1960;
    $end = 2025;
    $range = $end - $start;
    
    for ($i=$start; $i <= $end; $i++) { 
        $angkatan[$i] = [
            'tahun' => $i
        ];
    }
    return $angkatan;
}