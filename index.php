<?php
session_start();

$dt = new DateTime();
$action = $_REQUEST['action'] ?? ''; // REQUEST ist Kombi von GET und POST
$year = $_GET['year'] ?? $dt->format('Y');
$month = $_GET['month'] ?? $dt->format('m');
$teilnehmerIds = $_POST['teilnehmerIds'] ?? [];
$days = $_POST['days'] ?? []; // 2-dim $days[0] ist Anwesenheitsstati vom 1. Teilnehmer

$userId = $_SESSION['userId'] ?? 3;

$dtNew = DateTime::createFromFormat('Y-m-d', "$year-$month-1"); // Tag nötig, da 30. Feb beim Blättern Probleme macht

echo '<pre>GET';
print_r($_GET);
echo '</pre>';
echo '<pre>POST';
print_r($_POST);
echo '</pre>';
echo '<pre>SESSION';
print_r($_SESSION);
echo '</pre>';

spl_autoload_register(function ($class) {
    include 'class/' . $class . '.php';
});

if ($action === 'nextMonth') {
    $dtNew->add(new DateInterval('P1M'));
} elseif ($action === 'previousMonth') {
    $dtNew->sub(new DateInterval('P1M'));
} elseif ($action === 'update') {
    // Daten in Datenbank updaten
    $tnAdb = new TeilnehmerAnwesenheiten(Teilnehmer::findTeilById($teilnehmerIds[0]), Anwesenheit::findByMonthTId($teilnehmerIds[0]));
    echo '<pre>';
    print_r($tnAdb);
    echo '</pre>';
}


// neuer (angefragter) Monat
$year = $dtNew->format('Y');
$month = $dtNew->format('m');

try {
    $monthAnwesenheiten = Anwesenheit::findByMonth($month, $year);
    // Anzahl der Tage im Monat finden
    //$letzterMonatsTag = DateTime::createFromFormat('Y-m-d', "$year-$month-1")->format('t');
    $letzterMonatsTag = $dtNew->format('t');
    $germanMonthName = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
    $tns = Teilnehmer::findAll();
    //$view = 'listOneMonth';
    $view = 'testPulldown';
} catch (Exception $exception) {
    $errormsg = $exception->getMessage();
    $view = 'error';
}


include 'view/' . $view . '.php';