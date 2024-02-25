<?php
$db = new SQLite3('upswipe.db');

$query = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT, 
            name TEXT NOT NULL, 
            email TEXT NOT NULL UNIQUE
          )";
          
$result = $db->exec($query);
if($result) {
    echo "Table created successfully";
} else {
    echo "Failed to create table";
}
?>
