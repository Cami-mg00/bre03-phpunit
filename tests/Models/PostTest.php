<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Models\Post;

class PostTest extends TestCase
{
    public function testCanBeCreatedWithValidData(): void
    {
        $post = new Post("Titre valide", "Contenu valide", "titre-valide");

        $this->assertSame("Titre valide", $post->getTitle());
        $this->assertSame("Contenu valide", $post->getContent());
        $this->assertSame("titre-valide", $post->getSlug());
        $this->assertFalse($post->isPrivate()); // Par défaut false
    }

    public function testCannotBeCreatedWithEmptyTitle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Post("", "Contenu valide", "titre-valide");
    }

    public function testCannotBeCreatedWithEmptyContent(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Post("Titre valide", "", "titre-valide");
    }

    public function testCannotBeCreatedWithEmptySlug(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Post("Titre valide", "Contenu valide", "");
    }

    public function testCannotBeCreatedWithInvalidSlug(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Post("Titre valide", "Contenu valide", "slug invalide avec espaces!");
    }

    public function testCanBeCreatedAsPrivate(): void
    {
        $post = new Post("Titre", "Contenu", "titre-slug", true);
        $this->assertTrue($post->isPrivate());
    }

    public function testSettersWorkCorrectly(): void
    {
        $post = new Post("Titre", "Contenu", "titre-slug");

        $post->setTitle("Nouveau titre");
        $post->setContent("Nouveau contenu");
        $post->setSlug("nouveau-slug");
        $post->setPrivate(true);

        $this->assertSame("Nouveau titre", $post->getTitle());
        $this->assertSame("Nouveau contenu", $post->getContent());
        $this->assertSame("nouveau-slug", $post->getSlug());
        $this->assertTrue($post->isPrivate());
    }
}
