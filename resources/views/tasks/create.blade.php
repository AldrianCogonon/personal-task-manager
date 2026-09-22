
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task - TaskFlow</title>
    <link rel="stylesheet" href="{{ asset('css/create_tasks.css') }}">
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
                        <span class="user-role">Personal Account</span>
                    </div>
                </div>
            </div>
        </aside>

        <section class="content">
            <header class="topbar">
                <div></div>

                <div class="topbar-actions">
                    <button class="icon-button">☼</button>

                    <div class="avatar">
                        {{ strtoupper(substr(Auth::user()?->username ?? 'G', 0, 1)) }}
                    </div>
                </div>
            </header>

            <div class="page-header">
                <div>
                    <a href="{{ route('tasks.all') }}" class="back-link">
                        ← Back to All Tasks
                    </a>

                    <h2>Create Task</h2>
                    <p>Add a new task to your task list.</p>
                </div>
            </div>

            <div class="create-task-wrapper">
                <div class="create-task-card">
                    <div class="form-header">
                        <h3>Task Details</h3>
                        <p>Fill in the information below to create your task.</p>
                    </div>

                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="task_name">Task Name</label>

                            <input
                                type="text"
                                id="task_name"
                                name="task_name"
                                value="{{ old('task_name') }}"
                                placeholder="Enter task name"
                                required
                            >

                            @error('task_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>

                            <textarea
                                id="description"
                                name="description"
                                placeholder="Describe what needs to be done..."
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="due_date">Due Date</label>

                                <input
                                    type="date"
                                    id="due_date"
                                    name="due_date"
                                    value="{{ old('due_date') }}"
                                >

                                @error('due_date')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>

                                <select id="status" name="status">
                                    <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                </select>

                                @error('status')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('tasks.all') }}" class="cancel-button">
                                Cancel
                            </a>

                            <button type="submit" class="create-button">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
