@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('messages.index') }}">Заявки</a></li>
                        <li class="breadcrumb-item active">Новая заявка</li>
                    </ol>
                </div>
            </div>
            @if (session('message_created'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            {{ session('message_created') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Main content -->
    <section class="content mt-3">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row justify-content-md-center">
                <section class="col-lg-8 col-sm-12 col-md-8 align-content-lg-center">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Новая заявка</h3>
                        </div>
                        <!-- /.card-header -->
                        <form method="POST" action="{{ route('messages.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="fio">ФИО заказчика</label>
                                    <input type="text" value="{{ old('fio') }}"
                                           class="form-control form-control-border border-width-2" id="fio"
                                           name="fio" placeholder="ФИО" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Адрес установки</label>
                                    <input type="text" value="{{ old('address') }}"
                                           class="form-control form-control-border border-width-2" id="address"
                                           name="address" placeholder="Адресс" required>
                                </div>
                                <div class="form-group">
                                    <label for="uid">ID оборудования</label>
                                    <input type="text" value="{{ old('uid') }}"
                                           class="form-control form-control-border border-width-2" id="uid"
                                           name="uid" placeholder="ID">
                                </div>

                                <div class="row justify-content-md-center">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="house">Дом/квартира</label>
                                            <input type="text" value="{{ old('house') }}"
                                                   class="form-control form-control-border border-width-2" id="house"
                                                   name="house" placeholder="Дом/квартира" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <div class="form-group">
                                            <label for="phone">Контактный номер</label>
                                            <input type="text" value="{{ old('phone') }}"
                                                   class="form-control form-control-border border-width-2" id="phone"
                                                   name="phone" placeholder="Номер телефона" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="type_id">Примечание (тип)</label>
                                    <select class="custom-select form-control-border border-width-2" id="type_id"
                                            required
                                            name="type_id">
                                        @if (isset($data['types']))
                                            @foreach ($data['types'] as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="responsible_id">Ответственный</label>
                                    <select class="custom-select form-control-border border-width-2" id="responsible_id"
                                            required name="responsible_id">
                                        @if (isset($data['users']))
                                            @foreach ($data['users'] as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

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
                            <div class="card-footer justify-content-center">
                                <button type="submit" class="btn btn-success float-right mt-1"><i
                                        class="fas fa-plus"></i> Добавить
                                </button>
                                <button type="button" class="btn btn-info float-right mr-2 mt-1" data-toggle="modal"
                                        data-target="#modal-default"><i class="far fa-file-excel"></i> Импорт
                                </button>
                            </div>
                        </form>
                    </div>

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
                                    <button type="submit" form="import-file" class="btn btn-primary">Импортировать
                                    </button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                </section>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop
