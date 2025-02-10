<?php

namespace App\Models;

class User {
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private array $roles;

    public function __construct(string $firstName, string $lastName, string $email, string $password, array $roles = ["ANONYMOUS"]) {
        if (empty($firstName)) {
            throw new \InvalidArgumentException("Le prénom ne peut pas être vide.");
        }
        if (empty($lastName)) {
            throw new \InvalidArgumentException("Le nom ne peut pas être vide.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("L'email doit être valide.");
        }
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            throw new \InvalidArgumentException("Le mot de passe doit contenir 8 caractères, un chiffre, une majuscule et un caractère spécial.");
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function addRole(string $newRole): array {
        if (!in_array($newRole, ["USER", "ADMIN"])) {
            throw new \InvalidArgumentException("Rôle non valide.");
        }
        $this->roles[] = $newRole;
        $this->roles = array_unique($this->roles);
        $this->roles = array_diff($this->roles, ["ANONYMOUS"]);
        return $this->roles;
    }

    public function removeRole(string $role): array {
        if ($role === "ANONYMOUS") return $this->roles;
        $this->roles = array_diff($this->roles, [$role]);
        if (empty($this->roles)) {
            $this->roles[] = "ANONYMOUS";
        }
        return $this->roles;
    }

    public function getRoles(): array { return $this->roles; }
}
