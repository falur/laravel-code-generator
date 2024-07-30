<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Relations;

class BelongsTo extends AbstractRelation
{
    protected ?string $column = null;

    public function getColumn(): ?string
    {
        return $this->column;
    }

    public function setColumn(?string $column): static
    {
        $this->column = $column;

        return $this;
    }

    public function getDatabaseColumn(): ?string
    {
        if ($this->name) {
            return \str($this->name)
                ->snake()
                ->append('_id')
                ->toString();
        }

        return null;
    }
}
