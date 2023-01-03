@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12t">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Роли</a></li>
                        <li class="breadcrumb-item active">Новая роль</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            @if (session('success'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif
            <!-- Main row -->
            <div class="row justify-content-md-center">
                <section class="col-lg-8 col-sm-12 col-md-8 align-content-lg-center">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Новая роль</h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('roles.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="fio">Имя</label>
                                    <input type="text" value="{{ old('name') }}"
                                        class="form-control form-control-border border-width-2" id="name"
                                        name="name" placeholder="Имя" required>
                                </div>
                                @foreach($permissions as $permission)
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input id="customCheckbox{{ $permission->id }}"  class="custom-control-input" type="checkbox"  name="permissions[]" value="{{ $permission->id }}">
                                            <label for="customCheckbox{{ $permission->id }}" class="custom-control-label">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach


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
