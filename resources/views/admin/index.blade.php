@extends('layouts.app')

@section('title', 'Панель администратора')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .admin-panel {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .admin-header {
        background-color: #343a40;
        color: white;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .status-badge {
        font-size: 0.9rem;
    }
    .action-buttons .btn {
        margin-right: 5px;
    }
</style>
@endsection

@section('content')
<div class="admin-header">
    <h2 class="mb-0"><i class="bi bi-gear-fill me-2"></i> Панель администратора</h2>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Управление заявками</h5>
            </div>
            <div class="card-body">
                @if($requests->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Пользователь</th>
                                    <th>Дата и время</th>
                                    <th>Тип груза</th>
                                    <th>Маршрут</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $request)
                                    <tr>
                                        <td>{{ $request->id }}</td>
                                        <td>
                                            <strong>{{ $request->user->fullname }}</strong><br>
                                            <small>{{ $request->user->tel }}</small>
                                        </td>
                                        <td>{{ $request->date }}<br>{{ $request->time }}</td>
                                        <td>
                                            {{ $request->cargo_type }}<br>
                                            <small>{{ $request->weight_kg }} кг, {{ $request->volume_m3 }} м³</small>
                                        </td>
                                        <td>
                                            <small>От: {{ $request->from_address }}</small><br>
                                            <small>До: {{ $request->to_address }}</small>
                                        </td>
                                        <td>
                                            @if($request->status == 'Новая')
                                                <span class="badge bg-info status-badge">{{ $request->status }}</span>
                                            @elseif($request->status == 'В работе')
                                                <span class="badge bg-warning status-badge">{{ $request->status }}</span>
                                            @elseif($request->status == 'Завершена')
                                                <span class="badge bg-success status-badge">{{ $request->status }}</span>
                                            @elseif($request->status == 'Отменена')
                                                <span class="badge bg-danger status-badge">{{ $request->status }}</span>
                                            @endif
                                        </td>
                                        <td class="action-buttons">
                                            <div class="mb-2">
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $request->id }}">
                                                    <i class="bi bi-pencil-square"></i> Статус
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту заявку?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Удалить
                                                </button>
                                            </form>
                                            
                                            <!-- Модальное окно для изменения статуса -->
                                            <div class="modal fade" id="statusModal{{ $request->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $request->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="statusModalLabel{{ $request->id }}">Изменить статус заявки #{{ $request->id }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('admin.requests.status', $request->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="status{{ $request->id }}" class="form-label">Статус</label>
                                                                    <select class="form-select" id="status{{ $request->id }}" name="status">
                                                                        <option value="Новая" {{ $request->status == 'Новая' ? 'selected' : '' }}>Новая</option>
                                                                        <option value="В работе" {{ $request->status == 'В работе' ? 'selected' : '' }}>В работе</option>
                                                                        <option value="Завершена" {{ $request->status == 'Завершена' ? 'selected' : '' }}>Завершена</option>
                                                                        <option value="Отменена" {{ $request->status == 'Отменена' ? 'selected' : '' }}>Отменена</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Нет заявок для отображения.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
