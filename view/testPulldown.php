<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anwesenheiten</title>
    <style>
        select {
            /* for Firefox */
            -moz-appearance: none;
            /* for Safari, Chrome, Opera */
            -webkit-appearance: none;
            font-size: 18px;
        }

        th {
            width: 20px;
        }

        table {
            border-collapse: collapse;
            float: left;
        }

        tr:nth-child(even) {
            background-color: #e2e2e2;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th><a href="index.php?action=previousMonth&month=<?php echo $month; ?>&year=<?php echo $year; ?>"><button><=</button></a> <?php echo $germanMonthName[$month - 1] . " $year"; ?> <a href="index.php?action=nextMonth&month=<?php echo $month; ?>&year=<?php echo $year; ?>"><button>=></button></a></th>
        <?php
        for ($i = 0; $i < 31; $i++) {
            ?>
            <th><?php echo($i + 1); ?></th>
            <?php
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <form method="post" action="index.php" id="form1">
        <input type="hidden" name="year" value="<?php echo $year; ?>">
        <input type="hidden" name="month" value="<?php echo $month; ?>">
        <input type="hidden" name="action" value="update">
        <!-- Ausgabe pro Teilnehmer -->
        <?php for ($j = 1; $j <= count($tns); $j++) {
            ?>
            <tr>
                <!-- Teilnehmername ausgeben -->
                <td style="width: 300px;"><?php echo $tns[$j-1]->getFullName() . ' : '; ?></td>
                <input type="hidden" name="teilnehmerIds[]" value="<?php echo $tns[$j-1]->getId(); ?>">
                <?php
                // Ausgabe aller Monatsdaten
                for ($k = 0; $k < $letzterMonatsTag; $k++) {
                    ?>
                    <td>
                        <select name="days[<?php echo $tns[$j-1]->getId(); ?>][]" tabindex="<?php echo $j + 31 * $k; ?>">
                            <option><?php echo $monthAnwesenheiten[($j-1) * $letzterMonatsTag + $k]->getStatus(); ?></option>
                            <option></option>
                            <option>x</option>
                            <option>o</option>
                            <option>n</option>
                            <option>fe</option>
                            <option>kr</option>
                        </select>
                    </td>
                    <?php
                }
                ?>
            </tr>
            <?php
        }
        ?>

    </form>
    </tbody>
</table>
<div><input type="submit" id="testing" onclick="document.getElementById('form1').submit(this)"></div>
<?php //echo $j; ?>

</body>
</html>


