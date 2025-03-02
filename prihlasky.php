<?php include 'inc/header.php'; ?>

<?php
        if (!empty($_SESSION['user_id'])){
            
            echo '<main>
            <!-- Nadpis, export excel -->
                <h2 class="center dolu">Podané přihlášky</h2>
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
                        <th>ID</th>
                        <th>Jméno</th>
                        <th>Příjmení</th>
                        <th>Narození</th>
                        <th>Bydliště</th>
                        <th>PSČ</th>
                        <th>Turnus</th>
                        <th>Jméno rodiče 1</th>
                        <th>Příjmení rodiče 1</th>
                        <th>Email 1</th>
                        <th>Telefon 1</th>
                        <th>Jméno rodiče 2</th>
                        <th>Příjmení rodiče 2</th>
                        <th>Email 2</th>
                        <th>Telefon 2</th>
                        <th>Odkud</th>
                        <th>Datum podání</th>
                    </tr>
                </thead>
                <tbody>';
                   /*NAČTENÍ DAT Z DB - NAHRÁNÍ NA WEB */
                    include "inc/db-pdo.php";
                    
                    $year = date("Y"); 
                    if(!empty($_POST['year'])){
                        $year = $_POST['year'];

                        $query=$db->prepare('SELECT * FROM `dite` join prihlaska on (dite.id = prihlaska.dite_id) join turnus on (turnus.turnus_id = prihlaska.turnus_id) where created like ? ;');
                        $query->execute(array("%$year%"));  

                    }else{ 
                        $query=$db->prepare('SELECT * FROM `dite` join prihlaska on (dite.id = prihlaska.dite_id) join turnus on (turnus.turnus_id = prihlaska.turnus_id) where created like ?;');
                        $query->execute(array("%$year%"));  
                    }
                
                    while ($data = $query->fetch(PDO::FETCH_ASSOC)){
                        echo '
                        <tr>
                            <td class="table-icon">
                                <a href="delete.php?id='; echo htmlspecialchars($data['prihlaska_id']); echo '" onclick="return confirm(\'Opravdu chcete tento záznam trvale smazat?\')">
                                    <img src="img/bin.png" alt="Smazat" width="25">
        
                                </a>
                            </td>
                            <td class="table-icon"><a href="edit.php?id='; echo htmlspecialchars($data['prihlaska_id']); echo '"><img src="img/edit.png" alt="Změnit" width="20"></a></td>
                          
                            <td>';
                            if ($data['akceptace']==true){
                                echo '<img src="img/accept.png" alt="ano" width="15">ano';
                            }else{
                                echo '<img src="img/reject.png" alt="ne" width="15">ne'; } echo '</td> 
                            <td>'; echo htmlspecialchars($data['id']);          echo '</td> 
                            <td>'; echo htmlspecialchars($data['jmeno']);       echo '</td>
                            <td>'; echo htmlspecialchars($data['prijmeni']);    echo '</td>
                            
                            <td>'; echo date('d.m. Y', strtotime(htmlspecialchars($data['narozeni'])));    echo '</td>
                            <td>'; echo htmlspecialchars($data['bydliste']);    echo '</td>
                            <td>'; echo htmlspecialchars($data['psc']);         echo '</td>
                            <td>'; echo htmlspecialchars($data['turnus']);      echo '</td>
                            <td>'; echo htmlspecialchars($data['rjmeno']);      echo '</td>
                            <td>'; echo htmlspecialchars($data['rprijmeni']);   echo '</td>
                            <td>'; echo htmlspecialchars($data['remail']);      echo '</td>
                            <td>'; echo htmlspecialchars($data['rtelefon']);    echo '</td>
                            <td>'; echo htmlspecialchars($data['rjmeno2']);      echo '</td>
                            <td>'; echo htmlspecialchars($data['rprijmeni2']);   echo '</td>
                            <td>'; echo htmlspecialchars($data['remail2']);      echo '</td>
                            <td>'; echo htmlspecialchars($data['rtelefon2']);    echo '</td>
                            <td>'; echo htmlspecialchars($data['odkud']);       echo '</td>
                            <td>'; echo date('d.m. Y, h:m', strtotime(htmlspecialchars($data['created'])));     echo '</td>
        
                        </tr>';
                   
                    }
                    echo'
                  </tbody>  
                </table>
            </div>
            <div class="btn-prihlasky">
                    <a  class="btn btn-primary btn-sm" href="export.php?year='; echo $year; echo '" title="Click to export" role="button">
                        Export dat
                    </a>
                
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