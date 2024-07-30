<?php

declare(strict_types=1);

namespace GianTiaga\CodeGenerator\Renderers;

use GianTiaga\CodeGenerator\Builders\Target\AbstractBuilder;
use GianTiaga\CodeGenerator\Views\ViewInterface;

class Renderer
{
    public function __construct(
        protected ViewInterface $view,
        protected ?AbstractBuilder $builder,
    ) {}

    /**
     * @return ?string
     *
     * @throws \Throwable
     */
    public function render(): ?string
    {
        if (! $this->builder) {
            return null;
        }

        return view($this->builder->getFrom(), [
            'view' => $this->view,
        ])->render();
    }

    /**
     * @throws \Throwable
     */
    public function copyRendered(string $filename, bool $force = false): void
    {
        $rendered = $this->render();

        if (! $rendered || ! $this->builder) {
            return;
        }

        $filename = rtrim($this->builder->getDestination(), '/').'/'.ltrim($filename, '/');

        if (! file_exists($filename) || $force) {
            file_put_contents($filename, $rendered);
        }
    }
}
