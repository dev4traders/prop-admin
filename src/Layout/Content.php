<?php

namespace Dcat\Admin\Layout;

use Closure;
use Dcat\Admin\Admin;
use Illuminate\Support\ViewErrorBag;
use Dcat\Admin\Traits\HasBuilderEvents;
use Illuminate\Support\Traits\Macroable;
use Dcat\Admin\Exception\RuntimeException;
use Dcat\Admin\Support\Helper;
use Illuminate\Contracts\Support\Renderable;

class Content implements Renderable
{
    use HasBuilderEvents, Macroable;

    /**
     * @var string
     */
    protected $view = 'admin::layouts.content';

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * Content title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * Content description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Help Topic.
     *
     * @var string
     */
    protected string $helpTopic = '';

    /**
     * Page breadcrumb.
     *
     * @var array
     */
    protected $breadcrumb = [];

    /**
     * @var Row[]
     */
    protected $rows = [];

    protected string $content = '';

    protected array $config = [];

    /**
     * Content constructor.
     *
     * @param  Closure|null  $callback
     */
    public function __construct(\Closure $callback = null)
    {
        $this->callResolving();

        if ($callback instanceof Closure) {
            $callback($this);
        }
    }

    /**
     * Create a content instance.
     *
     * @param  mixed  ...$params
     * @return $this
     */
    public static function make(...$params)
    {
        return new static(...$params);
    }

    /**
     * @param  string  $header
     * @return $this
     */
    public function header($header = '')
    {
        return $this->title($header);
    }

    /**
     * Set title of content.
     *
     * @param  string  $title
     * @return $this
     */
    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set description of content.
     *
     * @param  string  $description
     * @return $this
     */
    public function description($description = '')
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set help topic of content.
     *
     * @param  string  $description
     * @return $this
     */
    public function helpTopic(string $helpTopic = '') : Content
    {
        $this->helpTopic = $helpTopic;

        return $this;
    }

    /**
     * 设置翻译文件路径.
     *
     * @param  string|null  $translation
     * @return $this
     */
    public function translation(?string $translation)
    {
        Admin::translation($translation);

        return $this;
    }

    public function full() : Content
    {
        return $this->view('admin::layouts.full-content');
    }

    public function auth() {
        return $this->view('admin::layouts.auth');
    }

    /**
     * Set breadcrumb of content.
     *
     * @example
     *     $this->breadcrumb('Menu', 'auth/menu', 'fa fa-align-justify');
     *     $this->breadcrumb([
     *         ['text' => 'Menu', 'url' => 'auth/menu', 'icon' => 'fa fa-align-justify']
     *     ]);
     *
     * @param  array  ...$breadcrumb
     * @return $this
     */
    public function breadcrumb(...$breadcrumb)
    {
        $this->formatBreadcrumb($breadcrumb);

        $this->breadcrumb = array_merge($this->breadcrumb, $breadcrumb);

        return $this;
    }

    /**
     * @param  array  $breadcrumb
     * @return void
     *
     * @throws \Exception
     */
    protected function formatBreadcrumb(array &$breadcrumb)
    {
        if (! $breadcrumb) {
            throw new RuntimeException('Breadcrumb format error!');
        }

        $notArray = false;
        foreach ($breadcrumb as &$item) {
            $isArray = is_array($item);
            if ($isArray && ! isset($item['text'])) {
                throw new RuntimeException('Breadcrumb format error!');
            }
            if (! $isArray && $item) {
                $notArray = true;
            }
        }
        if (! $breadcrumb) {
            throw new RuntimeException('Breadcrumb format error!');
        }
        if ($notArray) {
            $breadcrumb = [
                [
                    'text' => $breadcrumb[0] ?? null,
                    'url'  => $breadcrumb[1] ?? null,
                    'icon' => $breadcrumb[2] ?? null,
                ],
            ];
        }
    }

    /**
     * Alias of method row.
     *
     * @param  mixed  $content
     * @return Content
     */
    public function body($content)
    {
        return $this->row($content);
    }

