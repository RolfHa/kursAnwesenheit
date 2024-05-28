<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anwesenheiten</title>

</head>
<body>
<table>
    <tr>
        <th><a href="index.php?action=previousMonth&month=<?php echo $month; ?>&year=<?php echo $year; ?>"><button><=</button></a> <?php echo $germanMonthName[$month - 1] . " $year"; ?> <a href="index.php?action=nextMonth&month=<?php echo $month; ?>&year=<?php echo $year; ?>"><button>=></button></a></th>
        <?php
        for ($i = 0; $i < $letzterMonatsTag; $i++) {
            ?>
            <th><?php echo($i + 1); ?></th>
            <?php
        }
        ?>
    </tr>
    <!-- Ausgabe pro Teilnehmer -->
    <?php for ($j = 1; $j < $letzterMonatsTag; $j++) {
        ?>
        <tr>
            <!-- Teilnehmername ausgeben -->
            <td><?php echo $tns[($j - 1)]->getFullName() . ' : '; ?></td>
            <?php
            // Ausgabe aller Monatsdaten
            for ($i = ($j - 1) * $letzterMonatsTag; $i < $letzterMonatsTag + ($j - 1) * $letzterMonatsTag; $i++) {
                ?>
                <td>
                    <?php
                    echo $monthAnwesenheiten[$i]->getStatus();
                    ?>
                </td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>