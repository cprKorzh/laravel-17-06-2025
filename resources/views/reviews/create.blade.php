@extends('layouts.app')

@section('title', 'Оставить отзыв')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Оставить отзыв о заявке #{{ $request->id }}</div>
            <div class="card-body">
                <div class="mb-4">
                    <h5>Информация о заявке:</h5>
                    <p><strong>Дата и время перевозки:</strong> {{ $request->date }} {{ $request->time }}</p>
                    <p><strong>Тип груза:</strong> {{ $request->cargo_type }}</p>
                    <p><strong>Маршрут:</strong> {{ $request->from_address }} → {{ $request->to_address }}</p>
                </div>
                
                <form method="POST" action="{{ route('reviews.store', $request->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="rating" class="form-label">Оценка</label>
                        <div class="rating">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="rating1" value="1" {{ old('rating') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating1">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="rating2" value="2" {{ old('rating') == 2 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="rating3" value="3" {{ old('rating') == 3 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="rating4" value="4" {{ old('rating') == 4 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="rating5" value="5" {{ old('rating') == 5 ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating5">5</label>
                            </div>
                        </div>
                        @error('rating')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Комментарий</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="4" required>{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
