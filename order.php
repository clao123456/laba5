<?php
$conn = new mysqli('localhost', 'root', '', 'shop_db');
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $user_id = $_POST['user_id']; 

    $stmt = $conn->prepare("INSERT INTO orders (product_name, quantity, price, user_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("siis", $product, $quantity, $price, $user_id);

    if ($stmt->execute()) {
        $message = '<div class="message success">Заказ успешно оформлен!</div>';
    } else {
        $message = '<div class="message error">Ошибка: ' . $stmt->error . '</div>';
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Оформление заказа</h1>
        <?= $message ?>
        <form method="POST">
            <input type="text" name="product" placeholder="Название товара" required>
            <input type="number" name="quantity" placeholder="Количество" required>
            <input type="number" step="0.01" name="price" placeholder="Цена товара" required>
            <input type="number" name="user_id" placeholder="ID пользователя" required>
            <button type="submit">Оформить заказ</button>
        </form>
        <a href="main.php">Вернуться на главную</a>
    </div>
</body>

</html>