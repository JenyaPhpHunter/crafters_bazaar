<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Запрошення до бренду</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
<div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <h2 style="color: #0d6efd; text-align: center;">Запрошення до бренду "{{ $brand->title }}"</h2>

    @if($brand->image_path)
        <div style="text-align: center; margin: 20px 0;">
            <img src="{{ config('app.url') . '/storage/' . $brand->image_path }}"
                 alt="{{ $brand->title }}"
                 style="max-width: 100%; height: auto; border-radius: 6px;">
        </div>
    @endif

    <p style="font-size: 16px; color: #333;">
        Вас запросили приєднатися до бренду <strong>{{ $brand->title }}</strong> на нашій платформі.
    </p>

    <p style="font-size: 16px; color: #333;">
        Натисніть кнопку нижче, щоб переглянути бренд та приєднатися:
    </p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ config('app.url') }}/brands/{{ $brand->id }}"
           style="display: inline-block; padding: 12px 20px; background-color: #0d6efd; color: #fff; text-decoration: none; border-radius: 5px; margin-right: 10px;">
            Переглянути бренд
        </a>

        <a href="{{ route('brands.acceptInvitation', ['brand' => $brand->id, 'email' => $email]) }}"
           style="display: inline-block; padding: 12px 20px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px;">
            Доєднатися до бренду
        </a>
    </div>


    @if($brand->creator)
        <p style="font-size: 14px; color: #555;">
            Запрошення надіслав: <strong>{{ $brand->creator->name }}</strong>
        </p>
    @endif

    <p style="font-size: 14px; color: #666;">
        Якщо ви не очікували цього запрошення, просто проігноруйте цей лист.
    </p>

    <hr style="margin: 40px 0;">
    <p style="font-size: 12px; color: #999; text-align: center;">
        Цей лист згенеровано автоматично. Не відповідайте на нього.
    </p>
</div>
</body>
</html>
