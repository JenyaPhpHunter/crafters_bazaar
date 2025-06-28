<?php

namespace App\Constants;

class UserAndLogMessages
{
    const FILE_SIZE_LIMIT_EXCEEDED = 'Занадто великий обсяг файлів';
    const FILE_PROCESSING_START = 'Початок обробки файлів...';
    const FILE_PROCESSING_PROCESS = 'Обробка файлу';
    const FILE_PROCESSING_SUCCESS = 'Файл оброблено успішно';
    const FILE_PROCESSING_FINISH = 'Обрабку файлів завершено.';
    const FILE_PROCESSING_ERROR = 'Помилка при обробці файлу';
    const FILE_PROCESSING_ERROR_MESSAGE = 'Повідомлення про помилку ';
    const FILE_PROCESSING_ERROR_DIRECTORY_NOT_EXISTS = 'Директория з файлами для імпорту не існує.';
    const FILE_PROCESSING_ERROR_DIRECTORY_IS_EMPTY = 'Директорія порожня.';
    const FILE_PROCESSING_ERROR_FILE_NOT_EXISTS = 'Файл не існує.';

    const DB_TRANSACTION_START = 'Початок транзакції...';
    const DB_TRANSACTION_SUCCESS = 'Транзакцію успішно завершено.';
    const DB_TRANSACTION_ROLLBACK = 'Транзакцію повернуто. | ROLLBACK TRANSACTION AFTER ERROR';
    const DB_RECORD_ADD_SUCCESS = 'Запис успішно створено. ';
    const DB_RECORD_ADD_SKIPPED = 'Запис пропущено.';
    const DB_RECORD_UPDATE_SUCCESS = 'Запис успішно оновлено.';
    const DB_RECORD_MARK_DELETE_SUCCESS = 'Запис помічено на видалення.';
    const DB_RECORD_DROP_SUCCESS = 'Запис знищено.';
    const DB_RECORD_RESTORE_SUCCESS = 'Запис відновлено.';
    const DB_RECORD_NOT_FOUND = 'Запис не знайдено. ';
    const DB_RECORD_FOUND_COUNT = 'Знайдено записів: ';
    const DB_RECORD_ALREADY_EXISTS = 'Запис вже існує.';
    const DB_RECORD_NOT_DELETED = 'Запис не видалено.';
    const DB_RECORD_NOT_RESTORED = 'Запис не відновлено.';
    const DB_ERROR = 'Помилка при роботі з базою даних. | SQL DB ERROR ';
    const DB_ERROR_NO_TABLE = 'Модель або таблиця Не існує або не вказані | SQL DB ERROR ';

    const NEW_DATA_RECEIVED_FROM = 'Нові дані отримані з ';
    const PROCESSING = 'Обробка... ';
    const ERROR_NO_ENOUGH_DATA = 'Недостатньо даних для обробки. ';
    const ERROR_NO_DATA = 'Дані відсутні.';
    const ERROR_INCORRECT_DATA = 'Incorrect data recieved.';
    const ERROR_CAN_NOT_RECIEVE_EXTERNAL_SERVICE_DATA = 'Не вдалося отримати дані зовнішнього сервісу';

    const ERROR_REQUIRED_FIELD = 'Поле обов\'язкове для заповнення';
    const ERROR_NUMERIC_FIELD = 'Поле повинно бути числом';
    const ERROR_INTEGER_FIELD = 'Поле повинно бути цілим числом';
    const ERROR_STRING_FIELD = 'Поле повинно бути строкою';
    const ERROR_DATE_FIELD = 'Поле повинно бути датою';
    const ERROR_BOOLEAN_FIELD = 'Поле повинно бути булевим значенням';
    const ERROR_GTE_FIELD = 'Поле з кінцевим значенням має бути більшим або рівним полю з початковим значенням';
    const ERROR_EXISTS_FIELD = 'Поле повинно існувати в таблиці';
    const ERROR_MAX_NUMBER_FIELD = 'Поле не повинно перевищувати дозволене максимальне значення';
    const ERROR_MAX_STRING_FIELD = 'Поле не повинно перевищувати дозволену максимальну кількість символів';
    const ERROR_AFTER_OR_EQUAL_FIELD = 'Поле яке є датою закінчення не повинно бути раніше ніж дата початку';

    const ERROR_SESSION_EXPIRED = 'Час вашої сесії закінчився. Будь ласка, увійдіть знову.';
    const ERROR_NOT_AUTH_USER_CREATE_TRY = 'Ви не можете створити запис від імені іншого користувача';

    const ERROR_401 = 'Anauthorized. 401';
    const ERROR_ACTION_NOT_PERMITTED = 'У вас недостатньо прав для цієї операції. 403';
    const ERROR_404 = 'Endpoint not difined. 404';
    const ERROR_405 = 'Method not allowed. 405';
    const ERROR_403 = 'Ця дія заблокована';
    const ERROR_BETWEEN_FIELD = 'Значення повинно бути в діапазоні від мінімального до максимального дозволеного.';

    const RESPONSE_STATUS_ERROR = 'error';
    const RESPONSE_STATUS_SUCCESS = 'success';
    const RESPONSE_STATUS_WARNING = 'warning';
    const RESPONSE_STATUS_INFO = 'info';
    const RESPONSE_STATUS_AWAIT = 'await';
    const ERROR_INVALID_ACTION_TYPE = 'Невірний тип дії. Можливі значення: add, update, delete.';
    const ERROR_ADMIN_NOT_FOUND = 'Вказаний користувач не знайдений.';
}
