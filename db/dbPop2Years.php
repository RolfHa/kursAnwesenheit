[10:58] Rene Kraatz
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
    "Neujahrstag" => "2023-01-01",
    "Internationaler Frauentag" => "2023-03-08",
    "Karfreitag" => "2023-04-07",
    "Ostermontag" => "2023-04-10",
    "Tag der Arbeit" => "2023-05-01",
    "Christi Himmelfahrt" => "2023-05-18",
    "Pfingstmontag" => "2023-05-29",
    "Tag der Deutschen Einheit" => "2023-10-03",
    "Erster Weihnachtstag" => "2023-12-25",
    "Zweiter Weihnachtstag" => "2023-12-26",
    "Neujahrstag2" => "2024-01-01",
    "Internationaler Frauentag2" => "2024-03-08",
    "Karfreitag2" => "2024-03-29",
    "Ostermontag2" => "2024-04-01",
    "Tag der Arbeit2" => "2024-05-01",
    "Christi Himmelfahrt2" => "2024-05-09",
    "Pfingstmontag2" => "2024-05-20",
    "Tag der Deutschen Einheit2" => "2024-10-03",
    "Erster Weihnachtstag2" => "2024-12-25",
    "Zweiter Weihnachtstag2" => "2024-12-26",
    "Neujahrstag3" => "2025-01-01",
    "Internationaler Frauentag3" => "2025-03-08",
    "Karfreitag3" => "2025-04-18",
    "Ostermontag3" => "2025-04-21",
    "Tag der Arbeit3" => "2025-05-01",
    "Christi Himmelfahrt3" => "2025-05-29",
    "Pfingstmontag3" => "2025-06-09",
    "Tag der Deutschen Einheit3" => "2025-10-03",
    "Erster Weihnachtstag3" => "2025-12-25",
    "Zweiter Weihnachtstag3" => "2025-12-26"
];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anwesenheit";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$sql = 'INSERT INTO anwesenheit (dozenten_id, teilnehmer_id, datum, status) VALUES (:dozenten_id, :teilnehmer_id, :date, :status)';
$stmt = $conn->prepare($sql);
$dozentenId = 1;
for ($year = 2023; $year <= 2025; $year++) {
    for ($monat = 1; $monat <= 12; $monat++) {
        $date = DateTime::createFromFormat('Y-m-d', "$year-$monat-1");
        $monatsTage = $date->format('t');
        for ($tag = 1; $tag <= $monatsTage; $tag++) {
            $datum = "$year-$monat-$tag";
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
}
