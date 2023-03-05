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
                                <a href="{{ request()->fullUrlWithQuery(['status_id'=> $status->type_id]) }}"
                                   class="small-box-footer">
                                    Подробно <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endcan
            </div>
            <!-- /.row -->

            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Загрузить excel файл </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('messages.import.excel') }}" method="POST"
                                  enctype="multipart/form-data" id="import-file">
                                @csrf
                                <div class="form-group">
                                    <label for="image">Excel</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input name="file" type="file" class="custom-file-input" id="file">
                                            <label class="custom-file-label" for="file">Выбрать файл</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            <button type="submit" form="import-file" class="btn btn-primary">Импортировать</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            @can('view reports pdf')
                <div class="modal fade" id="modal-queue">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Сформировать отчет </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="queue-form" action="{{ route('reports.store') }}"
                                      method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="queue-name" class="text-muted">Название отчета:</label>
                                        <div class="input-group">
                                            <input id="queue-name" type="text" name="name"
                                                   class="form-control form-control-border border-width-2"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="queue-desc" class="text-muted">Описание отчета:</label>
                                        <div class="input-group">
                                            <input id="queue-desc" type="text" name="desc"
                                                   class="form-control form-control-border border-width-2"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    @if(isset($_GET['updated_at']))
                                        <input type="hidden" name="updated_at"
                                               value="{{ $_GET['updated_at'] }}">
                                    @endif
                                    @if(isset($_GET['date-range']))
                                        <input type="hidden" name="date-range"
                                               value="{{ $_GET['date-range'] }}">
                                    @endif
                                    @if(isset($_GET['status_id']))
                                        <input type="hidden" name="status_id"
                                               value="{{ $_GET['status_id'] }}">
                                    @endif
                                    @if(isset($_GET['responsible_id']))
                                        <input type="hidden" name="responsible_id"
                                               value="{{ $_GET['responsible_id'] }}">
                                    @endif
                                </form>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                <button type="submit" form="queue-form" class="btn btn-primary">Сформировать</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endcan


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
                                    @can('view reports pdf')
                                        <li class="nav-item mr-2 mt-2">
                                            <button type="button" class="btn bg-gradient-primary float-right"
                                                    data-toggle="modal" data-target="#modal-queue"><i
                                                    class="far fa-file-archive"></i> Отчет
                                            </button>
                                        </li>
                                    @endcan
                                    @can('view reports excel')
                                        <li class="nav-item mr-2 mt-2">
                                            <form action="{{ route('messages.show.all.excel') }}"
                                                  method="GET">
                                                @if(isset($_GET['updated_at']))
                                                    <input type="hidden" name="updated_at"
                                                           value="{{ $_GET['updated_at'] }}">
                                                @endif
                                                @if(isset($_GET['date-range']))
                                                    <input type="hidden" name="date-range"
                                                           value="{{ $_GET['date-range'] }}">
                                                @endif
                                                @if(isset($_GET['status_id']))
                                                    <input type="hidden" name="status_id"
                                                           value="{{ $_GET['status_id'] }}">
                                                @endif
                                                @if(isset($_GET['responsible_id']))
                                                    <input type="hidden" name="responsible_id"
                                                           value="{{ $_GET['responsible_id'] }}">
                                                @endif
                                                <button type="submit"
                                                        class="btn  bg-gradient-primary elevation-2"><i
                                                        class="far fa-file-excel"></i> Excel
                                                </button>
                                            </form>
                                        </li>
                                    @endcan
                                    @can('view reports pdf')
                                        <li class="nav-item mr-2 mt-2">
                                            <form action="{{ route('messages.show.all.pdf') }}"
                                                  method="GET">
                                                @if(isset($_GET['updated_at']))
                                                    <input type="hidden" name="updated_at"
                                                           value="{{ $_GET['updated_at'] }}">
                                                @endif
                                                @if(isset($_GET['date-range']))
                                                    <input type="hidden" name="date-range"
                                                           value="{{ $_GET['date-range'] }}">
                                                @endif
                                                @if(isset($_GET['status_id']))
                                                    <input type="hidden" name="status_id"
                                                           value="{{ $_GET['status_id'] }}">
                                                @endif
                                                @if(isset($_GET['responsible_id']))
                                                    <input type="hidden" name="responsible_id"
                                                           value="{{ $_GET['responsible_id'] }}">
                                                @endif
                                                <button type="submit"
                                                        class="btn bg-gradient-primary elevation-2"><i
                                                        class="far fa-file-pdf"></i> Pdf
                                                </button>
                                            </form>
                                        </li>
                                    @endcan
                                    @can('create messages')
                                        <li class="nav-item mr-2 mt-2">
                                            <button type="button" class="btn bg-gradient-primary float-right"
                                                    data-toggle="modal" data-target="#modal-default"><i
                                                    class="far fa-file-excel"></i> Импорт
                                            </button>
                                        </li>
                                        <li class="nav-item mr-2 mt-2">
                                            <a href="{{ route('messages.create') }}"
                                               class="btn bg-gradient-primary">Добавить</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-2 col-sm-12 col-md-12 col-lg-12 ">
                                    <form class="form-inline" action="{{ route('messages.index') }}" method="GET">
                                        <!-- Date range -->
                                        <div class="form-group mb-2 mr-2">
                                            <label for="reservation">Дата закрытия: </label>
                                            <div class="input-group">
                                                <input name="date-range" type="text"
                                                       class="form-control form-control-border border-width-2"
                                                       id="reservation">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group mb-2 mr-2">
                                            <label for="reservation2">Дата изменения: </label>
                                            <div class="input-group" id="reservation2"
                                                 data-target-input="nearest">
                                                <div class="input-group" data-target="#reservation2"
                                                     data-toggle="datetimepicker">
                                                    <input id="plan" type="text"
                                                           class="form-control form-control-border border-width-2"
                                                           data-target="#reservation2" name="updated_at"/>
                                                </div>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group mb-2 mr-2">
                                            <label for="status_id">Статус: </label>
                                            <select class="custom-select form-control-border border-width-2"
                                                    id="status_id"
                                                    required
                                                    name="status_id">
                                                <option value="all">Все</option>
                                                @if (isset($data['statuses']))
                                                    @foreach ($data['statuses'] as $status)
                                                        <option
                                                            value="{{ $status->type_id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group mb-2 mr-2">
                                            <label for="responsible_id">Ответственный: </label>
                                            <select class="custom-select form-control-border border-width-2"
                                                    id="responsible_id"
                                                    required name="responsible_id">
                                                <option value="all">Все</option>
                                                @if (isset($data['users']))
                                                    @foreach ($data['users'] as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group mb-2 mr-2">
                                            <button type="submit" class="btn bg-gradient-primary float-right mt-1">
                                                Показать
                                            </button>
                                        </div>
                                    </form>
                                    <form class="form-inline" action="{{ route('messages.update.group') }}"
                                          method="GET">
                                        @if(isset($_GET['updated_at']))
                                            <input type="hidden" name="updated_at" value="{{ $_GET['updated_at'] }}">
                                        @endif
                                        @if(isset($_GET['date-range']))
                                            <input type="hidden" name="date-range" value="{{ $_GET['date-range'] }}">
                                        @endif
                                        @if(isset($_GET['status_id']))
                                            <input type="hidden" name="status_id" value="{{ $_GET['status_id'] }}">
                                        @endif
                                        @if(isset($_GET['responsible_id']))
                                            <input type="hidden" name="responsible_id"
                                                   value="{{ $_GET['responsible_id'] }}">
                                        @endif
                                        <div class="form-group mb-2 mr-2">
                                            <label for="update_status_id">Изменить статус на: </label>
                                            <select class="custom-select form-control-border border-width-2"
                                                    id="update_status_id"
                                                    required
                                                    name="update_status_id">
                                                @if (isset($data['statuses']))
                                                    @foreach ($data['statuses'] as $status)
                                                        <option
                                                            value="{{ $status->type_id }}">{{ $status->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group mb-2 mr-2">
                                            <button type="submit" class="btn bg-gradient-info float-right mt-1">
                                                Изменить
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
                                    <th><small>Изменена</small></th>
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
