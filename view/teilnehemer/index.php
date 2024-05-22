<?php
include '../../class/User.php';
include "../../class/Teilnehmer.php";
$teilnehmer = Teilnehmer::findAll();
foreach ($teilnehmer as $teil) {
    echo'<a href="show.php?id='.$teil->getId().'">'.$teil->getFname().'</a><br>';
}