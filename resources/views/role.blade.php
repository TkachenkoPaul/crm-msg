@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Роли</a></li>
                        <li class="breadcrumb-item active">{{ $role->name }}</li>
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
                            <h3 class="card-title">Настроить роль</h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('roles.update',$role->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="fio">Имя</label>
                                    <input type="text" value=" {{ $role->name }}"
                                        class="form-control form-control-border border-width-2" id="name"
                                        name="name" placeholder="Имя" required>
                                </div>
                                @foreach($permissions as $permission)
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input id="customCheckbox{{ $permission->id }}" @if($role->hasPermissionTo($permission->name))checked @endif  class="custom-control-input" type="checkbox"  name="permissions[]" value="{{ $permission->id }}">
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
                                <div class="row">
                                    <div class="col-12">
                                        <form  action="{{ route('roles.destroy',$role->id) }}" method="get">
                                            <button type="submit" class="btn btn-danger float-right"><i class="fa fa-times"></i> Удалить</button>
                                        </form>
                                        <button type="submit" class="btn btn-success float-right mr-2"><i class="fa fa-save"></i> Сохранить</button>
                                    </div>
                                </div>

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
