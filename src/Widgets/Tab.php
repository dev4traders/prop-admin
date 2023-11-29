<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Admin;
use Dcat\Admin\TabButtonType;
use Dcat\Admin\TabContentType;
use Illuminate\Contracts\Support\Renderable;

//todo:: tab vertical tabs
class Tab extends Widget {

	/**
	 * @var string
	 */
	protected $view = 'admin::widgets.tab';

	/**
	 * @var array
	 */
	protected array $tabs = [];

    protected string $id = '';
    protected string $title = '';
    protected bool $isFill = false;
    protected int $active = -1;
    protected ?\Closure $builder = null;

    protected TabButtonType $buttonType = TabButtonType::TAB;

	public function __construct(TabButtonType $buttonType = TabButtonType::TAB, ?\Closure $builder = null) {

		$this->buttonType = $buttonType;
        $this->builder = $builder;

		return $this;
	}

	/**
	 * Add a tab and its contents.
	 *
	 * @return $this
	 */
	public function add( string $title, string|Renderable $content, ?string $id = null, bool $active = FALSE, ?string $icon = null, ?string $badge = null ): Tab {

        if(empty($id))
            $id = (string)mt_rand();

        $count = count($this->tabs);
        $button = new TabButton($count+1, $id, $title, null, $icon, $badge, $active);

		$this->tabs[] = [
			'id' => $id,
			'button' => $button,
			'content' => $this->toString($this->formatRenderable($content)),
            'type' => TabContentType::TEXT,
		];

        if($active)
            $this->active = $count;

		return $this;
	}

    public function addLink(string $title, string $href, bool $active = false, ?string $icon = null, ?string $badge = null) : Tab
    {
        $id = (string)mt_rand();
        $count = count($this->tabs);

        $button = new TabButton($count+1,$id, $title, $href, $icon, $badge, $active);

        $this->tabs[] = [
            'id'      => $id,
            'button'   => $button,
            'type' => TabContentType::LINK,
        ];

        if($active)
            $this->active = $count;

        return $this;
    }

	public function fill() : Tab {
		$this->isFill = TRUE;

		return $this;
	}

	/**
	 * Set title.
	 *
	 * @param string $title
	 */
	public function title(?string $title = null): Tab {
		$this->title = $title;

		return $this;
	}

	/**
	 * Render Tab.
	 *
	 * @return string
	 */
	public function render() {
		$data = [
            'attributes' => $this->formatHtmlAttributes(),
            'id' => $this->id,
            'active' => $this->active,
            'title' => $this->title,
            'tabs' => $this->tabs,
            'builder' => $this->builder,
            'button_type' => $this->buttonType,
            'content_type' => $this->contentType,
            'fill' => $this->isFill,
        ];
		$this->setupScript();

		return view($this->view, $data)->render();
	}

	/**
	 * Setup script.
	 */
	protected function setupScript() {
		$script = <<<'SCRIPT'
var hash = document.location.hash;
if (hash) {
    $('.nav-tabs a[href="' + hash + '"]').tab('show');
}

// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    history.pushState(null,null, e.target.hash);
});
SCRIPT;
		Admin::script($script);
	}
}
