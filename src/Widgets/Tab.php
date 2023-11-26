<?php
declare(strict_types=1);

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Admin;
use Illuminate\Contracts\Support\Renderable;

//todo:: tab addLink
class Tab extends Widget {
	const TYPE_TAB  = 1;
	const TYPE_PILL = 2;

	/**
	 * @var string
	 */
	protected $view = 'admin::widgets.tab';

	/**
	 * @var array
	 */
	protected array $data = [
		'id' => '',
		'title' => '',
		'tabs' => [],
		'fill' => FALSE,
	];

	public function __construct(int $type = self::TYPE_TAB) {
		$this->data['type'] = $type;
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
	public function add(string $title, string $content, bool $active = FALSE, $icon = FALSE, int $badge = 0, $id = NULL)
	: Tab {
		$this->data['tabs'][] = [
			'id' => $id ?: mt_rand(),
			'title' => $title,
			'content' => $this->toString($this->formatRenderable($content)),
			'active' => $active,
			'icon' => $icon,
			'badge' => $badge,
		];
		return $this;
	}

	public function fill()
	: Tab {
		$this->data['fill'] = TRUE;
		return $this;
	}

	/**
	 * Set title.
	 *
	 * @param string $title
	 */
	public function title($title = '')
	: Tab {
		$this->data['title'] = $title;
		return $this;
	}

	/**
	 * Render Tab.
	 *
	 * @return string
	 */
	public function render() {
		$data = array_merge(
			$this->data,
			['attributes' => $this->formatHtmlAttributes()]
		);
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
