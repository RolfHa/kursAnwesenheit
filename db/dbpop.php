<?php
include '../class/User.php';
include '../class/Teilnehmer.php';
include '../class/Anwesenheit.php';
require_once '../vendor/autoload.php';

$faker = Faker\Factory::create('de_DE');
$faker->seed(100);

for ($i = 0; $i < 5; $i++) {
    $fname = $faker->firstName();
    $lname = $faker->lastName();
    $email = $faker->email();
    User::create($fname, $lname, '123', $email, 'dozent');
}

$fachrichung = 'AE';
for ($j = 0; $j < 30; $j++) {
    if ($j > 9 and $j < 19) {
        $fachrichung = 'FISI';
    } elseif ($j > 19) {
        $fachrichung = "DP";
    }
    $fname = $faker->firstName();
    $lname = $faker->lastName();
    $email = $faker->email();
    Teilnehmer::createteilnehmer($fname, $lname, '123', $email, 'teilnehmer', $fachrichung, '230619');
}

$berlinerFeiertage = [
    "Neujahrstag" => "2024-01-01",
    "Internationaler Frauentag" => "2024-03-08",
    "Karfreitag" => "2024-03-29",
    "Ostermontag" => "2024-04-01",
    "Tag der Arbeit" => "2024-05-01",
    "Christi Himmelfahrt" => "2024-05-09",
    "Pfingstmontag" => "2024-05-20",
    "Tag der Deutschen Einheit" => "2024-10-03",
    "Erster Weihnachtstag" => "2024-12-25",
    "Zweiter Weihnachtstag" => "2024-12-26"
];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anwesenheit";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

$sql = 'INSERT INTO anwesenheit (dozenten_id, teilnehmer_id, datum, status) VALUES (:dozenten_id, :teilnehmer_id, :date, :status)';
$stmt = $conn->prepare($sql);

$dozentenId = 1;

for ($monat = 1; $monat <= 3; $monat++) {
    $date = new DateTime("2024-$monat-1");
    $monatsTage = $date->format('t');
    for ($tag = 1; $tag <= $monatsTage; $tag++) {
        $datum = "2024-$monat-$tag";
        for ($teilnehmer = 1; $teilnehmer <= 30; $teilnehmer++) {
            if ($date->format('l') == "Saturday" or $date->format('l') == 'Sunday' or array_search($date->format('Y-m-d'), $berlinerFeiertage)) {
                $status = 'fe';
            } else {
                $status = $faker->randomElement(['o', 'x', 'n']);
            }
            $stmt->bindParam(':dozenten_id', $dozentenId);
            $stmt->bindParam(':teilnehmer_id', $teilnehmer);
            $stmt->bindParam(':date', $datum);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        }
        $date->modify('+1 day');
    }

}
