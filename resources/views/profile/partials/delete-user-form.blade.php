<section class="space-y-6">
    <header class="mb-6">
        <h2 class="text-xl font-bold" style="color: #ef4444;">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm" style="color: var(--col-subtle);">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        class="profile-btn profile-btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8" style="background: var(--col-surface); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 20px;">
            @csrf
            @method('delete')

            <div class="mb-6 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100/10 mb-4" style="color: #ef4444;">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold" style="color: var(--col-text);">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>
                <p class="mt-2 text-sm leading-relaxed" style="color: var(--col-subtle);">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div class="mt-6">
                <label for="password" class="profile-input-label sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="profile-input w-full"
                    placeholder="{{ __('Enter your password to confirm') }}"
                    autocomplete="current-password"
                />

                @if ($errors->userDeletion->get('password'))
                    <ul class="error-message">
                        @foreach ((array) $errors->userDeletion->get('password') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" class="profile-btn profile-btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="profile-btn profile-btn-danger">
                    {{ __('Permanently Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
