<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Extensions\Paginate;

use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Illuminate\Contracts\Support\Arrayable;
use Project\Shared\Contracts\ArrayableInterface;

/**
 * @see https://gist.github.com/Naskalin/6306172b8081813ea213099a4d16019a
 * @see https://brennanwal.sh/article/how-to-paginate-doctrine-entities-with-symfony-5
 * @see https://api-platform.com/docs/core/pagination/
 */
class Paginator implements Arrayable
{
    public const DEFAULT_PAGE = 1;

    public const DEFAULT_PER_PAGE = 15;

    private int $page;

    private int $perPage;

    private ?int $nextPage;

    private int $to;

    private int $total;

    private ?int $lastPage;

    private array $items;

    public function __construct($query, bool $fetchJoinCollection = true, bool $outputWalkers = true)
    {
        $this->initRequestParams();
        $paginator = new OrmPaginator($query, $fetchJoinCollection);

        $paginator->getQuery()
            ->setFirstResult($this->perPage * ($this->page - 1))
            ->setMaxResults($this->perPage);

        $this->items = iterator_to_array($paginator->getIterator());
        $this->makeControl($paginator->setUseOutputWalkers($outputWalkers));
    }

    private function makeControl(OrmPaginator $paginator): void
    {
        $this->lastPage = ($lastPage = (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults())) > 1 ? $lastPage : null;
        $this->nextPage = ($nexPage = $this->page + 1) <= $this->lastPage ? $nexPage : null;
        $this->to = $this->perPage;
        $this->total = $paginator->count();
    }

    public function map(\Closure $closure): self
    {
        $this->items = array_map($closure, iterator_to_array($this->items));

        return $this;
    }

//    public function forEach(\Closure $closure): self
//    {
//        foreach ($this->items as $key => $item) {
//            $closure($item, $key);
//        }
//
//        return $this;
//    }

//    public function translateItems(string $translateClassName): self
//    {
//        $this->map(static fn(object $item): object => $translateClassName::execute($item));
//
//        return $this;
//    }

    private function initRequestParams(): void
    {
        $this->page = request()->query->getInt('page', self::DEFAULT_PAGE);
        $this->perPage = request()->query->getInt('per_page', self::DEFAULT_PER_PAGE);
    }

    private function itemToArray(): \Closure
    {
        return static fn (array|ArrayableInterface $item): array => is_array($item) ? $item : $item->toArray();
    }

    public function toArray(): array
    {
        return [
            'current_page' => $this->page,
            'data' => array_map($this->itemToArray(), iterator_to_array($this->items)),
            'next_page' => $this->nextPage,
            'next_page_url' => $this->makePageUrl($this->nextPage),
            'last_page' => $this->lastPage,
            'last_page_url' => $this->makePageUrl($this->lastPage),
            'per_page' => $this->perPage,
            'to' => $this->to,
            'total' => $this->total,
        ];
    }

    private function makePageUrl(?int $page): ?string
    {
        if ($page === null) {
            return null;
        }

        unset($_REQUEST['page'], $_REQUEST['per_page']);

        return sprintf(
            '%s?%s',
            request()->url(),
            http_build_query([
                ...$_REQUEST,
                'page' => $page,
                'per_page' => $this->perPage,
            ])
        );
    }
}
