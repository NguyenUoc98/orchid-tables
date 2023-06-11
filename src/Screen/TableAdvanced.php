<?php

declare(strict_types=1);

namespace Lintaba\OrchidTables\Screen;

use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

abstract class TableAdvanced extends Table
{
    protected $template = 'platform::layouts.tableAdvanced';


    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $columns = collect($this->columns())->filter(static fn (TD $column) => $column->isSee());

        $total = collect($this->total())->filter(static fn (TD $column) => $column->isSee());

        $content = $repository->getContent($this->target);

        $rows = is_a($content, \Illuminate\Contracts\Pagination\Paginator::class) ? $content : collect()->merge($content);

        return view($this->template, [
            'repository'   => $repository,
            'rows'         => $rows,
            'columns'      => $columns,
            'total'        => $total,
            'iconNotFound' => $this->iconNotFound(),
            'textNotFound' => $this->textNotFound(),
            'subNotFound'  => $this->subNotFound(),
            'striped'      => $this->striped(),
            'compact'      => $this->compact(),
            'bordered'     => $this->bordered(),
            'hoverable'    => $this->hoverable(),
            'slug'         => $this->getSlug(),
            'onEachSide'   => $this->onEachSide(),
            'showHeader'   => $this->hasHeader($columns, $rows),
            'title'        => $this->title,
            'rowClass'     => [$this, 'rowClass'],
        ]);
    }

    /**
     * @param Repository|Model $row
     *
     * @return null|string
     */
    public function rowClass($row)
    {
        return null;
    }


    /**
     * Enable a hover state on table rows.
     *
     * @return bool
     */
    protected function hoverable(): bool
    {
        return true;
    }
}
