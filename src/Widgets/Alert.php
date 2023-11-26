<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

use Dcat\Admin\DcatIcon;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Enums\StyleClassType;
use Illuminate\Contracts\Support\Renderable;

class Alert implements Renderable
{
    protected $view = 'admin::widgets.alert';
    protected string $icon = '';
    protected string $class = '';
    protected bool $dismissable = false;

    public function __construct(
        protected string $content = '',
        protected ?string $title = null,
        StyleClassType $class = StyleClassType::DANGER)
    {
        $this->content($content);
        $this->title($title);
        $this->class($class);
    }

    public function class(StyleClassType $class) : Alert
    {
        $this->class = $class->value;

        return $this;
    }

    /**
     * Set title.
     *
     */
    public function title(string $title) : Alert
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set contents.
     *
     */
    public function content(string|\Closure|Renderable $content) : Alert
    {
        $this->content = Helper::render($content);

        return $this;
    }

    /**
     * Show close button.
     */
    public function dismissable(bool $value = true) : Alert
    {
        $this->dismissable = $value;

        return $this;
    }

    // /**
    //  * Add style.
    //  *
    //  * @param  string  $style
    //  * @return $this
    //  */
    // public function style($style = 'info')
    // {
    //     $this->style = $style;

    //     return $this;
    // }

    /**
     * Add icon.
     *
     */
    public function icon(DcatIcon $icon) : Alert
    {
        $this->icon = $icon->_();

        return $this;
    }

    /**
     * @return array
     */
    public function render() : string
    {
        return view($this->view,[
            'title'        => $this->title,
            'content'      => $this->content,
            'icon'         => $this->icon,
            'class'        => $this->class,
            'dismissable'  => $this->dismissable,
        ])->render();
    }
}
