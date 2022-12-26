<!DOCTYPE html>
<html>
<head><title>{{ $message->fio }}</title></head>
<body>
<p><strong>Адрес установки:</strong> {{ $message->address }} д. {{ $message->house }}</p>
<p><strong>ФИО:</strong>  {{ $message->fio }}</p>
<p><strong>Контактный номер:</strong> {{ $message->phone }} </p>
<p><strong>ID оборудования:</strong> {{ $message->uid}}</p>
{{--<p><strong>Исполнитель:</strong> {{ $message->responsible->name }}</p>--}}
<p><strong>Исполнитель:</strong> Матушкин Сергей</p>
<p><strong>Примечание:</strong> {{ $message->type->name }}</p>
{{--<p><strong>Статус:</strong> {{ $message->status->name }}</p>--}}
<p><strong>Статус:</strong> Выполнена</p>
<p><strong>Закрыта:</strong> {{ $message->closed }}</p>
@if (isset($message->contract))
    @if ($message->contract == 0)
        <p><strong>Договор:</strong> Нет</p>
    @elseif ($message->contract == 1)
        <p><strong>Договор:</strong> Есть</p>
    @endif
@endif
<p><strong>Фото:</strong></p>
@foreach($replies as $reply)
    @foreach($reply->attachment as $file)
        <img alt="error" src="{{ public_path('storage/images/'.$file->name) }}" style="width: 100%">
    @endforeach
@endforeach
</body>
</html>
