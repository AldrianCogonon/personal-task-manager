
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tasks - TaskFlow</title>
    <link rel="stylesheet" href="{{ asset('css/all_tasks.css') }}">
</head>

<body>
    <main class="app">
        <aside class="nav-sidebar">
            <div class="nav-logo">
                <div class="logo-icon">✓</div>
                <h1>TaskFlow</h1>
            </div>

            <nav class="nav-links">
                <a href="{{ route('tasks.index') }}" class="nav-link">
                    <span class="nav-icon">⌂</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('tasks.all') }}" class="nav-link active">
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
                        <span class="user-role">Personal Account</span>
                    </div>
                </div>
            </div>
        </aside>

        <section class="content">
            <header class="topbar">
                <div class="search-bar">
                    <span class="search-icon">⌕</span>
                    <input type="text" id="taskSearch" placeholder="Search tasks...">
                </div>

                <div class="topbar-actions">
                    <button class="icon-button">☼</button>
                    <div class="avatar">
                        {{ strtoupper(substr(Auth::user()?->username ?? 'G', 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="page-header">
                <div>
                    <h2>All Tasks</h2>
                    <p>Manage and organize your tasks.</p>
                </div>

                <a href="{{ route('tasks.create') }}" class="add-task-button">
                    + Add Task
                </a>
            </div>

            <div class="tasks-toolbar">
                <div class="task-filters">
                    <button class="filter-button active" data-filter="all">
                        All
                        <span>{{ $tasks->count() }}</span>
                    </button>

                    <button class="filter-button" data-filter="pending">
                        Pending
                        <span>{{ $tasks->where('status', 'pending')->count() }}</span>
                    </button>

                    <button class="filter-button" data-filter="completed">
                        Completed
                        <span>{{ $tasks->where('status', 'completed')->count() }}</span>
                    </button>
                </div>

                <select class="task-sort" id="taskSort">
                    <option value="newest">Newest first</option>
                    <option value="oldest">Oldest first</option>
                </select>
            </div>

            <section class="all-tasks-container">
                <div class="all-tasks-header">
                    <div>
                        <h3>Your Tasks</h3>
                        <p>
                            {{ $tasks->count() }}
                            {{ $tasks->count() === 1 ? 'task' : 'tasks' }}
                        </p>
                    </div>
                </div>

                <div class="all-task-list" id="taskList">
                    @forelse($tasks as $task)
                        <article class="all-task-row" data-status="{{ $task->status }}">
                            <div class="task-status-control">
                                <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="task-check {{ $task->status === 'completed' ? 'completed' : '' }}"
                                        title="Update status"
                                    >
                                        @if($task->status === 'completed')
                                            ✓
                                        @endif
                                    </button>
                                </form>
                            </div>

                            <div class="all-task-info">
                                <h4 class="{{ $task->status === 'completed' ? 'task-completed' : '' }}">
                                    {{ $task->title }}
                                </h4>

                                <p>
                                    {{ $task->description ?? 'No description provided.' }}
                                </p>

                                <div class="task-meta">
                                    @if(isset($task->due_date))
                                        <span>
                                            ◷
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                        </span>
                                    @endif

                                    <span>
                                        Created {{ $task->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <span class="status {{ $task->status === 'completed' ? 'completed' : 'pending' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </div>

                            <div class="all-task-actions">
                                <a
                                    href="{{ route('tasks.edit', $task->id) }}"
                                    class="task-action edit"
                                    title="Edit task"
                                >
                                    ✎
                                </a>

                                <form
                                    action="{{ route('tasks.destroy', $task->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="task-action delete"
                                        title="Delete task"
                                    >
                                        ×
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">✓</div>
                            <h4>No tasks yet</h4>
                            <p>Create your first task to get started.</p>

                            <a href="{{ route('tasks.create') }}" class="add-task-button">
                                + Create Task
                            </a>
                        </div>
                    @endforelse
                </div>
            </section>
        </section>
    </main>

    <script>
        const filterButtons = document.querySelectorAll('.filter-button');
        const taskRows = document.querySelectorAll('.all-task-row');
        const searchInput = document.getElementById('taskSearch');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                const filter = button.dataset.filter;

                taskRows.forEach(task => {
                    task.style.display =
                        filter === 'all' || task.dataset.status === filter
                            ? 'grid'
                            : 'none';
                });
            });
        });

        searchInput.addEventListener('input', () => {
            const search = searchInput.value.toLowerCase();

            taskRows.forEach(task => {
                task.style.display =
                    task.textContent.toLowerCase().includes(search)
                        ? 'grid'
                        : 'none';
            });
        });
    </script>
</body>

</html>

