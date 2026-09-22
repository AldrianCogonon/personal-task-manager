<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Personal Task Manager</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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

                <div class="sidebar-bottom">
                    <div class="user-profile">
                        <div class="avatar">
                            {{ strtoupper(substr(Auth::user()?->username ?? 'G', 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <span class="user-name">
                                {{ Auth::user()?->username ?? 'Guest' }}
                            </span>
                            <span class="user-role">
                                Personal Account
                            </span>
                        </div>
                    </div>
                </div>
            </aside>
            <section class="content">
                <header class="topbar">
                    <div class="search-bar">
                        <span class="search-icon">⌕</span>
                        <input type="text" placeholder="Search tasks...">
                    </div>
                    <div class="topbar-actions">
                        <button class="icon-button">
                            ☼
                        </button>
                        <div class="avatar">
                            {{ strtoupper(substr(Auth::user()?->username ?? 'G', 0, 1)) }}
                        </div>
                    </div>
                </header>
                <div class="page-header">
                    <div>
                        <h2>
                            Good Day,
                            {{ Auth::user()?->username ?? 'Guest' }}!
                        </h2>
                        <p>
                            Here's what you need to get done.
                        </p>
                    </div>
                    <a href="{{ route('tasks.all') }}" class="add-task-button">
                        + Add Task
                    </a>
                </div>
                <section class="task-stats">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            ☷
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">
                                Total Tasks
                            </span>
                            <strong>
                                {{ $tasks->count() }}
                            </strong>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            ◷
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">
                                Pending
                            </span>
                            <strong>
                                {{ $tasks->where('status', 'pending')->count() }}
                            </strong>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">
                            ✓
                        </div>
                        <div class="stat-content">
                            <span class="stat-label">
                                Completed
                            </span>
                            <strong>
                                {{ $tasks->where('status', 'completed')->count() }}
                            </strong>
                        </div>
                    </div>
                </section>
                <section class="tasks-section">
                    <div class="section-header">
                        <div>
                            <h3>Recent Tasks</h3>
                            <p>Your latest tasks</p>
                        </div>
                        <a href="{{ route('tasks.all') }}">
                            View all →
                        </a>
                    </div>
                    <div class="task-list">
                        @forelse($tasks->take(5) as $task)
                            <div class="task-row">
                                <div class="task-main">
                                    <div class="task-check {{ $task->status === 'completed' ? 'completed' : '' }}">
                                        @if($task->status === 'completed')
                                            ✓
                                        @endif
                                    </div>
                                    <div class="task-details">
                                        <h4>
                                            {{ $task->title }}
                                        </h4>
                                        <p>
                                            {{ $task->description ?? 'No description' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="task-date">
                                    @if(isset($task->due_date))
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    @else
                                        No date
                                    @endif
                                </div>
                                <span class="status {{ $task->status === 'completed' ? 'completed' : 'pending' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                                <div class="task-actions">
                                    <a href="{{ route('tasks.all') }}">
                                        ⋮
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    ✓
                                </div>
                                <h4>No tasks yet</h4>
                                <p>
                                    Create your first task to get started.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </section>
        </main>
    </body>
</html>