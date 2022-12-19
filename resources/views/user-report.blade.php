@extends('layouts.layout')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Статистика</h1>
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
                                Мастера
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-8 col-lg-6">
                                    <form action="{{ route('user-report.index') }}" method="GET">
                                        <!-- Date range -->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input name="date-range" type="text" class="form-control float-right"
                                                    id="reservation">
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">Показать</button>
                                                </span>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-bordered  responsive yajra-datatable-user-report">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Мастер</th>
                                        <th>Открыто</th>
                                        <th>Выполнено</th>
                                        <th>Не выполнено и закрыто</th>
                                        <th>Доработка</th>
                                        <th>Запланировано</th>
                                    	<th>Выполнена и оплачена</th>
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
