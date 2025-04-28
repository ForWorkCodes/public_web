<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGameProgressRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\GameProgressService;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $gameProgressService;

    public function __construct(GameProgressService $gameProgressService)
    {
        $this->gameProgressService = $gameProgressService;
    }

    public function show(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'email' => 'nullable|email',
            'name' => 'nullable|string|max:255',
        ]);
        $user = User::with('gameProgress')->where('device_id', $validated['device_id'])->first();

        if ($user)
        {
            return [
                'success' => true,
                'code' => 9001,
                'token' => '',
                'user' => $user
            ];
        }

//FamilyManager
//PlayerManager
//SpouseManager
//NpcManager
//ChildrenManager
//NoteManager
//BusinessManager
//TimberGameManager
//ClayGameManager
//StorageManager
//LocationManager
//TaskManager

        return [
            'success' => false,
            'code' => 9003,
            'message' => 'User not found'
        ];
    }

    public function show_all(Request $request)
    {
        $a = User::with('gameProgress')->get();
        return $a;
    }

    public function update(Request $request)
    {
        //
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|unique:users',
            'email' => 'nullable|email|unique:users',
            'name' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'device_id' => $validated['device_id'],
            'email' => $validated['email'] ?? null,
            'name' => $validated['name'] ?? 'Player' . rand(1000, 9999),
        ]);

        return response()->json([
            'success' => true,
            'code' => 9001,
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $user->createToken('game-token')->plainTextToken,
        ]);
    }

    public function updateProgress(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|exists:users,device_id',
            'progress' => 'required|json',
        ]);

        $user = User::where('device_id', $validated['device_id'])->first();

        $user->progress = $validated['progress'];
        $user->save();

        return response()->json([
            'message' => 'Progress updated successfully',
        ]);
    }

    public function updateMonthlyProgress(UpdateGameProgressRequest $request)
    {
        $error = '';

        Log::info('Incoming data for updateMonthlyProgress:', $request->all());
        if (empty($request['device_id']))
        {
            $error = "device_id are empty";
        }

        if ($error)
        {
            return response()->json([
                'success' => false,
                'code' => 9003,
                'message' => $error,
            ]);
        }
        //$user = User::where('device_id', $request['device_id'])->first();

        //$progress = $this->gameProgressService->updateMonthlyProgress($user, $request->validated());

        return response()->json([
            'success' => true,
            'code' => 9001,
            'message' => 'Game progress updated successfully',
            //'data' => $progress,
        ]);
    }
}
