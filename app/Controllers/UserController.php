<?php
namespace App\Controllers;

use App\Models\User;

class UserController {
    public function getUser() {
        // for improving the code we can add an $id argument sent to getUser
        // and get exactly that user from database
        $user = User::findById(1);
        echo json_encode($user ? $user->toArray() : ['error' => 'User not found']);
    }
}
