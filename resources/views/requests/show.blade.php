@extends('layouts.app')

@section('title', 'Детали заявки')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Детали заявки #{{ $request->id }}</span>
                <a href="{{ route('requests.index') }}" class="btn btn-sm btn-secondary">Назад к списку</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Статус:</div>
                    <div class="col-md-8">
                        @if($request->status == 'Новая')
                            <span class="badge bg-info">{{ $request->status }}</span>
                        @elseif($request->status == 'В работе')
                            <span class="badge bg-warning">{{ $request->status }}</span>
                        @elseif($request->status == 'Завершена')
                            <span class="badge bg-success">{{ $request->status }}</span>
                        @elseif($request->status == 'Отменена')
                            <span class="badge bg-danger">{{ $request->status }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Дата и время перевозки:</div>
                    <div class="col-md-8">{{ $request->date }} {{ $request->time }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Тип груза:</div>
                    <div class="col-md-8">{{ $request->cargo_type }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Вес груза:</div>
                    <div class="col-md-8">{{ $request->weight_kg }} кг</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Объем груза:</div>
                    <div class="col-md-8">{{ $request->volume_m3 }} м³</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Адрес отправления:</div>
                    <div class="col-md-8">{{ $request->from_address }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Адрес доставки:</div>
                    <div class="col-md-8">{{ $request->to_address }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Дата создания заявки:</div>
                    <div class="col-md-8">{{ $request->created_at->format('d.m.Y H:i') }}</div>
                </div>
                
                @if($request->status == 'Завершена')
                    @if($request->hasReview())
                        <div class="alert alert-success mt-3">
                            <h5>Ваш отзыв:</h5>
                            <div class="mb-2">
                                <strong>Оценка:</strong> 
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $request->review->rating)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-warning"></i>
                                    @endif
                                @endfor
                                ({{ $request->review->rating }}/5)
                            </div>
                            <div>
                                <strong>Комментарий:</strong> {{ $request->review->comment }}
                            </div>
                        </div>
                    @else
                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('reviews.create', $request->id) }}" class="btn btn-success">Оставить отзыв</a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
