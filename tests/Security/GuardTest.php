<?php

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Security\Guard;

class GuardTest extends TestCase {
    public function testAnonymousCannotAccessPrivatePost() {
        $this->expectException(\Exception::class);
        $post = new Post("Titre", "Contenu", "slug", true);
        $user = new User("Jean", "Dupont", "jean@example.com", "Password1!");
        $guard = new Guard();
        $guard->giveAccess($post, $user);
    }
}
