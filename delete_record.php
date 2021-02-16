<?php
require_once('database.php');

// Get ID
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

// Delete the item from the database
if ($id) {
    $query = 'DELETE FROM todoitems
              WHERE ItemNum = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $success = $statement->execute();
    $statement->closeCursor();    
}

// Display the home page
include('index.php');