<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Task - TaskFlow</title>
    <link rel="stylesheet" href="{{ asset('css/all_tasks.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
    <link rel="stylesheet" href="{{ asset('css/searchResults.css') }}">
</head>
<body>

<script>
    document.documentElement.dataset.theme = localStorage.getItem('taskflow-theme') || 'light';
</script>

<div class="app">

    <aside class="nav-sidebar">

    <div class="nav-logo">
        <h1>TaskFlow</h1>
    </div>

    <nav class="nav-links">
        <a href="{{ route('tasks.index') }}" class="nav-link">
            <span class="nav-icon">⌂</span>
            Dashboard
        </a>

        <a href="{{ route('tasks.all') }}" class="nav-link active">
            <span class="nav-icon">☷</span>
            All Tasks
        </a>
    </nav>
    </aside>

    <main class="content">

        <header class="topbar">

           <div class="search-bar">
                <span class="search-icon">⌕</span>
                <input type="text" id="globalSearch" placeholder="Search tasks..." autocomplete="off">
                <div id="searchResults" class="search-results"></div>
            </div>

            <button id="themeToggle" class="theme-button" type="button" aria-label="Toggle theme">☼</button>

        </header>

        <section class="edit-page">

            <div class="edit-header">
                <a href="{{ route('tasks.all') }}" class="back-link">← Back to All Tasks</a>
                <h2>{{ $task->task_name }}</h2>
                <p>View task information</p>
            </div>

            <div class="task-view">

                <div class="task-view-header">
                    <div>
                        <span class="task-view-label">Task</span>
                        <h3>{{ $task->task_name }}</h3>
                    </div>

                    <span class="status-badge {{ $task->status }}">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>

                <div class="task-view-section">
                    <span class="task-view-label">Description</span>
                    <p>{{ $task->description ?: 'No description provided.' }}</p>
                </div>

                <div class="task-view-details">

                    <div>
                        <span class="task-view-label">Due Date</span>
                        <strong>
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No due date' }}
                        </strong>
                    </div>

                    <div>
                        <span class="task-view-label">Created</span>
                        <strong>{{ $task->created_at->format('M d, Y') }}</strong>
                    </div>

                    <div>
                        <span class="task-view-label">Last Updated</span>
                        <strong>{{ $task->updated_at->format('M d, Y') }}</strong>
                    </div>

                </div>

                <div class="task-view-actions">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="save-button">Edit Task</a>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cancel-button">Delete Task</button>
                    </form>
                </div>

            </div>

        </section>

    </main>

</div>

<script src="{{ asset('js/darkmode.js') }}"></script>
<script src="{{ asset('js/searchResults.js') }}"></script>
</body>
</html>