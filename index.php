<?php
    $item = filter_input(INPUT_POST, "item", FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo</title>
    <link rel="stylesheet" href= "css/main.css">
</head>
<body>
    <main>
        <header>
            <h1> To Do List </h1>
        </header>
        <?php if (!$item && !$description){ ?>
            <?php require("database.php"); ?>
            
            <section>
            <?php
                $query = 'SELECT * FROM todoitems';
                $statement = $db->prepare($query);
                $statement->execute();
                $results = $statement->fetchAll();
                $statement->closeCursor();
            ?>
            <?php if(!empty($results)) { ?>
                <section>
                    <table>
                        <?php foreach ($results as $result) : ?>
                        <tr>
                            <td><?php echo $result['ItemNum']; ?></td>
                            <td><?php echo $result['Title']; ?></td>
                            <td><?php echo $result['Description']; ?></td>
                            <td><form action="delete_record.php" method="post">
                                <input type="hidden" name="id"
                                value="<?php echo $result['ItemNum']?>">
                                <input type="submit" value="Delete">
                            </form></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                <section>
            <?php } else { ?>
                <p>No to do list items exist yet.</p>
            <?php } ?>

            <h2> Add Item </h2>
            <form action="<?php echo $_SERVER ['PHP_SELF'] ?>" method = "POST">
                <label for="item">Item:</label>
                <input type="text" id="item" name="item" required>

                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
                <button>Add Item</button>
            </form>
        </section>
        <?php } else { ?>
            <?php require("database.php"); ?>

            <?php 
            if ($item) {
                $query = "INSERT INTO todoitems
                                (Title, Description)
                            VALUES 
                                (:item, :description)";
                $statement = $db->prepare($query);
                $statement->bindValue(':item', $item);
                $statement->bindValue(':description', $description);
                $statement->execute();
                $statement->closeCursor();
            }
            ?>

            <?php
                if ($item || $description){
                    $query = 'SELECT * FROM todoitems';
                    $statement = $db->prepare($query);
                    $statement->execute();
                    $results = $statement->fetchAll();
                    $statement->closeCursor();
                }
            ?>
            <?php if(!empty($results)) { ?>
                <section>
                    <table>
                        <?php foreach ($results as $result) : ?>
                        <tr>
                            <td><?php echo $result['Title']; ?></td>
                            <td><?php echo $result['Description']; ?></td>
                            <td><form action="delete_record.php" method="post">
                                <input type="hidden" name="id"
                                value="<?php echo $result['ItemNum']?>">
                                <input type="submit" value="Delete">
                            </form></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                <section>
                    <h2> Add Item </h2>
                    <form action="<?php echo $_SERVER ['PHP_SELF'] ?>" method = "POST">
                        <label for="item">Item:</label>
                        <input type="text" id="item" name="item" required>

                        <label for="description">Description:</label>
                        <input type="text" id="description" name="description" required>
                        <button>Add Item</button>
                    </form>
                </section>
            <?php } else { ?>
                <p>No to do list items exist yet.</p>
            <?php } ?>


        <?php } ?>
    </main>
</body>
</html>