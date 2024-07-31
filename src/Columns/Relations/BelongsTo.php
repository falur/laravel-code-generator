<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Columns\Relations;

class BelongsTo extends AbstractRelation
{
    public function getDatabaseColumn(): ?string
    {
        if ($this->databaseColumn) {
            return $this->databaseColumn;
        }

        if ($this->name) {
            return \str($this->name)
                ->snake()
                ->append('_id')
                ->toString();
        }

        return null;
    }
}
