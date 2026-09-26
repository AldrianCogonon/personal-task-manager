<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task - TaskFlow</title>
    <link rel="stylesheet" href="{{ asset('css/all_tasks.css') }}">
    <link rel="stylesheet" href="{{ asset('css/searchResults.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <script>
        document.documentElement.dataset.theme = localStorage.getItem('taskflow-theme') || 'light';
    </script>
</head>

<body>

    <main class="app">

        <aside class="nav-sidebar">
            <div class="nav-logo">
                <div class="logo-wrapper">
                    <img
                        src="{{ asset('images/taskflow-logo.png') }}"
                        alt="TaskFlow Logo"
                        class="logo-image"
                    >
                </div>
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

            <section class="edit-page">

                <div class="edit-header">
                    <a href="{{ route('tasks.all') }}" class="back-link">
                        ← Back to All Tasks
                    </a>

                    <h2>Edit Task</h2>

                    <p>
                        Update your task information.
                    </p>
                </div>

                <form
                    action="{{ route('tasks.update', $task->id) }}"
                    method="POST"
                    class="edit-form"
                >
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="form-errors">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="task_name">Task Name</label>

                        <input
                            type="text"
                            id="task_name"
                            name="task_name"
                            value="{{ old('task_name', $task->task_name) }}"
                            placeholder="Enter task name"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>

                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            placeholder="Enter task description"
                        >{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="form-row">

                        <div class="form-group">
                            <label for="due_date">Due Date</label>

                            <input
                                type="date"
                                id="due_date"
                                name="due_date"
                                value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}"
                            >
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>

                            <select id="status" name="status">
                                <option
                                    value="pending"
                                    {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="completed"
                                    {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}
                                >
                                    Completed
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="edit-actions">
                        <a
                            href="{{ route('tasks.all') }}"
                            class="cancel-button"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="save-button"
                        >
                            Save Changes
                        </button>
                    </div>

                </form>

            </section>
        </section>

    </main>

<script src="{{ asset('js/darkmode.js') }}"></script>
<script src="{{ asset('js/searchResults.js') }}"></script>

</body>

</html>