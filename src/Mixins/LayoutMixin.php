<?php

declare(strict_types=1);

namespace Lintaba\OrchidTables\Mixins;

use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Repository;

class LayoutMixin
{
    public static function html(): callable
    {
        return function (string $content) {
            return new class ($content) extends Layout {
                public $content;

                public function __construct($content)
                {
                    $this->content = $content;
                }

                public function build(Repository $repository)
                {
                    return (string)value($this->content);
                }
            };
        };
    }

    public static function modalSlideRight(): callable
    {
        return function (string $key, array $layouts = []) {
            return new class($key, $layouts) extends Modal
            {
                /**
                 * @var string
                 */
                protected $template = 'platform::layouts.modal_slide_right';
            };
        };
    }
}
