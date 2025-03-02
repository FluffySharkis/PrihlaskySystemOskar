
<footer>
<div>Tábor Oskar</div>
    <div class="admin">
        <?php
        if (!empty($_SESSION['user_id'])) {
            echo '<strong>' . htmlspecialchars($_SESSION['user_name']) . '</strong>';
            echo '&nbsp; Přihlášen';
        } else {
            echo '&nbsp; Odhlášen - <a href="../login.php">Přihlaste se</a>';
        }
        ?>
    </div>
</footer>
<script type="text/javascript" src="js/js.js"></script>
</body>

</html>