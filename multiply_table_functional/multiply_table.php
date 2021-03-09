<?php 
    function buildTable($x_rows, $y_rows) {
        $table = '<table>';
        for ($i = 1; $i <= $x_rows + 1; $i++) { 
            $table .= '<tr>';
            for ($j = 1; $j <= $y_rows + 1; $j++) { 
                if ($i === 1 && $j === 1) {
                    $table .= '<td class="start"></td>';
                    continue;
                }
                if ($i === 1) {
                    $table .= '<td class="digit">' . $i * ($j - 1) . '</td>';
                    continue;
                } 
                if ($j === 1) {
                    $table .= '<td class="digit">' . ($i - 1) * $j . '</td>';
                    continue;
                }
                if ($i === $j) {
                    $table .= '<td class="main-diagonal">' . ($i - 1) * ($j - 1) . '</td>';
                } else {
                    $table .= '<td>' . ($i - 1) * ($j - 1) . '</td>';
                }
            }
            $table .= '</tr>';
        }
        return $table . '</table>';
    }

    function checkUserInput() {
        if ($_POST['x'] < 1 || $_POST['x'] < 1) return FALSE;
        return TRUE;
    }

    function createTable() {
        if (!checkUserInput()) {
            echo '<h2>Некорректное кол-во столбцов и/или строк!</h2>';
        } else {
            echo '<h1>Look at this table dude!</h1>';
            echo buildTable($_POST['x'], $_POST['y']);
        }
    }
include './table_template.php';