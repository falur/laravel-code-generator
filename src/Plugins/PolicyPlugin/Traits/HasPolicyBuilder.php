<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Plugins\PolicyPlugin\Traits;

use GianTiaga\CodeGenerator\Plugins\PolicyPlugin\Builders\PolicyBuilder;

trait HasPolicyBuilder
{
    protected ?PolicyBuilder $policyBuilder = null;

    public function getPolicyBuilder(): ?PolicyBuilder
    {
        return $this->policyBuilder;
    }

    public function setPolicyBuilder(?PolicyBuilder $policyBuilder): static
    {
        $this->policyBuilder = $policyBuilder;

        return $this;
    }
}
