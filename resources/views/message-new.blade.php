@extends('layouts.layout')
@section('content')
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('messages.index') }}">Заявки</a></li>
                        <li class="breadcrumb-item active">Заявка № {{ $message->id }}</li>
                    </ol>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $message->address }}</h1>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @if (session('message'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success">
                        {{ session('message') }}
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
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Информация</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-3">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Создана</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{ $message->created_at }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Запланирована</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{ $message->plan ? $message->plan : 'Не запланирована' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Закрыта</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{ $message->closed }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Изменена</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{ $message->updated_at }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Комментарии</h4>
                                @if ($replies)
                                    @foreach ($replies as $reply)
                                        <div class="post clearfix">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm"
                                                     src="{{ asset('dist/img/user-icon.png') }}"
                                                     alt="user image">
                                                <span class="username">{{ $reply->admin->name }} <a
                                                        href="{{ route('reply.destroy',$reply->id) }}"
                                                        class="text-muted ml-2 float-right hover:text-red-800"><i
                                                            class="fas fa-times"></i></a></span>
                                                <span class="description">{{ $reply->created_at }}</span>
                                                <div></div>
                                            </div>
                                            <!-- /.user-block -->
                                            <p>
                                                {{ $reply->text }}
                                            </p>
                                            {{--                                            @if(isset($reply->attachment))--}}
                                            {{--                                                <p>--}}
                                            {{--                                                    @foreach ($reply->attachment as $file)--}}
                                            {{--                                                        <a href="{{ Storage::url($file->path) }}"--}}
                                            {{--                                                           data-toggle="lightbox"--}}
                                            {{--                                                           data-gallery="example-gallery{{ $reply->id }}"  class="link-black text-sm"><i class="fas fa-link mr-1"></i>{{ $file->name }}</a>--}}
                                            {{--                                                    @endforeach--}}
                                            {{--                                                </p>--}}
                                            {{--                                            @endif--}}
                                            @if(isset($reply->attachment))
                                                <div class="row">
                                                    @foreach ($reply->attachment as $file)
                                                        <div class="col-sm-4 col-md-3 col-lg-2">
                                                            <a href="{{ Storage::url($file->path) }}"
                                                               data-toggle="lightbox"
                                                               data-gallery="example-gallery{{ $reply->id }}"
                                                               class="col-sm-4">
                                                                <img src="{{ Storage::url($file->path) }}"
                                                                     class="img-thumbnail rounded  img-fluid">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                                <form method="POST" action="{{ route('reply.store', $message->id) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="reply">Комментарий</label>
                                        <textarea name="reply" id="reply" class="form-control" rows="4"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Файлы</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="images[]" multiple type="file" class="custom-file-input"
                                                       id="image">
                                                <label class="custom-file-label" for="image">Выбрать файлы</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"
                                                class="btn btn-primary float-right">Отправить
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Контакты</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="edit-message" method="POST"
                              action="{{ route('messages.update', $message->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="fio" class="text-muted">ФИО заказчика</label>
                                    <input type="text" value="{{ $message->fio }}"
                                           class="form-control form-control-border border-width-2" id="fio"
                                           name="fio" placeholder="ФИО" required>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="text-muted">Адрес установки</label>
                                    <input type="text" value="{{ $message->address }}"
                                           class="form-control form-control-border border-width-2" id="address"
                                           name="address" placeholder="Адресс" required>
                                </div>
                                <div class="form-group">
                                    <label for="uid" class="text-muted">ID оборудования</label>
                                    <input type="text" value="{{ $message->uid }}"
                                           class="form-control form-control-border border-width-2" id="uid"
                                           name="uid" placeholder="ID">
                                </div>
                                <div class="form-group">
                                    <label for="house" class="text-muted">Дом/квартира</label>
                                    <input type="text" value="{{ $message->house }}"
                                           class="form-control form-control-border border-width-2" id="house"
                                           name="house" placeholder="Дом/квартира" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="text-muted">Контактный номер</label>
                                    <input type="text" value="{{ $message->phone }}"
                                           class="form-control form-control-border border-width-2" id="phone"
                                           name="phone" placeholder="Номер телефона" required>
                                </div>
                                <div class="form-group">
                                    <label for="type_id" class="text-muted">Примечание (тип)</label>
                                    <select class="custom-select form-control-border border-width-2"
                                            id="type_id" required name="type_id">
                                        @if (isset($data['types']))
                                            @foreach ($data['types'] as $type)
                                                <option {{ $message->type_id === $type->id ? 'selected' : '' }}
                                                        value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="admin_id" class="text-muted">Добавил</label>
                                    @if (isset($data['users']))
                                        @if(!isset($message->admin_id))
                                            <input class="form-control form-control-border border-width-2" id="admin_id"
                                                   value="Не указан">
                                        @endif
                                        @foreach ($data['users'] as $user)
                                            @if($message->admin_id === $user->id)
                                                <input class="form-control form-control-border border-width-2"
                                                       id="admin_id" value="{{ $user->name }}">
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="responsible_id" class="text-muted">Исполнитель</label>
                                    <select class="custom-select form-control-border border-width-2"
                                            id="responsible_id" required name="responsible_id">
                                        @if (isset($data['users']))
                                            @if(!isset($message->responsible_id))
                                                <option value="" disabled selected>Не указан</option>
                                            @endif
                                            @foreach ($data['users'] as $user)
                                                <option
                                                    {{ $message->responsible_id === $user->id ? 'selected' : '' }}
                                                    value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="text-muted">Статус</label>
                                    <select class="custom-select form-control-border border-width-2"
                                            id="status" required name="status_id">
                                        @if (isset($data['status']))
                                            @foreach ($data['status'] as $status)
                                                <option
                                                    {{ $message->status_id === $status->type_id ? 'selected' : '' }}
                                                    value="{{ $status->type_id }}">{{ $status->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="contract" class="text-muted">Договор</label>
                                    <select class="custom-select form-control-border border-width-2"
                                            id="contract" required name="contract">
                                        @if (isset($message->contract))
                                            @if ($message->contract == 0)
                                                <option value="0" selected>Договора нет</option>
                                                <option value="1">Договор есть</option>
                                            @elseif ($message->contract == 1)
                                                <option value="0">Договора нет</option>
                                                <option value="1" selected>Договор есть</option>
                                            @endif
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="plan" class="text-muted">Запланировано</label>
                                    <div class="input-group" id="reservationdate"
                                         data-target-input="nearest">

                                        <div class="input-group" data-target="#reservationdate"
                                             data-toggle="datetimepicker">
                                            <input id="plan" type="text"
                                                   class="form-control form-control-border border-width-2"
                                                   data-target="#reservationdate" name="plan"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <button type="submit" form="edit-message" class="btn bg-gradient-success float-right">
                                    <i class="far fa-edit"></i> Изменить
                                </button>
                                <a href="{{ route('messages.show.pdf',$message->id) }}"
                                   class="btn bg-gradient-primary float-right mr-2 fill-text-color"
                                   style="color: #fff !important;">
                                    <i class="fas fa-download"></i> Скачать PDF
                                </a>
                                <a href="{{ route('messages.destroy',$message->id) }}"
                                   class="btn bg-gradient-danger float-right mr-2 fill-text-color"
                                   style="color: #fff !important;">
                                    <i class="fas fa-trash-alt"></i> Удалить
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@stop
