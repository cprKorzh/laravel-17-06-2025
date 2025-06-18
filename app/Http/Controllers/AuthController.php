<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Показать форму регистрации
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    
    /**
     * Обработка регистрации пользователя
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => ['required', 'string', 'min:6', 'unique:users', 'regex:/^[А-Яа-яЁё]+$/u'],
            'fullname' => ['required', 'string', 'regex:/^[А-Яа-яЁё\s]+$/u'],
            'tel' => ['required', 'string', 'regex:/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'login.required' => 'Поле логин обязательно для заполнения',
            'login.min' => 'Логин должен содержать не менее 6 символов',
            'login.unique' => 'Такой логин уже используется',
            'login.regex' => 'Логин должен содержать только символы кириллицы',
            'fullname.required' => 'Поле ФИО обязательно для заполнения',
            'fullname.regex' => 'ФИО должно содержать только символы кириллицы и пробелы',
            'tel.required' => 'Поле телефон обязательно для заполнения',
            'tel.regex' => 'Телефон должен быть в формате +7(XXX)-XXX-XX-XX',
            'email.required' => 'Поле email обязательно для заполнения',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Такой email уже используется',
            'password.required' => 'Поле пароль обязательно для заполнения',
            'password.min' => 'Пароль должен содержать не менее 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user = User::create([
            'login' => $request->login,
            'fullname' => $request->fullname,
            'tel' => $request->tel,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        
        Auth::login($user);
        
        return redirect()->route('home')->with('success', 'Регистрация успешно завершена!');
    }
    
    /**
     * Показать форму авторизации
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    /**
     * Обработка авторизации пользователя
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Поле логин обязательно для заполнения',
            'password.required' => 'Поле пароль обязательно для заполнения',
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('home'));
        }
        
        return back()->withErrors([
            'login' => 'Неверный логин или пароль',
        ])->onlyInput('login');
    }
    
    /**
     * Выход пользователя из системы
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
