<?php
namespace App\Services;

use App\Models\User;

class GameProgressService
{
    public function updateMonthlyProgress(User $user, array $progressData)
    {
        // Обновление атрибутов игрового прогресса
        $progress = $user->gameProgress;

        if (!$progress) {
            // Если прогресс ещё не создан, создаём его
            $progress = $user->gameProgress()->create([]);
        }

        // Обновляем необходимые поля
        foreach ($progressData as $key => $value) {
            $progress->$key = $value;
        }

        $progress->save();

        return $progress;
    }
}
?>
