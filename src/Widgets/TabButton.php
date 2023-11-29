<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Admin;
use Dcat\Admin\TabButtonType;
use Dcat\Admin\TabContentType;
use Illuminate\Contracts\Support\Renderable;


class TabButton  {

	public function __construct(public int $number, public string $id, public string $title, public ?string $href = null, public ?string $icon = null, public ?string $badge = null, public bool $active) {
	}
}
