<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Traits;

trait HasComment
{
    protected ?string $comment = null;

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
