<?php

return [

    'accepted' => 'Поле :attribute повинно бути прийняте.',
    'active_url' => 'Поле :attribute має бути коректною URL-адресою.',
    'after' => 'Поле :attribute має бути датою після :date.',
    'after_or_equal' => 'Поле :attribute має бути датою не раніше :date.',
    'alpha' => 'Поле :attribute повинно містити лише літери.',
    'alpha_dash' => 'Поле :attribute може містити лише літери, цифри, дефіси та підкреслення.',
    'alpha_num' => 'Поле :attribute може містити лише літери та цифри.',
    'array' => 'Поле :attribute повинно бути масивом.',

    'before' => 'Поле :attribute має бути датою до :date.',
    'before_or_equal' => 'Поле :attribute має бути датою не пізніше :date.',
    'between' => [
        'numeric' => 'Поле :attribute повинно бути між :min та :max.',
        'file' => 'Поле :attribute повинно бути від :min до :max кілобайт.',
        'string' => 'Поле :attribute повинно містити від :min до :max символів.',
        'array' => 'Поле :attribute повинно містити від :min до :max елементів.',
    ],

    'boolean' => 'Поле :attribute повинно бути true або false.',
    'confirmed' => 'Підтвердження для поля :attribute не збігається.',
    'current_password' => 'Пароль неправильний.',
    'date' => 'Поле :attribute має бути коректною датою.',
    'date_equals' => 'Поле :attribute повинно бути датою, що дорівнює :date.',
    'date_format' => 'Поле :attribute не відповідає формату :format.',
    'different' => 'Поля :attribute та :other повинні відрізнятися.',
    'digits' => 'Поле :attribute повинно містити :digits цифр.',
    'digits_between' => 'Поле :attribute повинно містити від :min до :max цифр.',
    'email' => 'Поле :attribute повинно бути дійсною адресою електронної пошти.',
    'ends_with' => 'Поле :attribute повинно закінчуватись на одне з наступних: :values.',
    'exists' => 'Обране значення для :attribute є недійсним.',
    'file' => 'Поле :attribute повинно бути файлом.',
    'filled' => 'Поле :attribute обов’язкове для заповнення.',
    'gt' => [
        'numeric' => 'Поле :attribute має бути більше ніж :value.',
        'file' => 'Поле :attribute має бути більше ніж :value кілобайт.',
        'string' => 'Поле :attribute має бути більше ніж :value символів.',
        'array' => 'Поле :attribute повинно містити більше ніж :value елементів.',
    ],
    'gte' => [
        'numeric' => 'Поле :attribute повинно бути більше або дорівнювати :value.',
        'file' => 'Поле :attribute повинно бути не менше :value кілобайт.',
        'string' => 'Поле :attribute повинно бути не менше :value символів.',
        'array' => 'Поле :attribute повинно містити :value елементів або більше.',
    ],

    'image' => 'Поле :attribute повинно бути зображенням.',
    'in' => 'Обране значення для :attribute є недійсним.',
    'in_array' => 'Поле :attribute не існує в :other.',
    'integer' => 'Поле :attribute повинно бути цілим числом.',
    'ip' => 'Поле :attribute повинно бути дійсною IP-адресою.',
    'ipv4' => 'Поле :attribute повинно бути дійсною IPv4-адресою.',
    'ipv6' => 'Поле :attribute повинно бути дійсною IPv6-адресою.',
    'json' => 'Поле :attribute повинно бути правильним JSON рядком.',

    'max' => [
        'numeric' => 'Поле :attribute не повинно бути більше ніж :max.',
        'file' => 'Поле :attribute не повинно перевищувати :max кілобайт.',
        'string' => 'Поле :attribute не повинно перевищувати :max символів.',
        'array' => 'Поле :attribute не повинно містити більше ніж :max елементів.',
    ],
    'mimes' => 'Поле :attribute повинно бути файлом типу: :values.',
    'mimetypes' => 'Поле :attribute повинно бути файлом типу: :values.',

    'min' => [
        'numeric' => 'Поле :attribute повинно бути не менше :min.',
        'file' => 'Поле :attribute повинно бути не менше :min кілобайт.',
        'string' => 'Поле :attribute повинно містити не менше :min символів.',
        'array' => 'Поле :attribute повинно містити не менше :min елементів.',
    ],

    'not_in' => 'Обране значення для :attribute є недійсним.',
    'numeric' => 'Поле :attribute повинно бути числом.',
    'password' => 'Невірний пароль.',
    'present' => 'Поле :attribute повинно бути присутнім.',
    'regex' => 'Формат поля :attribute є недійсним.',
    'required' => 'Поле :attribute є обов’язковим.',
    'required_if' => 'Поле :attribute є обов’язковим, коли :other дорівнює :value.',
    'required_unless' => 'Поле :attribute є обов’язковим, якщо :other не входить до :values.',
    'required_with' => 'Поле :attribute є обов’язковим, коли присутнє :values.',
    'required_with_all' => 'Поле :attribute є обов’язковим, коли присутні :values.',
    'required_without' => 'Поле :attribute є обов’язковим, коли відсутнє :values.',
    'required_without_all' => 'Поле :attribute є обов’язковим, коли жодне з :values не присутнє.',
    'same' => 'Поля :attribute і :other повинні збігатися.',

    'size' => [
        'numeric' => 'Поле :attribute повинно бути :size.',
        'file' => 'Поле :attribute повинно бути розміром :size кілобайт.',
        'string' => 'Поле :attribute повинно містити :size символів.',
        'array' => 'Поле :attribute повинно містити :size елементів.',
    ],

    'string' => 'Поле :attribute повинно бути рядком.',
    'timezone' => 'Поле :attribute повинно бути коректною часовою зоною.',
    'unique' => 'Таке значення поля :attribute вже існує.',
    'uploaded' => 'Не вдалося завантажити файл :attribute.',
    'url' => 'Поле :attribute має некоректний формат URL.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'password' => [
            'confirmed' => 'Підтвердження паролю не збігається.',
        ],
        'title' => [
            'required' => 'Поле назви товару є обов’язковим.',
            'string' => 'Назва товару повинна бути текстом.',
            'max' => 'Назва товару не може перевищувати 255 символів.',
        ],
        'price' => [
            'numeric' => 'Вартість має бути числом.',
            'min' => 'Вартість не може бути меншою за 0.',
        ],
        'discount' => [
            'numeric' => 'Знижка має бути числом.',
            'min' => 'Знижка не може бути меншою за 0.',
        ],
        'stock_balance' => [
            'numeric' => 'Залишок на складі має бути числом.',
            'min' => 'Залишок не може бути меншим за 0.',
        ],
        'user_id' => [
            'required' => 'Користувач обов’язковий.',
            'exists' => 'Обраний користувач не знайдений.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'name' => 'імʼя',
        'email' => 'електронна адреса',
        'password' => 'пароль',
        'password_confirmation' => 'підтвердження паролю',
        'title' => 'назва товару',
        'sub_kind_product_id' => 'підвид товару',
        'content' => 'коментар до товару',
        'brand_id' => 'бренд',
        'links_networks' => 'посилання на товар',
        'price' => 'Вартість',
        'discount' => 'знижка',
        'stock_balance' => 'залишок на складі',
        'color_id' => 'колір',
        'term_creation' => 'строк виготовлення',
        'status_product_id' => 'статус товару',
        'user_id' => 'користувач',
        'new' => 'новий товар',
        'featured' => 'рекомендований товар',
        'active' => 'активність',
        'date_put_up_for_sale' => 'дата виставлення на продаж',
        'date_approve_sale' => 'дата початку продажу',
        'admin_id' => 'адміністратор',
        'additional_information' => 'додаткова інформація',
//    'attributes' => [
//        'content' => 'Опис',
//        'price' => 'Вартість',
//        'color_id' => 'Колір',
//        'name' => 'Ім\'я',
//        'title' => 'Назва',
//        'surname' => 'Прізвище',
//        'phone' => 'Телефон',
//        'email' => 'Email',
//        'region' => 'Область',
//        'city' => 'Населений пункт',
//        'street' => 'Вулиця',
//        'home' => '№ Будинку',
//        'title_kind_product' => 'Назва виду товару',
//        'title_sub_kind_product' => 'Назва підвиду товару',
    ],

];
