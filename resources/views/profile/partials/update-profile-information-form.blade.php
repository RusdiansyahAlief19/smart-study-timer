<section>
    <header class="mb-6">
        <h2 class="text-xl font-bold" style="color: var(--col-text);">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm" style="color: var(--col-subtle);">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="profile-input-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="profile-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @if ($errors->get('name'))
                <ul class="error-message">
                    @foreach ((array) $errors->get('name') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div>
            <label for="email" class="profile-input-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="profile-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @if ($errors->get('email'))
                <ul class="error-message">
                    @foreach ((array) $errors->get('email') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 rounded-xl" style="background: var(--col-bg); border: 1px solid var(--col-border);">
                    <p class="text-sm" style="color: var(--col-subtle);">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="text-sm font-semibold hover:underline" style="color: var(--accent); background: none; border: none; padding: 0; cursor: pointer; margin-left: 0.5rem;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-500">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="profile-btn">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
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
