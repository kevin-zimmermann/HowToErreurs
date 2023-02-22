<?php
require 'session.php';
require 'db_connect.php';

$sql = "DELETE FROM utilisateurs WHERE id = :id ";
$query = $bdd->prepare($sql);
$query->execute(['id' => $_SESSION['id']]);

include 'logout.php';
