<?php

require_once 'connec.php';

try {
    $db = new \PDO(DSN, USER, PASS);
} catch (\PDOException $e) {
    die("Erreur : " . $e->getMessage());
}


$query = "SELECT * FROM friend";
$statement = $db->query($query);

$friendsObject = $statement->fetchAll(PDO::FETCH_OBJ);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My friends</title>
</head>

<body>
    <main>
        <ul><?php foreach ($friendsObject as $friend) { ?>

                <li><?php echo $friend->firstname . ' ' . $friend->lastname; ?></li>

            <?php } ?>
        </ul>
        <form method="post">

            <label for="firstname">Prénom :</label>
            <input type="text" name="firstname" id="firstname" maxlength="45" required></input>

            <label for="lastname">Nom :</label>
            <input type="text" name="lastname" id="lastname" maxlength="45" required></input>

            <button type="submit">Devenir mon ami</button>
            <?php

            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);

            $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
            $statement = $db->prepare($query);

            $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
            $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

            $statement->execute();
            header('HTTP/1.1 200 OK');
            exit;
            ?>
        </form>
    </main>

</body>

</html>