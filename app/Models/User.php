<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $role;

    public static function findByEmail(string $email): ?self {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) return null;

        return self::mapUser($user);
    }

    public static function findById(int $id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) return null;

        return self::mapUser($user);
    }

    public static function create(string $name, string $email, string $password, string $role = 'user'): bool {
        $db = Database::connect();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashedPassword, $role]);
    }

    public function checkPassword(string $password): bool {
        return password_verify($password, $this->password);
    }

    public function getRole(): string {
        return $this->role;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }

    private static function mapUser(array $user): self {
        $instance = new self();
        $instance->id = $user['id'];
        $instance->name = $user['name'];
        $instance->email = $user['email'];
        $instance->password = $user['password'];
        $instance->role = $user['role'];
        return $instance;
    }
}
