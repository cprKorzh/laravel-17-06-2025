<?php

namespace App\Http\Controllers;

use App\Models\Request as CargoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    /**
     * Показать список заявок пользователя
     */
    public function index()
    {
        $requests = Auth::user()->requests()->orderBy('created_at', 'desc')->get();
        return view('requests.index', compact('requests'));
    }
    
    /**
     * Показать форму создания заявки
     */
    public function create()
    {
        $cargoTypes = [
            'хрупкое',
            'скоропортящееся',
            'требуется рефрижератор',
            'животные',
            'жидкость',
            'мебель',
            'мусор'
        ];
        
        return view('requests.create', compact('cargoTypes'));
    }
    
    /**
     * Сохранить новую заявку
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required'],
            'weight_kg' => ['required', 'numeric', 'min:0'],
            'volume_m3' => ['required', 'numeric', 'min:0'],
            'from_address' => ['required', 'string'],
            'to_address' => ['required', 'string'],
            'cargo_type' => ['required', 'string'],
        ], [
            'date.required' => 'Поле дата обязательно для заполнения',
            'date.date' => 'Введите корректную дату',
            'date.after_or_equal' => 'Дата должна быть не раньше сегодняшнего дня',
            'time.required' => 'Поле время обязательно для заполнения',
            'weight_kg.required' => 'Поле вес груза обязательно для заполнения',
            'weight_kg.numeric' => 'Вес груза должен быть числом',
            'weight_kg.min' => 'Вес груза не может быть отрицательным',
            'volume_m3.required' => 'Поле объем груза обязательно для заполнения',
            'volume_m3.numeric' => 'Объем груза должен быть числом',
            'volume_m3.min' => 'Объем груза не может быть отрицательным',
            'from_address.required' => 'Поле адрес отправления обязательно для заполнения',
            'to_address.required' => 'Поле адрес доставки обязательно для заполнения',
            'cargo_type.required' => 'Поле тип груза обязательно для заполнения',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $cargoRequest = new CargoRequest();
        $cargoRequest->user_id = Auth::id();
        $cargoRequest->date = $request->date;
        $cargoRequest->time = $request->time;
        $cargoRequest->weight_kg = $request->weight_kg;
        $cargoRequest->volume_m3 = $request->volume_m3;
        $cargoRequest->from_address = $request->from_address;
        $cargoRequest->to_address = $request->to_address;
        $cargoRequest->cargo_type = $request->cargo_type;
        $cargoRequest->status = 'Новая';
        $cargoRequest->save();
        
        return redirect()->route('requests.index')->with('success', 'Заявка успешно создана!');
    }
    
    /**
     * Показать детали заявки
     */
    public function show($id)
    {
        $request = CargoRequest::findOrFail($id);
        
        // Проверяем, принадлежит ли заявка текущему пользователю или является ли пользователь администратором
        if ($request->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
        
        return view('requests.show', compact('request'));
    }
}
