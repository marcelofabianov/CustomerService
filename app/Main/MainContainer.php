<?php

declare(strict_types=1);

namespace App\Main;

use App\Domain\DomainContainer;

final class MainContainer
{
    public function register(): void
    {
        $domain = new DomainContainer();
        $domain->register();

        // Consumers
    }
}
