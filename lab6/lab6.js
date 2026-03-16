// Завдання 1
const a = 77;
const b = 7;

console.log("Сума:", a + b);
console.log("Різниця:", a - b);
console.log("Множення:", a * b);
console.log("Ділення:", a / b);

// Завдання 2
const firstName = "Дарина";
const lastName = "Ільчук";
const fullName = `${firstName} ${lastName}`;

console.log(`Добрий день, ${fullName}!`);

// Завдання 3
const age = 18;

if (age >= 18) {
    console.log("Доступ дозволено");
} else {
    console.log("Доступ заборонено");
}

// Завдання 4
for (let i = 1; i <= 10; i++) {
    console.log(i);
}

// Завдання 5
function square(number) {
    return number ** 2;
}

console.log("Квадрат числа 5:", square(5));

// Завдання 6
const fruits = ["Ананас", "Полуниця", "Груша"];
fruits.push("Пітахайя червона");

console.log("Масив фруктів:", fruits);