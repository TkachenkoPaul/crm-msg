@extends('layouts.layout')
@section('content')
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
                                Типы заявок
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered yajra-datatable-type">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Имя</th>
                                    <th>Админ</th>
                                    <th>Добавил</th>
                                    <th>Изменил</th>
                                    <th></th>
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
