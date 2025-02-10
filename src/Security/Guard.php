<?php

namespace App\Security;

use App\Models\Post;
use App\Models\User;

class Guard {
    public function giveAccess(Post $post, User $user): User {
        if ($post->isPrivate() && in_array("ANONYMOUS", $user->getRoles())) {
            throw new \Exception("L'utilisateur ne peut pas être anonyme.");
        }
        if ($post->isPrivate() && in_array("USER", $user->getRoles())) {
            $user->addRole("ADMIN");
        }
        if (!$post->isPrivate() && in_array("ANONYMOUS", $user->getRoles())) {
            $user->addRole("USER");
        }
        return $user;
    }

    public function removeAccess(Post $post, User $user): User {
        if ($post->isPrivate() && in_array("USER", $user->getRoles())) {
            $user->removeRole("USER");
        }
        if ($post->isPrivate() && in_array("ADMIN", $user->getRoles())) {
            $user->removeRole("ADMIN");
        }
        if (!$post->isPrivate() && in_array("USER", $user->getRoles())) {
            $user->removeRole("USER");
        }
        if (!$post->isPrivate() && in_array("ADMIN", $user->getRoles())) {
            $user->removeRole("ADMIN");
        }
        return $user;
    }
}
