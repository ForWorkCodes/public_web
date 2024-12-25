<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $a = User::all();
        return $a;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|unique:users', // Уникальный идентификатор устройства
            'email' => 'nullable|email|unique:users', // (Необязательно) Email
            'name' => 'nullable|string|max:255', // (Необязательно) Имя пользователя
        ]);

        $user = User::create([
            'device_id' => $validated['device_id'],
            'email' => $validated['email'] ?? null,
            'name' => $validated['name'] ?? 'Player' . rand(1000, 9999),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $user->createToken('game-token')->plainTextToken,
        ]);
    }

    public function updateProgress(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|exists:users,device_id',
            'progress' => 'required|json', // JSON с игровыми данными
        ]);

        $user = User::where('device_id', $validated['device_id'])->first();

        // Сохранение прогресса в поле JSON или отдельную таблицу
        $user->progress = $validated['progress'];
        $user->save();

        return response()->json([
            'message' => 'Progress updated successfully',
        ]);
    }
}
