<?php
mb_internal_encoding("UTF-8");

// Завдання 1: знайти факторіали всіх чисел у масиві.
echo "Завдання 1:\n";
$array1 = [2, 4, 5, 7, 9];
$factorials = array_map(function($num) {
    $fact = 1;
    for ($i = 1; $i <= $num; $i++) {
        $fact *= $i;
    }
    return $fact;
}, $array1);
print_r($factorials);
echo "\n";

// Завдання 2: знайти суму чисел масиву, кратних 3 і 5.
echo "Завдання 2:\n";
$array2 = [];
for ($i = 0; $i < 30; $i++) {
    $array2[] = rand(1, 100);
}
$sum2 = 0;
foreach ($array2 as $num) {
    if ($num % 3 == 0 && $num % 5 == 0) {
        $sum2 += $num;
    }
}
echo "Сума чисел, кратних 3 і 5: $sum2\n\n";

// Завдання 3: знайти найбільше значення у масиві.
echo "Завдання 3:\n";
$array3 = [14, 55, 89, 23, 7, 99, 42];
echo "Найбільше значення: " . max($array3) . "\n\n";

// Завдання 4: порахувати кількість простих чисел у масиві.
echo "Завдання 4:\n";
$array4 = [];
for ($i = 0; $i < 20; $i++) {
    $array4[] = rand(10, 100);
}
$primeCount = 0;
foreach ($array4 as $num) {
    $isPrime = true;
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            $isPrime = false;
            break;
        }
    }
    if ($isPrime) $primeCount++;
}
echo "Кількість простих чисел: $primeCount\n\n";

// Завдання 5: заміна парних індексів на 0 в масиві.
echo "Завдання 5:\n";
$array5 = [];
for ($i = 0; $i < 20; $i++) {
    $array5[] = rand(0, 30);
}
foreach ($array5 as $index => $value) {
    if ($index % 2 == 0) {
        $array5[$index] = 0;
    }
}
print_r($array5);
echo "\n";

// Завдання 6: сума елементів кратних 3 у масиві.
echo "Завдання 6:\n";
$array6 = [];
for ($i = 0; $i < 12; $i++) {
    $array6[] = rand(-20, 20);
}
$sum6 = 0;
foreach ($array6 as $num) {
    if ($num % 3 == 0) {
        $sum6 += $num;
    }
}
echo "Сума елементів, кратних 3: $sum6\n\n";

// Завдання 7: скорочений формат ПІБ.
echo "Завдання 7:\n";
$inputName = "Ільчук Дарина";
$nameParts = explode(" ", $inputName);
if (count($nameParts) >= 2) {
    $shortName = $nameParts[0] . " " . mb_substr($nameParts[1], 0, 1) . ".";
    echo "Стислий формат: $shortName\n\n";
}

// Завдання 8: найменший високосний рік у масиві.
echo "Завдання 8:\n";
$years = [2021, 2024, 2000, 2019, 2016, 1998];
$leapYears = array_filter($years, function($year) {
    return ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
});
if (!empty($leapYears)) {
    echo "Найменший високосний рік: " . min($leapYears) . "\n\n";
} else {
    echo "Високосних років у масиві немає\n\n";
}

// Завдання 9: обмін мінімального та максимального елементів.
echo "Завдання 9:\n";
$array9 = [];
for ($i = 0; $i < 10; $i++) {
    $array9[] = rand(1, 100);
}
echo "Початковий масив:\n";
print_r($array9);

$minVal = min($array9);
$maxVal = max($array9);
$minIndex = array_search($minVal, $array9);
$maxIndex = array_search($maxVal, $array9);

$array9[$minIndex] = $maxVal;
$array9[$maxIndex] = $minVal;

echo "Масив після обміну:\n";
print_r($array9);
echo "\n";


// Завдання 10: обчислення суми та квадратів ряду.
echo "Завдання 10:\n";
$n = 5;
$sum10 = 0;

echo "Квадрати чисел від 1 до $n: ";
for ($i = 1; $i <= $n; $i++) {
    $square = $i * $i;
    echo $square . " ";
    $sum10 += $square;
}
echo "\nСума квадратів: $sum10\n";

?>
