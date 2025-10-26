<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Tamicktom\Lockbox\Core\View;

final class HomeTest extends TestCase
{
    public function test_home_view_renders(): void
    {
        $html = View::render('home', ['appName' => 'Lockbox', 'phpVersion' => '8.3']);
        $this->assertStringContainsString('Lockbox', $html);
        $this->assertStringContainsString('Bem-vindo', $html);
    }
}
