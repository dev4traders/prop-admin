<?php

namespace Dcat\Admin\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Support\Helper;
use Illuminate\Routing\Controller;
use Dcat\Admin\Models\ControllerHelpTopic;

class AdminController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title;

    /**
     * Set translation path.
     *
     * @var string
     */
    protected $translation;

    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return $this->title ?: admin_trans_label('title');
    }

    /**
     * Get content description.
     *
     * @return string
     */
    protected function description()
    {
        $description = admin_trans_label('description');

        if( $description === 'description' ) {
            return '';
        }

        return $description;
    }

    protected function helpTopic() : string
    {
        if(!ControllerHelpTopic::docsEnabled())
            return '';

        $name = Helper::getControllerName();

        //dd($name);
        $item = ControllerHelpTopic::where('controller_name', $name)->first();

        $str = '';
        if(!is_null($item)) {
            $str = '<a target="_blank" style="font-size:small" href="'.$item->url.'">'.__('admin.need_help').'<i class="fa feather icon-help-circle"></i></a>';
        }

        // if(Admin::user()->isAdministrator()) {
        //     $modal = new Modal();
        //     $modal->title(__('admin.set_help_topic'));
        //     $modal->lg()->button('<button class="btn btn-white"><i class="feather icon-help"></i>'.__('admin.set_help_topic').'</button>');
        //     $modal->body(new DialogTable(new ControllerHelpTopicForm()));

        //     $str .= $modal;
        // }

        return $str;
    }

    /**
     * Get translation path.
     *
     * @return string
     */
    protected function translation()
    {
        return $this->translation;
    }

    /**
     * Index interface.
     *
     * @param  Content  $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->description($this->description())
            ->helpTopic($this->helpTopic())
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param  mixed  $id
     * @param  Content  $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->helpTopic($this->helpTopic())
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param  mixed  $id
     * @param  Content  $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->helpTopic($this->helpTopic())
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param  Content  $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->translation($this->translation())
            ->title($this->title())
            ->helpTopic($this->helpTopic())
            ->body($this->form());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        return $this->form()->update($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store()
    {
        return $this->form()->store();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->form()->destroy($id);
    }
}
