<?php

namespace Project\Shared\Domain\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use InvalidArgumentException;
use IteratorAggregate;
use Countable;

abstract class BaseCollection extends ArrayCollection implements Countable, IteratorAggregate
{
    protected function __construct(array $elements = [])
    {
        $this->arrayOf($elements, $this->className());
        parent::__construct($elements);
    }

    public static function make(array $elements = []): static
    {
        return new static($elements);
    }

    private function arrayOf(array $elements, string $class): void
    {
        foreach ($elements as $element) {
            $this->instanceOf($element, $class);
        }
    }

    private function instanceOf($element, string $class): void
    {
        if (!$element instanceof $class) {
            if (is_array($element)) {
                return;
            }
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', $class, get_class($element))
            );
        }
    }

    abstract protected function className(): string;

    // abstract protected function translatorClass(): string;

    public function forEach(\Closure $p): void
    {
        foreach ($this->getIterator() as $key => $element) {
            $p($element, $key);
        }
    }

    // public function translateItems(string $locale = null): self
    // {
    //     $translateClassName = $this->translatorClass();
    //
    //     foreach ($this->getIterator() as $item) {
    //         $translateClassName::execute($item, $locale);
    //     }
    //
    //     return $this;
    // }
}
