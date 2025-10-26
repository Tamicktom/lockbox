<?php

declare(strict_types=1);

namespace Tamicktom\Lockbox\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Tamicktom\Lockbox\Core\View;

final class HomeTest extends TestCase
{
    public function testHomeViewRenders(): void
    {
        $html = View::render('home', ['appName' => 'Lockbox', 'phpVersion' => '8.3']);
        $this->assertStringContainsString('Lockbox', $html);
        $this->assertStringContainsString('Bem-vindo', $html);
    }
}
