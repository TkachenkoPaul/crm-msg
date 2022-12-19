@extends('layouts.layout')
@section('content')
    <div class="content-header">
        {{--        <div class="container-fluid"> --}}
        {{--            <div class="row mb-2"> --}}
        {{--                <div class="col-sm-6"> --}}
        {{--                    <h1 class="m-0">Создать заявку</h1> --}}
        {{--                </div><!-- /.col --> --}}
        {{--            </div><!-- /.row --> --}}
        {{--        </div><!-- /.container-fluid --> --}}
    </div>
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
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="house">Дом/квартира</label>
                                            <input type="text" value="{{ old('house') }}"
                                                class="form-control form-control-border border-width-2" id="house"
                                                name="house" placeholder="Дом/квартира" required>
                                        </div>
                                    </div>
                                    <div class="col-8">
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
                                    <select class="custom-select form-control-border border-width-2" id="type_id" required
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
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Добавить</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@stop
