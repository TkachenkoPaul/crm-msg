@extends('layouts.layout')
@section('content')
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            @if (session('message_created'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            {{ session('message_created') }}
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
                                Обращения
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover compact yajra-datatable-appeals">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th data-priority="3">ФИО</th>
                                    <th data-priority="1">Адрес</th>
                                    <th data-priority="2">№</th>
                                    <th>Телефон</th>
                                    <th>IP</th>
                                    <th>Согласие</th>
                                    <th>Создана</th>
                                    <th data-priority="4">В обработку</th>
                                    <th data-priority="5">Удалить</th>
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
