@extends('layouts.app')

@section('title', 'Мои заявки')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Мои заявки</span>
                <a href="{{ route('requests.create') }}" class="btn btn-sm btn-primary">Создать заявку</a>
            </div>
            <div class="card-body">
                @if($requests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Дата и время</th>
                                    <th>Тип груза</th>
                                    <th>Откуда</th>
                                    <th>Куда</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $request)
                                    <tr>
                                        <td>{{ $request->id }}</td>
                                        <td>{{ $request->date }} {{ $request->time }}</td>
                                        <td>{{ $request->cargo_type }}</td>
                                        <td>{{ $request->from_address }}</td>
                                        <td>{{ $request->to_address }}</td>
                                        <td>
                                            @if($request->status == 'Новая')
                                                <span class="badge bg-info">{{ $request->status }}</span>
                                            @elseif($request->status == 'В работе')
                                                <span class="badge bg-warning">{{ $request->status }}</span>
                                            @elseif($request->status == 'Завершена')
                                                <span class="badge bg-success">{{ $request->status }}</span>
                                            @elseif($request->status == 'Отменена')
                                                <span class="badge bg-danger">{{ $request->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('requests.show', $request->id) }}" class="btn btn-sm btn-info">Подробнее</a>
                                            @if($request->status == 'Завершена' && !$request->hasReview())
                                                <a href="{{ route('reviews.create', $request->id) }}" class="btn btn-sm btn-success">Оставить отзыв</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        У вас пока нет заявок. <a href="{{ route('requests.create') }}">Создать заявку</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
