<?php
  /** @var \PDO $db - připojení k databázi */
  $dbPassword = file_get_contents("../secrets/dbPassword"); 
  $db = new PDO('mysql:host=127.0.0.1;dbname=vecs00;charset=utf8', 'vecs00', $dbPassword);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);