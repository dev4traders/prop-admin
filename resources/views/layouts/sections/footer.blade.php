@php
$containerFooter = ($configData['contentLayout'] === 'compact') ? 'container-xxl' : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }} d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
    {!! config('admin.footer.powered_by') !!}
    </div>
    <div  class="d-none d-lg-inline-block">
    {!! config('admin.footer.menu') !!}
    </div>
  </div>
</footer>
<!--/ Footer-->
