@extends('layouts.layout')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            @if (session('user_created'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            {{ session('user_created') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Пользователи</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-comments"></i>
                                Список
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('users.create') }}" class="btn btn-primary">Добавить</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover  responsive yajra-datatable-users">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Имя</th>
                                        <th>Добавил</th>
                                        <th>Добавлен</th>
                                        <th>Изменен</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.card-body -->
            </div>
    </section>
    </div>
    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop
