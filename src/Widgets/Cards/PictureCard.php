<?php

namespace Dcat\Admin\Widgets\Cards;

use Dcat\Admin\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;

class PictureCard extends Widget
{
    protected $view = 'admin::widgets.cards.card-picture';

    public function __construct(
        protected string $title,
        protected string $description,
        protected string $link,
        protected Renderable $image
    ) {
    }

    public function defaultVariables() : array
    {
        return [
            'attributes' => $this->formatHtmlAttributes(),
            'title'      => $this->title,
            'description'    => $this->description,
            'image'    => $this->image->render(),
            'link'   => $this->link
        ];
    }

}
