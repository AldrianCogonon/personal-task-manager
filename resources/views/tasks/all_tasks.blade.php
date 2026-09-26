<!DOCTYPE html>
    <html lang="en" data-theme="light" >

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>All Tasks - TaskFlow</title>
        <link rel="stylesheet" href="{{ asset('css/all_tasks.css') }}">
        <link rel="stylesheet" href="{{ asset('css/searchResults.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    </head>

    <body>

        <main class="app">

            <aside class="nav-sidebar">

                <div class="nav-logo">
                    <img
                        src="{{ asset('images/taskflow-logo.png') }}"
                        alt="TaskFlow Logo"
                        class="logo-image"
                    >

                    <h1>TaskFlow</h1>
                </div>

                <div class="logo-attribution">
                    <a
                        href="https://www.flaticon.com/free-icons/bird"
                        title="bird icons"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                    </a>
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

            </aside>

            <section class="content">

                <header class="topbar">

                    <div class="search-bar">
                        <span class="search-icon">⌕</span>

                        <input type="text" id="globalSearch" placeholder="Search tasks..." autocomplete="off">
                        <div id="searchResults" class="search-results"></div>
                    </div>

                    <button
                        id="themeToggle"
                        class="theme-button"
                        type="button"
                        aria-label="Toggle theme"
                    >
                        ☼
                    </button>

                </header>

                <div class="page-header">

                    <div>
                        <h2>All Tasks</h2>
                        <p>Manage and organize your tasks.</p>
                    </div>

                    <a href="{{ route('tasks.create') }}" class="add-task-button"> + Add Task</a>
                </div>

                <div class="tasks-toolbar">
                    <div class="task-filters">
                        <button class="filter-button active" data-filter="all" type="button">
                            All
                            <span>{{ $tasks->count() }}</span>
                        </button>

                        <button class="filter-button" data-filter="pending" type="button">
                            Pending
                            <span>
                                {{ $tasks->where('status', 'pending')->count() }}
                            </span>
                        </button>

                        <button
                            class="filter-button"
                            data-filter="completed"
                            type="button"
                        >
                            Completed
                            <span>
                                {{ $tasks->where('status', 'completed')->count() }}
                            </span>
                        </button>

                    </div>

                    <select
                        class="task-sort"
                        id="taskSort"
                    >
                        <option value="newest">
                            Newest first
                        </option>

                        <option value="oldest">
                            Oldest first
                        </option>

                        <option value="due">
                            Due date
                        </option>
                    </select>

                </div>

                <section class="all-tasks-container">

                    <div class="all-tasks-header">

                        <h3>Your Tasks</h3>

                        <p>
                            {{ $tasks->count() }}
                            {{ $tasks->count() === 1 ? 'task' : 'tasks' }}
                        </p>

                    </div>

                    <div class="all-task-list" id="taskList">
                        @forelse($tasks as $task)

                            <article
                                class="all-task-row"
                                data-status="{{ $task->status }}"
                                data-created="{{ $task->created_at->timestamp }}"
                                data-due="{{ $task->due_date ? $task->due_date->timestamp : 9999999999999 }}"
                            >

                                <div class="task-status-control">

                                    <form
                                        action="{{ route('tasks.updateStatus', $task->id) }}"
                                        method="POST"
                                    >

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

                                    <h4 class="{{ $task->status === 'completed' ? 'task-completed' : '' }}">{{ $task->task_name }}</h4>

                                    <p>
                                        {{ $task->description ?: 'No description provided.' }}
                                    </p>

                                    <div class="task-meta">

                                        @if($task->due_date)

                                            <span>
                                                ◷
                                                {{ $task->due_date->format('M d, Y') }}
                                            </span>

                                        @endif

                                        <span>
                                            Created {{ $task->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <span class="status {{ $task->status }}">{{ ucfirst($task->status) }}</span>
                                </div>

                                <div class="all-task-actions">

                                    <a href="{{ route('tasks.show', $task->id) }}" class="task-action" title="View task">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('tasks.edit', $task->id) }}" class="task-action" title="Edit task">
                                       <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form
                                        action="{{ route('tasks.destroy', $task->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this task?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="task-action"
                                            title="Delete task"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </article>

                        @empty

                            <div class="empty-state">

                                <div class="empty-icon">
                                    ✓
                                </div>

                                <h4>No tasks yet</h4>

                                <p>Create your first task to get started.</p>

                                <a href="{{ route('tasks.create') }}" class="add-task-button">+ Create Task</a>

                            </div>
                        @endforelse
                    </div>
                </section>
            </section>
        </main>
        <script src="{{ asset('js/searchResults.js') }}"></script>
        <script src="{{ asset('js/darkmode.js') }}"></script>
    </body> 
    </html>