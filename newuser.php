<?php include 'inc/header.php'; ?>
<?php
        if (!empty($_SESSION['user_id'])&&($_SESSION['type']=='majitel')){
            
            echo '<main>
<h2 class="center">Žádosti o administrátora</h2>

<div class="container-table">
    <table id="myTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Smazat</th>
                <th>Akceptovat</th>
                <th>Jméno</th>
                <th>Typ</th>
            </tr>
        </thead>
        <tbody>';
            include "inc/db-pdo.php";
            $query = $db->prepare('SELECT * FROM `users` WHERE akceptace=:akceptace;');
            $query->execute([
                ':akceptace'        => 'false'
            ]);
            while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                echo '
        <tr>
            <td class="table-icon">
                <a href="inc/delete_user.php?id=';
                echo $data['user_id'];
                echo '" onclick="return confirm(\'Opravdu chcete tento záznam trvale smazat?\')">
                    <img src="img/bin.png" alt="Smazat" width="25">

                </a>
            </td>
            <td><a href="inc/akcept_user.php?id=';
                echo $data['user_id'];
                echo '" onclick="return confirm(\'Souhlasíte se založením tohoto uživatele?\')">Akceptovat </a>
                                                    </td>
            <td>';
                echo $data['name'];
                echo '</td>
            <td>';
                echo $data['type'];
                echo '</td>
        </tr>
  </tbody>';
            } echo'
    </table>
</div>
<div class="btn-prihlasky">
    <a class="btn btn-primary btn-sm" href="logout.php" role="button">
        Odhlásit se
    </a>

</div>';
        }
        else{
          echo '<h2 class="center"> Do této karty nemáte přístup. </h2>';
        }
include 'inc/footer.php'; ?>