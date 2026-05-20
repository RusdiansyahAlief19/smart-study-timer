<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold" style="color: var(--col-text);">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm" style="color: var(--col-subtle);">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="profile-input-label">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="profile-input" autocomplete="current-password" />
            @if ($errors->updatePassword->get('current_password'))
                <ul class="error-message">
                    @foreach ((array) $errors->updatePassword->get('current_password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="profile-input-label">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="profile-input" autocomplete="new-password" />
            @if ($errors->updatePassword->get('password'))
                <ul class="error-message">
                    @foreach ((array) $errors->updatePassword->get('password') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="profile-input-label">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="profile-input" autocomplete="new-password" />
            @if ($errors->updatePassword->get('password_confirmation'))
                <ul class="error-message">
                    @foreach ((array) $errors->updatePassword->get('password_confirmation') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="profile-btn">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium"
                    style="color: var(--accent);"
                >{{ __('Saved successfully.') }}</p>
            @endif
        </div>
    </form>
</section>