    /**
     * Add one row for content body.
     *
     * @param $content
     * @return $this
     */
    public function row($content)
    {
        if ($content instanceof Closure) {
            $row = new Row();
            call_user_func($content, $row);
            $this->addRow($row);
        } else {
            $this->addRow(new Row($content));
        }

        return $this;
    }

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param $content
     * @return $this
     */
    public function prepend($content)
    {
        if ($content instanceof Closure) {
            $row = new Row();
            call_user_func($content, $row);
            $this->prependRow($row);
        } else {
            $this->prependRow(new Row($content));
        }

        return $this;
    }

    protected function prependRow(Row $row)
    {
        array_unshift($this->rows, $row);
    }

    /**
     * Add Row.
     *
     * @param  Row  $row
     */
    protected function addRow(Row $row)
    {
        $this->rows[] = $row;
    }

    /**
     * Build html of content.
     *
     * @return string
     */
    public function build()
    {
        if (!empty($this->content)) {
            return $this->content;
        }
        try {
            $html = '';

            foreach ($this->rows as $row) {
                $html .= $row->render();
            }

            return $html;
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param  \Throwable  $e
     * @return mixed|string
     */
    protected function handleException(\Throwable $e)
    {
        $response = Admin::handleException($e);

        if (is_string($response) || $response instanceof Renderable) {
            $row = new Row($response);

            return $row->render();
        }

        return $response;
    }

    /**
     * Set success message for content.
     *
     * @param  string  $title
     * @param  string  $message
     * @return $this
     */
    public function withSuccess($title = '', $message = '')
    {
        admin_success($title, $message);

        return $this;
    }

    /**
     * Set error message for content.
     *
     * @param  string  $title
     * @param  string  $message
     * @return $this
     */
    public function withError($title = '', $message = '')
    {
        admin_error($title, $message);

        return $this;
    }

    /**
     * Set warning message for content.
     *
     * @param  string  $title
     * @param  string  $message
     * @return $this
     */
    public function withWarning($title = '', $message = '')
    {
        admin_warning($title, $message);

        return $this;
    }

    /**
     * Set info message for content.
     *
     * @param  string  $title
     * @param  string  $message
     * @return $this
     */
    public function withInfo($title = '', $message = '')
    {
        admin_info($title, $message);

        return $this;
    }

    public function view(?string $view) : Content
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @param  string|array  $key
     * @param  mixed  $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->variables = array_merge($this->variables, $key);
        } else {
            $this->variables[$key] = $value;
        }

        return $this;
    }

    /**
     * @param  string|array  $key
     * @param  mixed  $value
     * @return $this
     */
    public function withConfig($key, $value = null)
    {
        if (is_array($key)) {
            $this->config = array_merge($this->config, $key);
        } else {
            $this->config[$key] = $value;
        }

        return $this;
    }

    /**
     * @return void
     */
    protected function shareDefaultErrors()
    {
        if (! session()->all()) {
            view()->share(['errors' => new ViewErrorBag()]);
        }
    }

    /**
     * @return array
     */
    protected function variables()
    {
        return array_merge([
            'header'          => $this->title,
            'description'     => $this->description,
            'helpTopic'       => $this->helpTopic,
            'breadcrumb'      => $this->breadcrumb,
            'layout'          => $this->applyConfig(),
            'pjaxContainerId' => Admin::getPjaxContainerId(),
        ], $this->variables);
    }

    /**
     * @return array
     */
    protected function applyConfig()
    {
        $data = array_merge(config('admin.layout'), $this->config);

        return collect($data)->mapWithKeys(function($value, $key) {

            if ($value instanceof \Dcat\Admin\DcatEnum) {
                $value = $value->value;
            }

            return [$key => $value];
        })->toArray();
    }

    /**
     * Render this content.
     *
     * @return string
     */
    public function render()
    {
        $this->callComposing();
        $this->shareDefaultErrors();

        $this->variables['content'] = $this->build();

        $this->callComposed();

        if (Admin::shouldPrevent()) {
            return Admin::renderContents();
        }

        return view($this->view, $this->variables())->render();
    }

    /**
     * Register a composed event.
     *
     * @param  callable  $callback
     * @param  bool  $once
     */
    public static function composed(callable $callback, bool $once = false)
    {
        static::addBuilderListeners('builder.composed', $callback, $once);
    }

    /**
     * Call the composed callbacks.
     *
     * @param  array  ...$params
     */
    protected function callComposed(...$params)
    {
        $this->fireBuilderEvent('builder.composed', ...$params);
    }
}
