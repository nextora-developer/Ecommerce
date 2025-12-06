@extends('account.layout')

@section('account-breadcrumb', 'Account / Edit Profile')

@section('account-content')
    <div class="space-y-6">

        {{-- 1️⃣ 标题 --}}
        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
            <h1 class="text-xl font-semibold text-gray-900">
                Account settings
            </h1>
            <p class="mt-1 text-sm text-gray-600">
                Manage your basic information and password.
            </p>
        </div>

        {{-- 2️⃣ Profile 信息卡片 --}}
        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-6 shadow-sm">
            @if (session('status') === 'profile-updated')
                <div class="mb-4 rounded-lg bg-green-50 px-4 py-2 text-xs text-green-700">
                    Profile updated successfully.
                </div>
            @endif

            <h2 class="mb-4 text-sm font-semibold text-gray-900">Profile</h2>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5 max-w-xl">
                @csrf
                @method('PATCH')

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Name
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="block w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm
                           focus:border-rose-400 focus:ring-rose-400"
                        required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="block w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm
                           focus:border-rose-400 focus:ring-rose-400"
                        required>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="inline-flex items-center rounded-full bg-rose-500 px-5 py-2
                           text-sm font-semibold text-white shadow-sm hover:bg-rose-600
                           focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-1">
                        Save changes
                    </button>
                </div>
            </form>
        </div>

        {{-- 3️⃣ Change password 卡片 --}}
        <div class="rounded-2xl border border-gray-200 bg-white px-6 py-6 shadow-sm">
            @if (session('status') === 'password-updated')
                <div class="mb-4 rounded-lg bg-green-50 px-4 py-2 text-xs text-green-700">
                    Password updated successfully.
                </div>
            @endif

            <h2 class="mb-4 text-sm font-semibold text-gray-900">Change password</h2>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5 max-w-xl">
                @csrf
                @method('PUT')

                {{-- Current password --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Current password
                    </label>
                    <input type="password" name="current_password"
                        class="block w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm
                           focus:border-rose-400 focus:ring-rose-400"
                        autocomplete="current-password" required>
                    @error('current_password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New password --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        New password
                    </label>
                    <input type="password" name="password"
                        class="block w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm
                           focus:border-rose-400 focus:ring-rose-400"
                        autocomplete="new-password" required>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm password --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                        Confirm new password
                    </label>
                    <input type="password" name="password_confirmation"
                        class="block w-full rounded-xl border border-gray-200 px-3 py-2.5 text-sm
                           focus:border-rose-400 focus:ring-rose-400"
                        autocomplete="new-password" required>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="inline-flex items-center rounded-full bg-gray-900 px-5 py-2
                           text-sm font-semibold text-white shadow-sm hover:bg-black
                           focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-offset-1">
                        Update password
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
