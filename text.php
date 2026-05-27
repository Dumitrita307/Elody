
<?php

echo "<h1>Farmacia Elody</h1>";
echo "<p>Sănatatea este cea mai importantă de aceia alegem farmacia Elody cu încredere.</p>";

error_log("Rulez text.php");




$numbers = [3, 17, 12, 7, 5, 20, 14, 9, 2, 11];

$pare = 0;
$impare = 0;

echo "<h2>Verificare numere pare și impare</h2>";

for ($i = 0; $i < count($numbers); $i++) {

    if ($numbers[$i] % 2 == 0) {
        echo $numbers[$i] . " este număr PAR <br>";
        $pare++;
    } else {
        echo $numbers[$i] . " este număr IMPAR <br>";
        $impare++;
    }
}

echo "<br>";
echo "Total numere pare: " . $pare . "<br>";
echo "Total numere impare: " . $impare;
?>

