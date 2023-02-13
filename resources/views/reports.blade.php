@extends('layouts.layout')
@section('content')
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            @if (session('response'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            {{ session('response') }}
                        </div>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-comments"></i>
                                Отчеты
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover compact yajra-datatable-reports">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th data-priority="3">Создал</th>
                                    <th data-priority="1">Имя</th>
                                    <th data-priority="2">Описание</th>
                                    <th>Кол-во заявок</th>
                                    <th>Файл</th>
                                    <th>Размер</th>
                                    <th>Прогресс</th>
                                    <th>Создан</th>
                                    <th>-</th>
                                    <th>-</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div>
                </section>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop
