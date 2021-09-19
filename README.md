# Kolgaev Users
## Расширение пользователей для Laravel

<p align="center">
    [![Release Version](https://img.shields.io/github/v/release/Dimanok1989/kolgaev-users?style=flat-square)](https://github.com/Dimanok1989/kolgaev-users/releases)
    [![Downloads GitHub](https://img.shields.io/github/downloads/Dimanok1989/kolgaev-users/total?style=flat-square)](https://github.com/Dimanok1989/kolgaev-users/archive/refs/heads/master.zip)
    [![Downloads Packagist](https://img.shields.io/packagist/dt/kolgaev/users?style=flat-square)](https://packagist.org/packages/kolgaev/users)
</p>

В данном пакете реализованы функции регистрации, авторизации и аутентификации пользователя, а также добавлены роли и разрешения пользователей

### Установка

Установите пакет: `composer require kolgaev/users`

### Настройка

Если Вам необходимо сменить наименования таблиц или переопределить модели разрешений и ролей, то выполните команду
`php artisan vendor:publish --provider="Kolgaev\Users\Provider\KolgaevUsersServiceProvider"`

Теперь в появившемся конфигурационной файле `/config/kolgaev_users.php` можно сменить наменования таблиц и столбцов

Если Вам необходимо добавить методы в модели Role и Permission, то определите собственные модели, которые будут наследовать соответсвующие модели пакета

    <?php
    use Kolgaev\Users\Model\Role as ParentRole;

    class Role extends ParentRole
    {
        // ...
    }

Не забудьте указать в конфигурационном файле пути до собственных моделей

### Модели и База данных

В модель пользователей необходимо добавить трейт `UsersRoleAndPermission`

    <?php

    namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
    use Kolgaev\Users\Models\UsersRoleAndPermission;

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable, UsersRoleAndPermission;
    }

Для создания таблиц в базе данных выполните команду `php artisan migrate`
Будут выполнены стандартные миграции пакета с учетом его конфигурации и созданы необходимые таблицы

### Маршрутизация

В провайдере пакета уже определены стандартные маршруты, которые доступны по адресу `http://example.com/api/*`
Если вам необходимо сменить префикс, это можно сделать в конфигруационном файле

Таблица маршрутов:

| Тип | Маршрут  | Описание  | Параметры  |
| -------------  | -------------  | -------------  | -------------  |
| `POST`  | `/api/registration`  | Регистрация пользователя  | `email` `password` `name`  |
| `POST`  | `/api/login`  | Авторизация пользователя  | `email` `password`  |
| `POST`  | `/api/logout`  | Выход пользователя  |   |
| `POST`  | `/api/userdata`  | Данные пользователя  |   | |

### Методы

Для выдачи разрешений и определения роли пользователю используйте следующие методы

    <?php

    /** @var int $id Идентификатор роли */
    $request->user()->addRole($id);
    $request->user()->removeRole($id);

    /** @var int $id Идентификатор разрешения */
    $request->user()->addPermission($id);
    $request->user()->removePermission($id);

Точно также для роли, можно выдать и отозвать разрешения

    <?php

    /** @var int $id Идентификатор роли */
    $role = \Kolgaev\Users\Models\Role::find($id);

    $role->addPermission($permission_id);
    $role->removePermission($permission_id);

### Контроллеры

Для выдачи ролей и разрешений реализованы соответствующие контроллеры
Методы вернут ответ в формате JSON

Все что необходимо сделать - это определить свои маршруты на соответсвующие методы

    <?php
    
    Route::post('user/addPermission', '\Kolgaev\Users\Users@addPermission');

Имеются следующие методы

    <?php

    use Illuminate\Http\Request;
    use Kolgaev\Users\Users;

    Users::addPermission(Request $request);
    Users::removePermission(Request $request);

Запросу необходимо передать следующие параметры
- `id` Идентификатор пользователя
- `permission_id` Идентификатор разрешения

Аналогично для роли

    <?php

    use Illuminate\Http\Request;
    use Kolgaev\Users\Roles;

    Roles::addUser(Request $request);
    Roles::removeUser(Request $request);

    Roles::addPermission(Request $request);
    Roles::removePermission(Request $request);

Методы addUser и removeUser принимают следующие параметры
- `id` Идентификатор пользователя
- `role_id` Идентификатор роли

Методы addPermission и removePermission:
- `id` Идентификатор роли
- `permission_id` Идентификатор разрешения
