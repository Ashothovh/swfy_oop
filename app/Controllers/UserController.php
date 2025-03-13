<?php
namespace App\Controllers;

use App\Models\User;

class UserController {
    public function getUser() {
        $user = User::findById(1);
        echo json_encode($user ? $user->toArray() : ['error' => 'User not found']);
    }
}
