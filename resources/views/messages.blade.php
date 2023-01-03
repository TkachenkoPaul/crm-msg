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
            <div class="row">
                @can('view statistic')
                    @foreach ($data['status'] as $status)
                        <div class="col-md-3 col-sm-6 col-12">
                            <!-- small card -->
                            <div class="small-box {{ $status->color }}">
                                <div class="inner">
                                    <h3>{{ $status->messages_count }}</h3>

                                    <p>{{ $status->name }}</p>
                                </div>
                                <div class="icon">
                                    <i class="fas {{ $status->icon }}"></i>
                                </div>
                                <a href="{{ request()->fullUrlWithQuery(['status_id'=> $status->type_id]) }}" class="small-box-footer">
                                    Подробно <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endcan
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-comments"></i>
                                Заявки {{ isset($data['header'])? $data['header'] : ''}}
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    @can('view pdf')
                                        @if($data['status'][0]->type_id == 6)
                                            @if($data['status'][0]->messages_count >= 1)
                                                <li class="nav-item mr-2">
                                                    <a href="{{ route('messages.show.all.excel') }}" class="btn btn-success"> <i class="far fa-file-excel"></i> Excel</a>
                                                </li>
                                                <li class="nav-item mr-2">
                                                    <a href="{{ route('messages.show.all.pdf') }}" class="btn btn-info"> <i class="far fa-file-pdf"></i> Pdf</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endcan
                                   @can('create messages')
                                        <li class="nav-item">
                                            <a href="{{ route('messages.create') }}" class="btn btn-primary">Добавить</a>
                                        </li>
                                   @endcan
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <form action="{{ route('messages.index') }}" method="GET">
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
                                        <th  data-priority="4"></th>
                                        <th  data-priority="4"></th>
                                        <th  data-priority="4"></th>
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
