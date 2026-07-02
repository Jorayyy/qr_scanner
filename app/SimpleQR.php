<?php

namespace App;

class SimpleQR
{
    // Generates a pure text-based HTML table grid layout that looks exactly like a QR matrix!
    public static function generateTableGrid($text)
    {
        $hash = md5($text);
        $blocks = str_split($hash, 2);
        
        // Define a 10x10 matrix layout grid map
        $grid = [];
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $grid[$i][$j] = 0; // 0 means white block
            }
        }

        // Draw tracking squares in the 3 corners
        self::drawCornerSquare($grid, 0, 0);
        self::drawCornerSquare($grid, 7, 0);
        self::drawCornerSquare($grid, 0, 7);

        // Fill the middle blocks dynamically based on the random registration token
        for ($i = 3; $i < 7; $i++) {
            for ($j = 3; $j < 7; $j++) {
                $index = (($i - 3) * 4) + ($j - 3);
                $val = hexdec($blocks[$index] ?? '0');
                if ($val % 2 === 0) {
                    $grid[$i][$j] = 1; // 1 means black block
                }
            }
        }

        // Compile the matrix grid map array into a raw HTML table block string
        $html = '<table style="border-collapse: collapse; margin: 0 auto; border: 4px solid #ffffff; background: #ffffff;">';
        foreach ($grid as $row) {
            $html .= '<tr style="height: 18px;">'; // Clean, unbroken row tag block
            foreach ($row as $cell) {
                $color = ($cell === 1) ? '#0f172a' : '#ffffff';
                $html .= '<td style="width: 18px; background-color: ' . $color . '; border: none;"></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';

        return $html;
    }

    private static function drawCornerSquare(&$grid, $top, $left)
    {
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($i == 0 || $i == 2 || $j == 0 || $j == 2) {
                    $grid[$top + $i][$left + $j] = 1;
                }
            }
        }
    }
}
