<x-app-layout>
    <style>
        :root {
            --col-bg: #0d0f14;
            --col-surface: #151820;
            --col-border: #1e2330;
            --col-muted: #3a3f52;
            --col-text: #e4e8f5;
            --col-subtle: #6b7394;
            --accent: #4a9eff;
            --accent-dim: rgba(74, 158, 255, 0.15);
        }

        [data-theme="light"] {
            --col-bg: #caf0f8;
            --col-surface: #f0f9ff;
            --col-border: #e0e7ff;
            --col-muted: #64748b;
            --col-text: #03045e;
            --col-subtle: #475569;
            --accent: hsl(220, 90%, 45%);
            --accent-dim: hsla(220, 90%, 45%, 0.15);
        }

        .profile-wrapper {
            background: var(--col-bg);
            min-height: 100vh;
            color: var(--col-text);
            font-family: 'Inter', sans-serif;
            padding: 3rem 1rem;
            transition: background 0.3s ease;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .profile-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--col-text);
            margin-bottom: 0.5rem;
        }

        .profile-subtitle {
            color: var(--col-subtle);
            font-size: 1.1rem;
        }

        .profile-card {
            background: var(--col-surface);
            border: 1px solid var(--col-border);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            border-color: var(--accent);
            box-shadow: 0 15px 40px rgba(74, 158, 255, 0.1);
            transform: translateY(-2px);
        }

        .profile-input-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--col-subtle);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .profile-input {
            width: 100%;
            background: var(--col-bg);
            border: 1.5px solid var(--col-border);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            color: var(--col-text);
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .profile-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        .profile-btn {
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .profile-btn:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px var(--accent-dim);
        }

        .profile-btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .profile-btn-danger:hover {
            background: #ef4444;
            color: white;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.2);
        }

        .profile-btn-secondary {
            background: var(--col-surface);
            color: var(--col-text);
            border: 1px solid var(--col-border);
        }

        .profile-btn-secondary:hover {
            border-color: var(--col-muted);
            background: var(--col-border);
            box-shadow: none;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
    </style>

    <div class="profile-wrapper">
        <div class="max-w-4xl mx-auto">
            <div class="profile-header">
                <h2 class="profile-title">Account Settings</h2>
                <p class="profile-subtitle">Manage your personal information, security preferences, and data.</p>
            </div>

            <div class="space-y-6">
                <div class="profile-card">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="profile-card">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="profile-card" style="border-color: rgba(239, 68, 68, 0.3);">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
