<?php

namespace App\Http\Controllers;

use App\Models\Request as CargoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->isAdmin()) {
                abort(403, 'Доступ запрещен');
            }
            
            return $next($request);
        });
    }
    
    /**
     * Показать панель администратора
     */
    public function index()
    {
        $requests = CargoRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.index', compact('requests'));
    }
    
    /**
     * Обновить статус заявки
     */
    public function updateStatus(Request $request, $id)
    {
        $cargoRequest = CargoRequest::findOrFail($id);
        
        $request->validate([
            'status' => ['required', 'string', 'in:Новая,В работе,Отменена,Завершена'],
        ]);
        
        $cargoRequest->status = $request->status;
        $cargoRequest->save();
        
        return redirect()->route('admin.index')->with('success', 'Статус заявки успешно обновлен!');
    }
    
    /**
     * Удалить заявку
     */
    public function destroy($id)
    {
        $cargoRequest = CargoRequest::findOrFail($id);
        $cargoRequest->delete();
        
        return redirect()->route('admin.index')->with('success', 'Заявка успешно удалена!');
    }
}
