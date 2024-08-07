  @extends('admin.layouts.app')

  @section('content')
      @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif
      @if (session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif
      <div style="text-align: right;">
          <a class="btn btn-primary2 mr-3" href="{{ route('admin_users.create') }}"><i class="fal fa-user-plus"></i>&nbsp;Створити користувача</a>
      </div>
      <br>
      <!-- Пошукове вікно -->
      {{--          <form action="{{ route('searchusers') }}" method="GET">--}}
      {{--              <input type="text" name="query" placeholder="Пошук користувача за прізвищем та email">--}}
      {{--              <button type="submit">Знайти</button>--}}
      {{--          </form>--}}
          <div class="p-6 text-gray-900">
              <table class="table table-bordered">
                  <thead>
                  <tr>
                      <th>Id</th>
                      <th>Прізвище</th>
                      <th>Ім'я</th>
                      <th>По батькові</th>
                      <th>Email</th>
                      <th>Телефон</th>
                      <th>Роль</th>
                      <th>Категорія</th>
                      <th>Створено користувача</th>
                      <th>Оновлено користувача</th>
                      <th>Керування</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $user)
                      <tr>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->id }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->surname }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->name }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->secondname }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->email }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->phone }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->role->name }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->category_user->name }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->created_at }}</a></td>
                          <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->updated_at }}</a></td>
                          <td>
                              <!-- Іконка для редагування -->
                              <a href="{{ route('admin_users.edit', ['admin_user' => $user->id]) }}" title="Редагувати користувача">
                                  <i class="fas fa-pencil-alt"></i>
                              </a>

                              <!-- Додаємо відступ між іконками -->
                              <span style="display: inline-block; width: 30px;"></span>

                              <!-- Іконка для видалення -->
                              <form action="{{ route('admin_users.destroy', ['admin_user' => $user->id]) }}" method="POST" style="display:inline;">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" style="border:none; background:none; padding:0; margin:0; color:red;" title="Видалити користувача" onclick="return confirm('Ви впевнені, що хочете видалити цього користувача?');">
                                      <i class="fas fa-trash-alt"></i>
                                  </button>
                              </form>
                          </td>

                      </tr>
                  @endforeach
                  </tbody>
              </table>
          </div>
  @endsection

