<?php include 'inc/header.php'; ?>
<?php
if (!empty($_SESSION['user_id']) && ($_SESSION['type'] == 'majitel')) {
    echo '<main>
                <h2 class="center">Stav přihlášek</h2>
                <div class="filter">
                <form method="post">    
                        <label for="year">Vyberte rok:</label>
                        <select name="year" required>
                            <option value="">--</option>
                            <option value="';
    echo date("Y");
    echo '">';
    echo date("Y");
    echo '</option>
                            <option value="';
    echo date("Y") - 1;
    echo '">';
    echo date("Y") - 1;
    echo '</option>
                            <option value="';
    echo date("Y") - 2;
    echo '">';
    echo date("Y") - 2;
    echo '</option>
                            <option value="';
    echo date("Y") - 3;
    echo '">';
    echo date("Y") - 3;
    echo '</option>
                        </select>
                        <input class="btn btn-secondary btn-sm" type="submit" name="filtr" value="Filtrovat" role="button"/>
                    
                </form>
                </div>
                <div class="clear"></div>

            <!-- Tabulka z db -->
            <div class="container-table">
                <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Turnus</th>
                        <th>Termín</th>
                        <th>Přihlášených dětí</th>
                        <th>Max dětí</th>
                        <th>Rok</th>
                    </tr>
                </thead>
                <tbody>';
    /*NAČTENÍ DAT Z DB - NAHRÁNÍ NA WEB */
    include "inc/db-pdo.php";

    $year = date("Y");
    if (!empty($_POST['year'])) {
        $year = $_POST['year'];
        $query = $db->prepare('SELECT * FROM turnus where rok like ?;');
        $query->execute(array("%$year%"));
    } else {
        $query = $db->prepare('SELECT * FROM turnus where rok like ?;');
        $query->execute(array("%$year%"));
    }

    while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
        echo '
                        <tr>
                            <td>';
        echo htmlspecialchars($data['turnus']);
        echo '</td>
                            <td>';
        echo htmlspecialchars(date('d.m.', strtotime($data['od'])));
        echo '&nbsp;-&nbsp;';
        echo htmlspecialchars(date('d.m.', strtotime($data['do'])));
        echo '</td>
                            <td>';
        $pocetQuery = $db->prepare('SELECT COUNT(prihlaska_id) AS pocet FROM prihlaska WHERE turnus_id=:turnus_id');
        $pocetQuery->execute([
            ':turnus_id'        => $data['turnus_id']
        ]);
        $pocet =  $pocetQuery->fetch(PDO::FETCH_ASSOC);
        echo htmlspecialchars($pocet['pocet']);
        echo '</td>
                            <td>';
        echo htmlspecialchars($data['max']);
        echo '</td>
                            <td>';
        echo htmlspecialchars($data['rok']);
        echo '</td>
        
                        </tr>';
    }
    echo '
                  </tbody>  
                </table>
            </div>
            <div class="btn-prihlasky">
                
                
                    <a class="btn btn-primary btn-sm" href="logout.php" role="button">
                        Odhlásit se
                    </a>
               
            </div>
            <div class="clear"></div>
        </main>';
} else {
    echo '<h2 class="center"> Do této karty nemáte přístup. </h2>';
}
?>

<?php include 'inc/footer.php'; ?>