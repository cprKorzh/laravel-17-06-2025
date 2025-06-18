@extends('layouts.app')

@section('title', 'Создание заявки')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Создание заявки на перевозку груза</div>
            <div class="card-body">
                <form method="POST" action="{{ route('requests.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="date" class="form-label">Дата перевозки</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required min="{{ date('Y-m-d') }}">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="time" class="form-label">Время перевозки</label>
                        <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" name="time" value="{{ old('time') }}" required>
                        @error('time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="weight_kg" class="form-label">Вес груза (кг)</label>
                        <input type="number" step="0.01" class="form-control @error('weight_kg') is-invalid @enderror" id="weight_kg" name="weight_kg" value="{{ old('weight_kg') }}" required min="0">
                        @error('weight_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="volume_m3" class="form-label">Объем груза (м³)</label>
                        <input type="number" step="0.01" class="form-control @error('volume_m3') is-invalid @enderror" id="volume_m3" name="volume_m3" value="{{ old('volume_m3') }}" required min="0">
                        @error('volume_m3')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cargo_type" class="form-label">Тип груза</label>
                        <select class="form-select @error('cargo_type') is-invalid @enderror" id="cargo_type" name="cargo_type" required>
                            <option value="" selected disabled>Выберите тип груза</option>
                            @foreach($cargoTypes as $type)
                                <option value="{{ $type }}" {{ old('cargo_type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('cargo_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="from_address" class="form-label">Адрес отправления</label>
                        <input type="text" class="form-control @error('from_address') is-invalid @enderror" id="from_address" name="from_address" value="{{ old('from_address') }}" required>
                        @error('from_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="to_address" class="form-label">Адрес доставки</label>
                        <input type="text" class="form-control @error('to_address') is-invalid @enderror" id="to_address" name="to_address" value="{{ old('to_address') }}" required>
                        @error('to_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Отправить заявку</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
