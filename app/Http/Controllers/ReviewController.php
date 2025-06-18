<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Request as CargoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Показать форму создания отзыва
     */
    public function create($requestId)
    {
        $request = CargoRequest::findOrFail($requestId);
        
        // Проверяем, принадлежит ли заявка текущему пользователю
        if ($request->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен');
        }
        
        // Проверяем, завершена ли заявка
        if (!$request->isCompleted()) {
            return redirect()->route('requests.index')->with('error', 'Вы можете оставить отзыв только для завершенных заявок');
        }
        
        // Проверяем, есть ли уже отзыв для этой заявки
        if ($request->hasReview()) {
            return redirect()->route('requests.index')->with('error', 'Вы уже оставили отзыв для этой заявки');
        }
        
        return view('reviews.create', compact('request'));
    }
    
    /**
     * Сохранить новый отзыв
     */
    public function store(Request $request, $requestId)
    {
        $cargoRequest = CargoRequest::findOrFail($requestId);
        
        // Проверяем, принадлежит ли заявка текущему пользователю
        if ($cargoRequest->user_id !== Auth::id()) {
            abort(403, 'Доступ запрещен');
        }
        
        // Проверяем, завершена ли заявка
        if (!$cargoRequest->isCompleted()) {
            return redirect()->route('requests.index')->with('error', 'Вы можете оставить отзыв только для завершенных заявок');
        }
        
        // Проверяем, есть ли уже отзыв для этой заявки
        if ($cargoRequest->hasReview()) {
            return redirect()->route('requests.index')->with('error', 'Вы уже оставили отзыв для этой заявки');
        }
        
        $validator = Validator::make($request->all(), [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10'],
        ], [
            'rating.required' => 'Поле оценка обязательно для заполнения',
            'rating.integer' => 'Оценка должна быть целым числом',
            'rating.min' => 'Оценка должна быть не менее 1',
            'rating.max' => 'Оценка должна быть не более 5',
            'comment.required' => 'Поле комментарий обязательно для заполнения',
            'comment.min' => 'Комментарий должен содержать не менее 10 символов',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $review = new Review();
        $review->user_id = Auth::id();
        $review->request_id = $requestId;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
        
        return redirect()->route('requests.index')->with('success', 'Отзыв успешно добавлен!');
    }
}
