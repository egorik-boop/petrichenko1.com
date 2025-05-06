<?php
// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';
    
    // Валидация данных
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Пожалуйста, введите ваше имя';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Пожалуйста, введите корректный email';
    }
    
    if (empty($message)) {
        $errors[] = 'Пожалуйста, введите ваше сообщение';
    }
    
    // Если ошибок нет - обрабатываем данные
    if (empty($errors)) {
        file_put_contents('messages.txt', 
            date('Y-m-d H:i:s') . "\nИмя: $name\nEmail: $email\nСообщение: $message\n\n", 
            FILE_APPEND);
        
        $success = 'Ваше сообщение успешно отправлено!';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Контакты</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        
        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #444;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        form {
            margin-top: 20px;
        }
        
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        textarea {
            height: 150px;
            resize: vertical;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        /* Сообщения об ошибках и успехе */
        .error-message {
            color: #d8000c;
            background-color: #ffd2d2;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        
        .success-message {
            color: #4F8A10;
            background-color: #DFF2BF;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        
        /* Стили для активной ссылки в меню */
        nav a.active {
            font-weight: bold;
            color: #f00;
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>

<main>
    <h1>Контакты</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
        <div class="success-message">
            <p><?= $success ?></p>
        </div>
    <?php endif; ?>
    
    <form method="post">
        <input type="text" name="name" placeholder="Имя" value="<?= isset($name) ? $name : '' ?>">
        <input type="email" name="email" placeholder="Email" value="<?= isset($email) ? $email : '' ?>">
        <textarea name="message"><?= isset($message) ? $message : '' ?></textarea>
        <button type="submit">Отправить</button>
    </form>
</main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
