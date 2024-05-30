<?php
$dt = new DateTime();
$action = $_GET['action'] ?? '';
$year = $_GET['year'] ?? $dt->format('Y');
$month = $_GET['month'] ?? $dt->format('m');
$dtNew = DateTime::createFromFormat('Y-m', "$year-$month");
// ist Kurzform für
//if (isset($_GET['action']) {
//    $action = isset($_GET['action']);
//} else {
//    $action = '';
//}
echo '<pre>GET';
print_r($_GET);
echo '</pre>';
echo '<pre>POST';
print_r($_POST);
echo '</pre>';

spl_autoload_register(function ($class) {
    include 'class/' . $class . '.php';
});

if ($action === 'nextMonth') {
    $dtNew->add(new DateInterval('P1M'));
} elseif ($action === 'previousMonth') {
    $dtNew->sub(new DateInterval('P1M'));
}
echo '<pre>';
print_r($dtNew);
echo '</pre>';

// neuer (angefragter) Monat
$year = $dtNew->format('Y');
$month = $dtNew->format('m');

try {
    $monthAnwesenheiten = Anwesenheit::findByMonth($month, $year);
    // Anzahl der Tage im Monat finden
    $letzterMonatsTag = DateTime::createFromFormat('Y-m', "$year-$month")->format('t');
    $germanMonthName = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
    $tns = Teilnehmer::findAll();
    $view = 'listOneMonth';
} catch (Exception $exception) {
    $errormsg = $exception->getMessage();
    $view = 'error';
}


include 'view/' . $view . '.php';