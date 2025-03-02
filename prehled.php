<?php include 'inc/header.php'; ?>
<?php
        if (!empty($_SESSION['user_id'])&&($_SESSION['type']=='majitel')){
            
            echo '<main>
            <!-- Nadpis, export excel -->
                <h2 class="center">Akceptace přihlášek</h2>
                <div class="filter">
                <form method="post">    
                        <label for="year">Vyberte rok:</label>
                        <select name="year" required>
                            <option value="">--</option>
                            <option value="'; echo date("Y"); echo'">'; echo date("Y"); echo'</option>
                            <option value="'; echo date("Y")-1; echo'">'; echo date("Y")-1; echo'</option>
                            <option value="'; echo date("Y")-2; echo'">'; echo date("Y")-2; echo'</option>
                            <option value="'; echo date("Y")-3; echo'">'; echo date("Y")-3; echo'</option>
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
                        <th style="font-size: 13px;">Smazat</th>
                        <th style="font-size: 13px;">Upravit</th>
                        <th>Akceptace</th>
                        <th>ID přihlášky</th>
                        <th>Jméno</th>
                        <th>Příjmení</th>
                        <th>Narození</th>
                        <th>Turnus</th>
                        <th>Datum podání</th>
                        <th>Poslat mail</th>
                    </tr>
                </thead>
                <tbody>';
                   /*NAČTENÍ DAT Z DB - NAHRÁNÍ NA WEB */
                    include "inc/db-pdo.php";
                    
                    $year = date("Y"); 
                    if(!empty($_POST['year'])){
                        $year = $_POST['year'];
                        $query=$db->prepare('SELECT * FROM `dite` join prihlaska on (dite.id = prihlaska.dite_id) join turnus on (turnus.turnus_id = prihlaska.turnus_id) where created like ?;');
                        $query->execute(array("%$year%"));  
                    }else{ 
                        $query=$db->prepare('SELECT * FROM `dite` join prihlaska on (dite.id = prihlaska.dite_id) join turnus on (turnus.turnus_id = prihlaska.turnus_id) where created like ?;');
                        $query->execute(array("%$year%")); 
                    }
                    // $queryAkcept=$db->prepare('SELECT * FROM `dite` WHERE created like ?;');
                    // $akcept= $queryAkcept->fetchAll(PDO::FETCH_ASSOC);

                    while ($data = $query->fetch(PDO::FETCH_ASSOC)){
                        echo '
                        <tr>
                            <td class="table-icon">
                                <a href="delete.php?id='; echo $data['prihlaska_id']; echo '" onclick="return confirm(\'Opravdu chcete tento záznam trvale smazat?\')">
                                    <img src="img/bin.png" alt="Smazat" width="25">
        
                                </a>
                            </td>
                            <td class="table-icon"><a href="edit.php?id='; echo $data['prihlaska_id']; echo '"><img src="img/edit.png" alt="Změnit" width="20"></a></td>
                            <td>';
                            if ($data['akceptace']==true){
                                echo 'Akceptované';
                            }else{
                            echo '
                            <a href="akcept.php?id='; echo $data['prihlaska_id']; echo '" onclick="return confirm(\'Opravdu chcete akceptovat přihlášku?\')">Akceptovat </a>'; } echo '
                                                                    </td>
                            <td>'; echo $data['prihlaska_id'];          echo '</td>
                            <td>'; echo htmlspecialchars($data['jmeno']);       echo '</td>
                            <td>'; echo htmlspecialchars($data['prijmeni']);    echo '</td>
                            <td>'; echo htmlspecialchars(date('d.m. Y', strtotime($data['narozeni'])));    echo '</td>
                            <td>'; echo htmlspecialchars($data['turnus']);      echo '</td>
                            <td>'; echo htmlspecialchars(date('d.m. Y, h:m', strtotime($data['created'])));     echo '</td>
                            <td>';
                            if ($data['akceptace']==false){
                                echo '--';
                            }elseif($data['korespondence']==true){
                                echo 'Odesláno';
                            }else{
                            echo '
                            <a href="send.php?rodic=1&amp;id='; echo $data['prihlaska_id']; echo '" onclick="return confirm(\'Chcete odeslat potvrzovací email?\')">'; echo htmlspecialchars("{$data['rjmeno']} {$data['rprijmeni']} |");    echo ' </a>
                            <a href="send.php?rodic=2&amp;id='; echo $data['prihlaska_id']; echo '" onclick="return confirm(\'Chcete odeslat potvrzovací email?\')">'; echo htmlspecialchars("{$data['rjmeno2']} {$data['rprijmeni2']}");    echo ' </a> '; } echo '
                            </td>
        
                        </tr>';
                   
                    }
                    echo'
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

        }
        else{
          echo '<h2 class="center"> Do této karty nemáte přístup. </h2>';
        }
      ?>

<?php include 'inc/footer.php'; ?>




