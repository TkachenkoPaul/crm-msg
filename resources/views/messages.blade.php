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
                @foreach ($data['status'] as $status)
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box elevation-3 hoverable">
                            <span class="info-box-icon {{ $status->color }}"><i class="fas {{ $status->icon }}"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">{{ $status->name }}</span>
                                <span class="info-box-number">{{ $status->messages_count }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endforeach
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-comments"></i>
                                Заявки
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('messages.create') }}" class="btn btn-primary">Добавить</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-8 col-lg-6">
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

                            <table class="table table-bordered  compact stripe table-hover yajra-datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th data-priority="3">ФИО</th>
                                        <th data-priority="1">Адрес</th>
                                        <th data-priority="2">Дом/Квартира</th>
                                        {{-- <th data-priority="5">UID</th>
                                        <th data-priority="3">Договор</th>
                                        <th data-priority="4">Фото</th> --}}
                                        {{-- <th>Примечание</th> --}}
                                        <th>Телефон</th>
                                        <th>Ответственный</th>
                                        <th>Статус</th>
                                        <th>Опции</th>
                                        <th>Закрыта</th>
                                        <th>Запланировано</th>
                                        {{-- <th>Создана</th>
                                        <th>Изменена</th> --}}
                                        {{-- <th></th> --}}
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
