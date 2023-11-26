<div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
                <a href="{{url('/')}}" class="app-brand-link gap-2">
                    <span class="app-brand-logo">
                        <img src="{!! config('admin.logo-image') !!}" alt="" class="app-brand-img w-px-150" data-app-light-img="{!! config('admin.logo-image') !!}" data-app-dark-img="{!! config('admin.logo-image-dark') !!}">
                    </span>
                    <span class="app-brand-text text-body fw-bold">{{config('admin.name')}}</span>
                </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">{{ __('admin.welcome') }}</h4>
            <p class="mb-4">{{ __('admin.please_sign_in') }}</p>

            <form id="formAuthentication" class="mb-3" action="{{ admin_route(\Dcat\Admin\Enums\RouteAuth::LOGIN()) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="mb-3 form-label-group form-group">
                <label for="username" class="form-label">{{ __('admin.email_or_username') }}</label>
                <input
                    type="text"
                    class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                    id="username"
                    name="username"
                    placeholder="{{ __('admin.email_or_username') }}"
                    autofocus
                    required
                    value="{{ old('username') }}"
                />
                <div class="help-block with-errors"></div>
            </div>
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                <label class="form-label" for="password">{{ trans('admin.password') }}</label>
                @if(config('admin.auth.allow-reset-password'))
                <a href="{{ admin_route(\Dcat\Admin\Enums\RouteAuth::FORGOT_PASSWORD()) }}">
                    <small>{{ __('admin.forgot_password') }}</small>
                </a>
                @endif
                </div>
                <div class="input-group input-group-merge">
                    <input
                        type="password"
                        id="password"
                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        required
                        autocomplete="current-password"
                        aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                {{ __('admin.remember_me') }}
                </label>
                </div>
            </div>
            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">{{ __('admin.sign_in') }}</button>
            </div>
            </form>

            @if(config('admin.auth.allow-register'))
            <p class="text-center">
            <span>{{ __('admin.new_on_platform') }}</span>
            <a href="{{ admin_route(\Dcat\Admin\Enums\RouteAuth::REGISTER()) }}">
                <span>{{ __('admin.create_account') }}</span>
            </a>
            </p>
            @endif

            @if(config('admin.auth.allow-socials'))
            <div class="divider my-4">
                <div class="divider-text">{{ __('admin.or') }}</div>
            </div>
            <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                <i class="tf-icons bx bxl-facebook"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                <i class="tf-icons bx bxl-google-plus"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                <i class="tf-icons bx bxl-twitter"></i>
            </a>
            </div>
            @endif
        </div>
        </div>
    </div>
</div>
<script>
    Dcat.ready(function () {
        $('#formAuthentication').form({
            validate: true,
        });
    });
</script>
