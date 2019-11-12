<?php
/*
Plik wymagany.
Jeśli nie istnieje, wystąpi bład krytyczny.
Serwer przerwie ładowanie strony.
*/
require_once('database.php');

if(isset($_GET['send'])) {
    $send = 'a'.$_GET['send'];
    switch($send) {
        case 'ateacher':
            $data = [
                'imie' => $_POST['imie'],
                'nazwisko' => $_POST['nazwisko'],
                'pesel' => $_POST['pesel']
            ];
            $db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
            $sql = 'insert into nauczyciele values (NULL, :imie, :nazwisko, :pesel)';
            $db_stmt = $db_conn->prepare($sql);
            $db_stmt->execute($data);
            $db_conn = null;
            header('Location: index.php');
        break;
        default:
            echo 'Co robisz dzbanie!';
    }
}

if(isset($_GET['cmd'])) {
    $cmd = 'c'.$_GET['cmd'];
    switch($cmd) {
        case 'cupdate':
            $data = [
                'id' => $_GET['id']
            ];
            $db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
            $sql = 'select imie, nazwisko, pesel from nauczyciele where id = :id';
            $db_stmt = $db_conn->prepare($sql);
            $db_stmt->execute($data);
            $teacher = $db_stmt->fetchAll();
            $db_conn = null;
        break;
        case 'cdelete':
        break;
        default:
            echo 'Co robisz dzbanie!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    .list .title {
        font-weight: bold;
        padding: 15px;
    }
    .content div {
        display: inline-block;
        width: 15%;
        padding: 15px;
    }
    .content:hover {
        background-color: #ddd;
    }
    .content div a {
        text-decoration: none;
        color: #000;
        cursor: default;
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 10px;
        margin: 0 5px;
    }
    .content div a:hover {
        background-color: #fcc;
    }
    </style>
</head>
<body>
    <form action="index.php?send=teacher" method="post" name="addTeacher" id="addTeacher">
        <input type="text" name="imie" value="<?= (isset($teacher[0]['imie'])) ? ($teacher[0]['imie']) : ('') ?>" id="">
        <input type="text" name="nazwisko" value="<?= (isset($teacher[0]['nazwisko'])) ? ($teacher[0]['nazwisko']) : ('') ?>" id="">
        <input type="text" name="pesel" value="<?= (isset($teacher[0]['pesel'])) ? ($teacher[0]['pesel']) : ('') ?>" id="">
        <input type="submit" value="Zapisz">
    </form>
    <div class="list" id="nauczyciele">
        <div class="title">Nauczyciele</div>
<?php
$db_conn = dbConnect($db_server, $db_name, $db_user,$db_pass);
$db_query = $db_conn->query('select * from nauczyciele');
foreach($db_query as $row) {
?>
        <div class="content">
            <div><?= $row['imie'] ?></div>
            <div><?= $row['nazwisko'] ?></div>
            <div><?= $row['pesel'] ?></div>
            <div>
                <a href="index.php?cmd=update&amp;id=<?= $row['id'] ?>">Edytuj</a>
                <a href="index.php?cmd=delete&amp;id=<?= $row['id'] ?>">Usuń</a>
            </div>
        </div>
<?php
}
?>
    </div>
</body>
</html>