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

    protected TabButtonType $buttonType = TabButtonType::TAB;

	public function __construct(TabButtonType $buttonType = TabButtonType::TAB) {

		$this->buttonType = $buttonType;

		return $this;
	}

	/**
	 * Add a tab and its contents.
	 *
	 * @param string $title
	 * @param string|Renderable $content
	 * @param bool $active
	 * @param string|null $id
	 *
	 * @return $this
	 */
	public function add(string $title, string $content, bool $active = FALSE, $icon = FALSE, int $badge = 0, $id = NULL): Tab {
		$this->tabs[] = [
			'id' => $id ?: mt_rand(),
			'title' => $title,
			'content' => $this->toString($this->formatRenderable($content)),
			'icon' => $icon,
			'badge' => $badge,
            'type' => TabContentType::TEXT,
		];

        if($active)
            $this->active = count($this->tabs) - 1;

		return $this;
	}

    public function addLink(string $title, string $href, bool $active = false, $icon = FALSE, int $badge = 0) : Tab
    {
        $this->tabs[] = [
            'id'      => mt_rand(),
            'title'   => $title,
			'icon' => $icon,
			'badge' => $badge,
            'href'    => $href,
            'type' => TabContentType::LINK,
        ];

        if($active)
            $this->active = count($this->tabs) - 1;

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
