<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
$pdo->exec('ALTER TABLE driving_sessions DROP COLUMN instructor_id');
echo 'instructor_id column dropped successfully!';
