<?php
// Path to the SQLite database file
$dbPath = 'my_database.db';

// Create a new instance of SQLite3 and open the database
$db = new SQLite3($dbPath);

// Prepare the SQL query for inserting data into the users table
$query = "INSERT INTO users (name, email) VALUES (:name, :email)";

// Prepare the SQL statement
$stmt = $db->prepare($query);

// Bind parameters to the prepared statement as strings
$stmt->bindValue(':name', 'John Doe', SQLITE3_TEXT);
$stmt->bindValue(':email', 'john.doe@example.com', SQLITE3_TEXT);

// Execute the statement to insert the data
if($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $db->lastErrorMsg();
}

// Close the database connection
$db->close();
?>
