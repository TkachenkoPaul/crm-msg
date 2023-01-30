@extends('layouts.layout')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Операции обновления</h1>
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
                                Заявки
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <form class="inline-flex" action="{{ route('operations.index') }}" method="GET">
                                        <!-- Date range -->
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input name="date-range" type="text"
                                                       class="form-control form-control-border border-width-2"
                                                       id="reservation">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group">
                                            <label for="status_id">Статус</label>
                                            <select class="custom-select form-control-border border-width-2"
                                                    id="status_id"
                                                    required
                                                    name="status_id">
                                                @if (isset($data['status']))
                                                    @foreach ($data['status'] as $status)
                                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="responsible_id">Ответственный</label>
                                            <select class="custom-select form-control-border border-width-2"
                                                    id="responsible_id"
                                                    required name="responsible_id">
                                                @if (isset($data['users']))
                                                    @foreach ($data['users'] as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success float-right mt-1"><i
                                                    class="fas fa-envelope"></i> Сформировать
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover compact yajra-datatable" id="datatables-1">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th data-priority="3">ФИО</th>
                                    <th data-priority="1">Адрес</th>
                                    <th data-priority="2">№</th>
                                    <th>Телефон</th>
                                    <th>Исполнитель</th>
                                    <th>Статус</th>
                                    <th data-priority="4"></th>
                                    <th data-priority="4"></th>
                                    <th data-priority="4"></th>
                                    <th data-priority="5"></th>
                                    <th><small>Закрыта</small></th>
                                    <th><small>Запланировано</small></th>
                                    <th><small>uid</small></th>
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
