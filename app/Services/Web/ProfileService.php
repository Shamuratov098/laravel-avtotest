<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProfileService
{
    public function updateProfile($user, array $data, ?UploadedFile $avatar = null): void
    {
        // Agar yangi rasm yuklangan bo'lsa
        if ($avatar) {
            // Agar foydalanuvchida eski rasm bo'lsa, uni xotiradan o'chiramiz
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Yangi rasmni 'avatars' papkasiga saqlaymiz va yo'lini $data ga qo'shamiz
            $data['avatar'] = $avatar->store('avatars', 'public');
        }

        // Bazadagi foydalanuvchi ma'lumotlarini yangilash
        $user->update($data);
    }
}