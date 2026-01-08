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

            let customers = [];

            function render() {
                $('#online-users').empty();

                customers.forEach(function(user) {
                    $('#online-users').append(
                        '<li id="user-' + user.id + '">' + user.name + '</li>'
                    );
                });

                $('#online-count').text(customers.length);
            }

            Echo.join('active-users')
                .here(function(users) {
                    customers = users.filter(function(user) {
                        return user.role === 'customer';
                    });

                    render();
                })
                .joining(function(user) {
                    if (user.role !== 'customer') {
                        return;
                    }

                    customers.push(user);
                    render();
                })
                .leaving(function(user) {
                    customers = customers.filter(function(u) {
                        return u.id !== user.id;
                    });

                    render();
                });

        });
    </script>
@endpush
