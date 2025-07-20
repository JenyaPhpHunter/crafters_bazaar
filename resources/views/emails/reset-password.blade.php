<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Скидання паролю</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
<table style="max-width: 600px; margin: auto; background-color: #fff; padding: 20px; border-radius: 10px;">
    <tr>
        <td>
            <h2 style="color: #333;">Вітаємо!</h2>
            <p>Ми отримали запит на скидання паролю до вашого акаунта.</p>
            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ $url }}" style="display: inline-block; padding: 10px 20px; background-color: #72A499; color: white; text-decoration: none; border-radius: 5px;">
                    Скинути пароль
                </a>
            </p>
            <p>Це посилання дійсне протягом 60 хвилин.</p>
            <p>Якщо ви не надсилали запит, просто проігноруйте цей лист.</p>
            <p style="margin-top: 30px;">З повагою,<br>{{ config('app.name') }}</p>
        </td>
    </tr>
</table>
</body>
</html>
