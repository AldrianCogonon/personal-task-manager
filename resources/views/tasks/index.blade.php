<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script>
        document.documentElement.dataset.theme = localStorage.getItem('taskflow-theme') || 'light';
    </script>
</head>

<body>
    <main class="app">
        <aside class="nav-sidebar">
            <div class="nav-logo">
                <div class="logo-icon">✓</div>
                <h1>TaskFlow</h1>
            </div>

            <nav class="nav-links">
                <a href="{{ route('tasks.index') }}" class="nav-link active">
                    <span class="nav-icon">⌂</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('tasks.all') }}" class="nav-link">
                    <span class="nav-icon">☷</span>
                    <span>All Tasks</span>
                </a>
            </nav>
        </aside>

        <section class="content">
            <header class="topbar">
                <div class="search-bar">
                    <span class="search-icon">⌕</span>
                    <input id="globalSearch" type="text" placeholder="Search tasks..."  autocomplete="off">
                    <div id="searchResults" class="search-results"></div>
                </div>

                <button id="themeToggle" class="theme-button" type="button" aria-label="Toggle theme">
                    ☼
                </button>
            </header>

            <section class="dashboard">

                <div class="dashboard-header">
                    <div>
                        <h2>Dashboard</h2>
                        <p>Stay on top of your tasks and deadlines.</p>
                    </div>

                    <a href="{{ route('tasks.create') }}" class="add-task-button">
                        + Add Task
                    </a>
                </div>

                <div class="dashboard-grid">

                    <section class="stat-card">
                        <div class="stat-icon blue">☷</div>
                        <div>
                            <span class="stat-label">Total Tasks</span>
                            <strong>{{ $tasks->count() }}</strong>
                        </div>
                    </section>

                    <section class="stat-card">
                        <div class="stat-icon green">✓</div>
                        <div>
                            <span class="stat-label">Completed</span>
                            <strong>{{ $tasks->where('status', 'completed')->count() }}</strong>
                        </div>
                    </section>

                    <section class="stat-card">
                        <div class="stat-icon orange">◷</div>
                        <div>
                            <span class="stat-label">Pending</span>
                            <strong>{{ $tasks->where('status', 'pending')->count() }}</strong>
                        </div>
                    </section>

                    <section class="todo-card">
                        <div class="card-heading">
                            <div>
                                <h3>To Do List</h3>
                                <p>Pending tasks</p>
                            </div>
                            <span class="todo-count">{{ $pendingTasks->count() }}</span>
                        </div>

                        <div class="todo-list">
                            @forelse($pendingTasks as $task)
                                <div class="todo-item">
                                    <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="todo-check" type="submit" aria-label="Complete task"></button>
                                    </form>

                                    <div class="todo-content">
                                        <strong>{{ $task->task_name }}</strong>
                                        <span>
                                            {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="todo-empty">
                                    <span>✓</span>
                                    <p>No pending tasks</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                </div>

                <section class="recent-section">
                    <div class="recent-header">
                        <div>
                            <h3>Recent Tasks</h3>
                            <p>Your newest tasks and latest updates.</p>
                        </div>

                        <a href="{{ route('tasks.all') }}" class="view-all">
                            View all →
                        </a>
                    </div>

                    <div class="filter-bar">
                        <div class="filter-group">
                            <label for="statusFilter">Status</label>
                            <select id="statusFilter">
                                <option value="all">All</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="dateFilter">Date</label>
                            <select id="dateFilter">
                                <option value="all">All dates</option>
                                <option value="today">Today</option>
                                <option value="week">Next 7 days</option>
                                <option value="month">This month</option>
                                <option value="overdue">Overdue</option>
                                <option value="none">No due date</option>
                            </select>
                        </div>

                        <button id="clearFilters" class="clear-filter" type="button">
                            Clear filters
                        </button>
                    </div>

                    <div class="recent-list" id="recentList">
                        @forelse($tasks->take(10) as $task)
                            <article
                                class="recent-task"
                                data-status="{{ $task->status }}"
                                data-due-date="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}"
                                data-task-name="{{ strtolower($task->task_name) }}"
                                data-description="{{ strtolower($task->description ?? '') }}"
                            >
                                <div class="recent-task-info">
                                    <h4>{{ $task->task_name }}</h4>

                                    <p>
                                        {{ $task->description ?: 'No description provided.' }}
                                    </p>
                                </div>

                                <div class="recent-task-date">
                                    <span>Due</span>

                                    <strong>
                                        {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No date' }}
                                    </strong>
                                </div>

                                <span class="status-badge {{ $task->status }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </article>
                        @empty
                            <div class="recent-empty">
                                <div class="empty-icon">✓</div>
                                <h4>No tasks yet</h4>
                                <p>Create your first task to get started.</p>
                            </div>
                        @endforelse
                    </div>

                    <div id="filterEmpty" class="filter-empty" hidden>
                        <h4>No matching tasks</h4>
                        <p>Try changing your search or filters.</p>
                    </div>
                </section>

            </section>
        </section>
    </main>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/searchResults.js') }}"></script>
</body>

</html>