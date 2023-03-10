@extends('layouts.layout')
@section('content')
    <div class="content-header">
    </div>
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row justify-content-md-center">
                <section class="col-lg-8 col-sm-12 col-md-8 align-content-lg-center">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Новый пользователь</h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Имя</label>
                                    <input type="text" value="{{ old('name') }}"
                                        class="form-control form-control-border border-width-2" id="name"
                                        name="name" placeholder="Имя" required>
                                </div>
                                <div class="form-group">
                                    <label for="login">Логин</label>
                                    <input type="text" value="{{ old('login') }}"
                                        class="form-control form-control-border border-width-2" id="login"
                                        name="login" placeholder="Логин" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Роль</label>
                                    <select class="custom-select form-control-border" id="role" name="role">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="text" value="{{ old('password') }}"
                                        class="form-control form-control-border border-width-2" id="password"
                                        name="password" placeholder="Пароль" required>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Добавить</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop
