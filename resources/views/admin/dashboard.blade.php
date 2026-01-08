@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </div>
    </header>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">

        <div class="bg-white shadow sm:rounded-lg p-6 mb-6">
            You're logged in!
        </div>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <h3 class="text-lg font-bold mb-2">Active Users</h3>

            <p>
                Total Online:
                <span id="online-count">0</span>
            </p>

            <ul id="online-users" class="list-disc ml-6 mt-2"></ul>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            if (typeof Echo === 'undefined') {
                return;
            }

            Echo.join('active-users')
                .here(function(users) {
                    $('#online-count').text(users.length);
                    $('#online-users').empty();

                    users.forEach(function(user) {
                        let roleText = user.role === 'admin' ? 'Admin' : 'Customer';

                        $('#online-users').append(
                            '<li id="user-' + user.id + '">' + user.name + ' (' + roleText +
                            ')</li>'
                        );
                    });
                })
                .joining(function(user) {
                    let count = Number($('#online-count').text()) || 0;
                    $('#online-count').text(count + 1);

                    let roleText = user.role === 'admin' ? 'Admin' : 'Customer';

                    $('#online-users').append(
                        '<li id="user-' + user.id + '">' + user.name + ' (' + roleText + ')</li>'
                    );
                })
                .leaving(function(user) {
                    let count = Number($('#online-count').text()) || 0;
                    $('#online-count').text(count > 0 ? count - 1 : 0);

                    $('#user-' + user.id).remove();
                });

        });
    </script>
@endpush
