<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function testCanBeCreatedWithValidData(): void
    {
        $user = new User("Jean", "Dupont", "jean@example.com", "Password1!");

        $this->assertSame("Jean", $user->getFirstName());
        $this->assertSame("Dupont", $user->getLastName());
        $this->assertSame("jean@example.com", $user->getEmail());
        $this->assertContains("ANONYMOUS", $user->getRoles());
    }

    public function testCannotBeCreatedWithEmptyFirstName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new User("", "Dupont", "jean@example.com", "Password1!");
    }

    public function testCannotBeCreatedWithEmptyLastName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new User("Jean", "", "jean@example.com", "Password1!");
    }

    public function testCannotBeCreatedWithInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new User("Jean", "Dupont", "invalid-email", "Password1!");
    }

    public function testCannotBeCreatedWithWeakPassword(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new User("Jean", "Dupont", "jean@example.com", "weakpass");
    }

    public function testAddRoleWorksCorrectly(): void
    {
        $user = new User("Jean", "Dupont", "jean@example.com", "Password1!");

        $user->addRole("USER");
        $this->assertContains("USER", $user->getRoles());
        $this->assertNotContains("ANONYMOUS", $user->getRoles());

        $user->addRole("ADMIN");
        $this->assertContains("ADMIN", $user->getRoles());
    }

    public function testRemoveRoleWorksCorrectly(): void
    {
        $user = new User("Jean", "Dupont", "jean@example.com", "Password1!", ["USER", "ADMIN"]);

        $user->removeRole("ADMIN");
        $this->assertNotContains("ADMIN", $user->getRoles());
        $this->assertContains("USER", $user->getRoles());

        $user->removeRole("USER");
        $this->assertContains("ANONYMOUS", $user->getRoles());
    }
}
