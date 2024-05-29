<?php
$month = 5;
$year = 2024
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
            font-size: 20px;
        }

        th {
            width: 20px;
        }
        table {
            border-collapse: collapse;
            float: left;
        }

    </style>
</head>
<body>
<form method="post" action="index.php">
<table>
    <tr>
        <th><a href="index.php?action=previousMonth&month=<?php echo $month; ?>&year=<?php echo $year; ?>">
                <button><=</button>
            </a>Mai<?php echo $year; ?> <a
                    href="index.php?action=nextMonth&month=<?php echo $month; ?>&year=<?php echo $year; ?>">
                <button>=></button>
            </a></th>
        <?php
        for ($i = 0; $i < 31; $i++) {
            ?>
            <th><?php echo($i + 1); ?></th>
            <?php
        }
        ?>
    </tr>
    <!-- Ausgabe pro Teilnehmer -->
    <?php for ($j = 1; $j < 31; $j++) {
        ?>
        <tr>
            <!-- Teilnehmername ausgeben -->
            <td style="width: 300px;">Peter Panne</td>
            <?php
            // Ausgabe aller Monatsdaten
            for ($k = 0; $k < 31; $k++) {
                ?>
                <td>
                    <select name="cars" id="cars" tabindex="<?php echo $j + 31 * $k; ?>">
                        <option></option>
                        <option>x</option>
                        <option>o</option>
                        <option>n</option>
                    </select>
                </td>
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
</table>
    <div><input type="submit"></div>
</form>
</body>
</html>


