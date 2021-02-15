<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<style>
		<?php 
			include 'index.css';
		?>
	</style>
</head>
<body>
	<h1>Look at this beautiful multiply table, dude:</h1>
	<table>
		<?php
			for ($i = 1; $i <= 11; $i++) { 
				echo '<tr>';
				for ($j = 1; $j <= 11; $j++) { 
					if ($i === 1 && $j === 1) {
						echo '<td class="start"></td>';
						continue;
					}
					if ($i === 1) {
						echo '<td class="digit">' . $i * ($j - 1) . '</td>';
						continue;
					} 
					if ($j === 1) {
						echo '<td class="digit">' . ($i - 1) * $j . '</td>';
						continue;
					}
					if ($i === $j) {
						echo '<td class="main-diagonal">' . ($i - 1) * ($j - 1) . '</td>';
					} else {
						echo '<td>' . ($i - 1) * ($j - 1) . '</td>';
					}
				}
				echo '</tr>';
			}
		?>
	</table>
</body>
</html>
