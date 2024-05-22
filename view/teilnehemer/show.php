<?php
include '../../class/User.php';
include '../../class/Teilnehmer.php';
include '../../class/Anwesenheit.php';

$teilnehmer_id = $_GET['id'];
$anwesenheiten = Anwesenheit::findByMonthTId($teilnehmer_id, 1);
$teilnehmer = Teilnehmer::findById($teilnehmer_id);
?>
<!doctype html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Document</title>
</head>
<body>

<?php echo '<h1>' . $teilnehmer->getFname() . " " . $teilnehmer->getLname() . '</h1>'; ?>
<div>
    <?php
    $color = 'withe';


    echo '<div style="display: flex">';
    foreach ($anwesenheiten as $index => $item) {
        if ($item->getStatus() == 'fe') {
            $color = 'green';
            $text = 'Frei';
        } elseif ($item->getStatus() == 'x') {
            $color = 'dodgerblue';
            $text = 'Anwesend';
        } elseif ($item->getStatus() == 'o') {
            $color = 'darkslateblue';
            $text = 'Online';
        } elseif ($item->getStatus() == 'n') {
            $color = 'red';
            $text = 'Nicht Dort';
        }

        if ($index == 0) {
            $zeile = 0;
            if ($item->getDatumObj()->format('w' == 0) or $item->getDatumObj()->format('w') == 6) {
                $leer = 0;
            } else {
                $anzahl = $item->getDatumObj()->format('w');
                $leer = $anzahl - 1;
            }
            $day = $item->getDatumObj()->format('w');
            for ($i = 0; $i < $leer; $i++) {
                echo "<span style='border-style: solid;align-self: stretch; align-self: stretch; width: 100px;display: inline-block; background-color: gray'>-</span>";

                $zeile++;
            }
        }
        echo "<span style='border-style: solid;width: 100px;display: inline-block; background-color: $color'>";
        echo $item->getDatum();
        echo "<br>";
        echo $text;
        echo '</span>';
        $zeile++;
        ($zeile % 7 == 0) ? printf(" </div><div>") : printf("");
    }
    ?>
</div>
</body>
</html>
