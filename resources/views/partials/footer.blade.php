<footer class="footer {{ $layout['footer_class'] }} mb-4">
    <div class="container-fluid d-flex flex-md-row flex-column justify-content-between align-items-md-center gap-1 container-p-x py-3">
        <div>
            {!! Dcat\Admin\Admin::footer()->render(Dcat\Admin\Enums\ElementPositionType::START) !!}
        </div>
        <div>
            {!! Dcat\Admin\Admin::footer()->render(Dcat\Admin\Enums\ElementPositionType::END) !!}
        </div>
    </div>
</footer>
