<?php

namespace Dcat\Admin\Board;

use Closure;
use Dcat\Admin\Admin;
use Dcat\Admin\Board\Field;
use Dcat\Admin\Board\Row;
use Dcat\Admin\Contracts\ModelHolder;
use Dcat\Admin\Contracts\Repository;
use Dcat\Admin\Contracts\ShowField;
use Dcat\Admin\Traits\HasBuilderEvents;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Illuminate\Support\Traits\Macroable;

class Board implements Renderable, ModelHolder, ShowField
{
    use HasBuilderEvents;
    use Macroable {
            __call as macroCall;
        }

    /**
     * @var string
     */
    protected $view = 'admin::board.panel';

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var mixed
     */
    protected $_id;

    /**
     * @var string
     */
    protected $keyName = 'id';

    /**
     * @var Fluent
     */
    protected $model;

    /**
     * Show panel builder.
     *
     * @var callable
     */
    protected $builder;

    /**
     * Resource path for this show page.
     *
     * @var string
     */
    protected $resource;

    /**
     * Fields to be show.
     *
     * @var Collection
     */
    protected $fields;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $rows;

    /**
     * Show constructor.
     *
     * @param  mixed  $id  $id
     * @param  Model|Builder|Repository|array|Arrayable  $model
     * @param  \Closure  $builder
     */
    public function __construct($id = null, $model = null, ?\Closure $builder = null)
    {
        switch (func_num_args()) {
            case 1:
            case 2:
                if (is_scalar($id)) {
                    $this->setKey($id);
                } else {
                    $builder = $model;
                    $model = $id;
                }
                break;
            default:
                $this->setKey($id);
        }
        $this->rows = new Collection();
        $this->builder = $builder;

        $this->initModel($model);

        $this->initContents();

        $this->callResolving();
    }

    protected function initModel($model)
    {
        if ($model instanceof Repository || $model instanceof Builder) {
            $this->repository = Admin::repository($model);
        } elseif ($model instanceof Model) {
            if ($key = $model->getKey()) {
                $this->setKey($key);
                $this->setKeyName($model->getKeyName());

                $this->model($model);
            } else {
                $this->repository = Admin::repository($model);
            }
        } elseif ($model instanceof Arrayable) {
            $this->model(new Fluent($model->toArray()));
        } elseif (is_array($model)) {
            $this->model(new Fluent($model));
        } else {
            $this->model(new Fluent());
        }

        if (! $this->model && $this->repository) {
            //$this->model($this->repository->detail($this));
            //todo::fix
        }
    }

    /**
     * Create a show instance.
     *
     * @param  mixed  ...$params
     * @return $this
     */
    public static function make(...$params)
    {
        return new static(...$params);
    }

    /**
     * @param  string  $value
     * @return $this
     */
    public function setKeyName(string $value)
    {
        $this->keyName = $value;

        return $this;
    }

    /**
     * Get primary key name of model.
     *
     * @return string
     */
    public function getKeyName()
    {
        if (! $this->repository) {
            return $this->keyName;
        }

        return $this->keyName ?: $this->repository->getKeyName();
    }

    /**
     * @param  mixed  $id
     * @return mixed
     */
    public function setKey($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->_id;
    }

    /**
     * @param  Fluent|\Illuminate\Database\Eloquent\Model|null  $model
     * @return Fluent|$this|\Illuminate\Database\Eloquent\Model
     */
    public function model($model = null)
    {
        if ($model === null) {
            return $this->model;
        }

        if (is_array($model)) {
            $model = new Fluent($model);
        }

        $this->model = $model;

        return $this;
    }

    /**
     * Initialize the contents to show.
     */
    protected function initContents()
    {
        $this->fields = new Collection();
    }

    /**
     * Add a model field to show.
     *
     * @param  string  $name
     * @param  string  $label
     * @return Field
     */
    public function field($name, $label = '')
    {
        return $this->addField($name, $label);
    }

    /**
     * Get fields or add multiple fields.
     *
     * @param  array  $fields
     * @return $this|Collection
     */
    public function fields(array $fields = null)
    {
        if ($fields === null) {
            return $this->fields;
        }

        if (! Arr::isAssoc($fields)) {
            $fields = array_combine($fields, $fields);
        }

        foreach ($fields as $field => $label) {
            $this->field($field, $label);
        }

        return $this;
    }

    /**
     * Show all fields.
     *
     * @return Show
     */
    public function all()
    {
        $fields = array_keys($this->model()->toArray());

        return $this->fields($fields);
    }

    /**
     * Add a model field to show.
     *
     * @param  string  $name
     * @param  string  $label
     * @return Field
     */
    protected function addField($name, $label = '')
    {
        $field = new Field($name, $label);

        $field->setParent($this);

        $this->overwriteExistingField($name);

        $this->fields->push($field);

        return $field;
    }

    /**
     * Overwrite existing field.
     *
     * @param  string  $name
     */
    protected function overwriteExistingField($name)
    {
        if ($this->fields->isEmpty()) {
            return;
        }

        $this->fields = $this->fields->filter(
            function (Field $field) use ($name) {
                return $field->getName() != $name;
            }
        );
    }

    /**
     * @return Repository
     */
    public function repository()
    {
        return $this->repository;
    }

    /**
     * @return string
     */
    public function resource()
    {
        if (empty($this->resource)) {
            $path = request()->path();

            $segments = explode('/', $path);
            array_pop($segments);

            $this->resource = url(implode('/', $segments));
        }

        return $this->resource;
    }

    /**
     * Set resource path.
     *
     * @param  string  $path
     * @return $this
     */
    public function setResource($path)
    {
        if ($path) {
            $this->resource = admin_url($path);
        }

        return $this;
    }

    /**
     * Add field and relation dynamically.
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return Field
     */
    public function __call($method, $arguments = [])
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $arguments);
        }

        return $this->call($method, $arguments);
    }

    /**
     * Render the show panels.
     *
     * @return string
     */
    public function render()
    {
        $model = $this->model();

        if (is_callable($this->builder)) {
            call_user_func($this->builder, $this);
        }

        if ($this->fields->isEmpty()) {
            $this->all();
        }

        if (is_array($this->builder)) {
            $this->fields($this->builder);
        }

        $this->fields->each->fill($model);

        $this->callComposing();

        $data = [
            'fields'     => $this->fields,
            'rows'     => $this->rows,
        ];

        return view($this->view, $data)->render();
    }

    /**
     * Add a row in Show.
     *
     * @param  Closure  $callback
     * @return $this
     */
    public function row(Closure $callback)
    {
        $this->rows->push(new Row($callback, $this));

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function rows()
    {
        return $this->rows;
    }

    /**
     * Add a model field to show.
     *
     * @param  string  $name
     * @return Field|Collection
     */
    public function __get($name)
    {
        return $this->call($name);
    }
}
