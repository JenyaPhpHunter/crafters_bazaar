  @extends('admin.layouts.app')

  @section('content')
      <!-- Фільтри -->
      <form action="{{ route('admin_users.index') }}" method="GET">
          <div class="row mb-3">
              <div class="col-md-2">
                  <input type="text" name="pib" class="form-control" placeholder="ПІБ" value="{{ $filters['pib'] ?? '' }}">
              </div>
              <div class="col-md-2">
                  <input type="email" name="email" class="form-control" placeholder="Email" value="{{  $filters['email'] ?? '' }}">
              </div>
              <div class="col-md-2">
                  <input type="text" name="phone" class="form-control" placeholder="Телефон" value="{{ $filters['phone'] ?? '' }}">
              </div>
              <div class="col-md-2">
                  <select name="role_id[]" class="form-control select2-basic" multiple>
                      @foreach($roles as $role)
                          <option value="{{ $role->id }}" {{ in_array($role->id, $filters['role_id'] ?? []) ? 'selected' : '' }}>
                              {{ $role->title }}
                          </option>
                      @endforeach
                  </select>
              </div>

              <div class="col-md-2">
                  <select name="category_user_id[]" class="form-control select2-basic" multiple>
                      @foreach($categories as $category)
                          <option value="{{ $category->id }}" {{ in_array($category->id, $filters['category_user_id'] ?? []) ? 'selected' : '' }}>
                              {{ $category->title }}
                          </option>
                      @endforeach
                  </select>
              </div>
              <div class="col-md-2">
                  <button type="submit" class="btn btn-primary">Фільтрувати</button>
                  <a href="{{ route('admin_users.index') }}" class="btn btn-secondary">Скинути</a>
              </div>
          </div>
      </form>

      <div class="p-6 text-gray-900">
          <table class="table table-bordered">
              <thead>
              <tr>
                  <th>Id</th>
                  <th>ПІБ</th>
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
                      <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->surname }} {{ $user->name }} {{ $user->secondname }}</a></td>
                      <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->email }}</a></td>
                      <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->phone }}</a></td>
                      <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->role->title }}</a></td>
                      <td><a href="{{ route('admin_users.details', ['admin_user' => $user->id]) }}">{{ $user->category_user->title }}</a></td>
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

