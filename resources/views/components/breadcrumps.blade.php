<!-- Відображення повідомлення про помилку із сесії -->
@if (session('error'))
    <div id="alert-error" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Відображення успішного повідомлення із сесії -->
@if (session('success'))
    <div id="alert-success" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Відображення помилок валідації -->
@if ($errors->any())
    <div id="alert-validation" class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Секція заголовка та хлібних крихт -->
<div class="page-title-section section">
    <div class="row align-items-center">
        <!-- Колонка для заголовка та хлібних крихт -->
        <div class="col-12 col-md-6">
            <div class="page-title">
                <!-- Заголовок сторінки -->
                <h1 class="title">
                    @foreach($breadcrumbs as $item)
                        @if (is_array($item['title']) && count($item['title']) > 0)
                            {{ implode(' / ', $item['title']) }}
                        @endif
                    @endforeach
                </h1>
            </div>
            <!-- Контейнер для хлібних крихт -->
            <div class="breadcrumb-container">
                <ul class="breadcrumb">
                    @foreach($breadcrumbs as $index => $breadcrumb)
                        <li class="breadcrumb-item" data-index="{{ $index }}">
                            @if ($index > 0)
                                <span class="breadcrumb-divider">/</span>
                            @endif
                            <a href="{{ $breadcrumb['route'] }}">{{ $breadcrumb['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!-- Колонка для кнопок -->
        <div class="col-12 col-md-6">
            <div class="button-container">
                @foreach($buttons as $button)
                    <a class="btn btn-primary2" href="{{ $button['route'] }}">
                        {{ $button['name'] }}
                        <i class="{{ $button['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- JavaScript для анімації алертів і хлібних крихт -->
<script>
    // Функція для видалення алертів із плавною анімацією
    setTimeout(() => {
        // Масив ID елементів алертів
        const alerts = ['alert-error', 'alert-success', 'alert-validation'];
        // Перебираємо кожен алерт
        alerts.forEach(id => {
            // Знаходимо елемент за ID
            const el = document.getElementById(id);
            // Якщо елемент існує
            if (el) {
                // Додаємо перехід для прозорості
                el.style.transition = 'opacity 0.5s ease-out';
                // Встановлюємо прозорість 0
                el.style.opacity = '0';
                // Видаляємо елемент після завершення анімації
                setTimeout(() => el.remove(), 500);
            }
        });
    }, 3000);

    // Функція для послідовної анімації хлібних крихт
    document.addEventListener('DOMContentLoaded', () => {
        // Знаходимо всі елементи хлібних крихт
        const breadcrumbItems = document.querySelectorAll('.breadcrumb-item');
        // Перебираємо кожен елемент
        breadcrumbItems.forEach(item => {
            // Отримуємо індекс із data-index
            const index = parseInt(item.getAttribute('data-index'));
            // Додаємо клас анімації з затримкою (0.2s * індекс)
            setTimeout(() => {
                item.classList.add('animate__fadeInRight');
            }, index * 200);
        });
    });
</script>
