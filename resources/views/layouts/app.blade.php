<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Budgetly')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="nav-container">
            <a class="brand" href="{{ route('dashboard') }}">
                <span class="brand-icon">B</span>
                <span>Budgetly</span>
            </a>

            @auth
                <nav class="main-nav">
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('transactions.index') }}"
                       class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                        Transactions
                    </a>

                    <a href="{{ route('categories.index') }}"
                       class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        Categories
                    </a>
                </nav>

                <div class="nav-user">
                    <span class="user-name">{{ auth()->user()->name }}</span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">
                            Log out
                        </button>
                    </form>
                </div>
            @else
                <nav class="main-nav">
                    <a href="{{ route('login') }}">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        Get started
                    </a>
                </nav>
            @endauth
        </div>
    </header>

    <main class="container page-container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div id="ajax-notice" class="alert alert-success" role="status" hidden></div>

        @yield('content')
    </main>

    <footer class="site-footer">
        <p>Budgetly &copy; {{ date('Y') }} · Take control of your finances.</p>
    </footer>

    <script>
        // Delete transactions using AJAX without reloading the page.
        document.addEventListener('submit', async function (event) {
            const form = event.target.closest('form[data-ajax-delete]');

            if (!form) {
                return;
            }

            event.preventDefault();

            if (!confirm('Are you sure you want to delete this transaction?')) {
                return;
            }

            const button = form.querySelector('button[type="submit"]');
            const row = form.closest('[data-transaction-row]');
            const notice = document.getElementById('ajax-notice');

            if (button) {
                button.disabled = true;
                button.textContent = 'Deleting...';
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const contentType = response.headers.get('content-type') || '';

                if (!contentType.includes('application/json')) {
                    throw new Error('The server returned an unexpected response. Please refresh and try again.');
                }

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Unable to delete the transaction.');
                }

                if (row) {
                    row.remove();
                }

                notice.textContent = data.message || 'Transaction deleted successfully.';
                notice.hidden = false;

                const remainingRows = document.querySelectorAll('[data-transaction-row]');

                if (remainingRows.length === 0) {
                    const tbody = document.querySelector('#transactions-table tbody');

                    if (tbody) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="6" class="empty-state">
                                    No transactions found.
                                </td>
                            </tr>
                        `;
                    }
                }
            } catch (error) {
                notice.textContent = error.message || 'Something went wrong.';
                notice.classList.remove('alert-success');
                notice.classList.add('alert-error');
                notice.hidden = false;

                if (button) {
                    button.disabled = false;
                    button.textContent = 'Delete';
                }
            }
        });

        // Show only categories matching the selected transaction type.
        function filterTransactionCategories() {
            const typeSelect = document.querySelector('[data-category-type-filter]');
            const categorySelect = document.querySelector('[data-category-select]');

            if (!typeSelect || !categorySelect) {
                return;
            }

            const selectedType = typeSelect.value;
            let selectedOptionAvailable = false;

            Array.from(categorySelect.options).forEach(function (option) {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }

                const matches = option.dataset.type === selectedType;
                option.hidden = !matches;

                if (matches && option.selected) {
                    selectedOptionAvailable = true;
                }
            });

            if (!selectedOptionAvailable) {
                categorySelect.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', filterTransactionCategories);

        document.addEventListener('change', function (event) {
            if (event.target.matches('[data-category-type-filter]')) {
                filterTransactionCategories();
            }
        });
    </script>
</body>
</html>
