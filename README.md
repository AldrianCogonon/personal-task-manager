# PERSONAL TASK MANAGER
---
# PROJECT CODE
WST21-PM-2026-SF

# STUDENT NAME
Aldrian A. Cogonon

# Course & Year
BSIT - 2ND YEAR

# DATABASE USED 
MYSQL

# Features
* **ADD TASK**
* **VIEW TASKS**
* **EDIT TASK**
* **DELETE TASK**
* **UPDATE STATUS** 
* **SEARCH BAR**
* **DARK/LIGHT MODE**
* **TO-DO LIST**
---
# Dashboard
The Dashboard is the main page of my TaskFlow application. It gives the user a quick overview of their tasks and provides access to the main task management features. From this page, the user can see task statistics, pending tasks, recent tasks, search for tasks, filter tasks, change the theme, and create a new task.

<img src="screenshots/dashboard-light.png">
<img src="screenshots/dashboard-light-recent.png">
<img src="screenshots/dashboard-darkmode.png">
<img src="screenshots/dashboard-darkmode-recent.png">
## 1. SIDE BAR NAVIGATION
The sidebar is located on the left side of the Dashboard. It contains the TaskFlow logo and two navigation links.
- DASHBOARD: The Dashboard link takes the user to the main dashboard page
- ALL TASKS: The All Tasks link takes the user to the page containing the complete list of tasks.

## 2. Top Search Bar

The search bar is located at the top of the Dashboard. It allows the user to search for a specific task.

### How it works

1. The user types a task name in the search bar.
2. JavaScript detects the input.
3. JavaScript uses `fetch()` to send the search text to the Laravel search route.
4. Laravel receives the search request through the `tasks.search` route.
5. `TaskController@search` searches the `task_name` column in the database.
6. Laravel returns the matching tasks as JSON.
7. JavaScript receives the JSON response.
8. The matching task names are displayed below the search bar.
9. When the user clicks a result, the user is redirected to that task's View page.

The Controller searches using a `LIKE` query so that the search text can match part of a task name.

Example:

Searching for `laravel` can match:
- Laravel Exam
- Laravel Assignment
- Study Laravel Routing

## 3. Dark/Light Mode

The Dashboard includes a theme button on the top-right side of the screen.

The user can switch between:

- Light mode
- Dark mode

The theme is handled by JavaScript and CSS variables.

### How it works

1. JavaScript checks `localStorage` for the saved theme.
2. If no theme is saved, the default theme is light.
3. When the user clicks the theme button, JavaScript changes the theme.
4. The selected theme is saved in `localStorage`.
5. The HTML element receives either `data-theme="light"` or `data-theme="dark"`.
6. CSS changes the colors of the page based on the selected theme.

The saved theme is stored using the key:

`taskflow-theme`

This allows the selected theme to remain even after refreshing the page.

## 4. Dashboard Header

The Dashboard header contains the page title:

`Dashboard`

and the description:

`Stay on top of your tasks and deadlines.`

There is also an `+ Add Task` button.

The Add Task button sends the user to the Create Task page using the `tasks.create` route.

### Add Task flow

Click + Add Task
        ↓
tasks.create route
        ↓
TaskController@create
        ↓
create.blade.php
        ↓
Create Task form
The Dashboard therefore gives the user a direct way to create a new task.
### Task Statistics
The Dashboard contains three statistic cards:
- Total Tasks
The Dashboard uses: {{ $tasks->count() }}
This counts all tasks. For example, if there are 10 tasks in the database, the Dashboard displays: 10.
- Completed
The Dashboard uses: {{ $tasks->where('status', 'completed')->count() }}
First, it filters the tasks where the status is completed. Then it counts the results.
- Pending
The Dashboard uses: {{ $tasks->where('status', 'pending')->count() }}
This filters the tasks where the status is pending and then counts them.

**These values come from the $tasks collection that was retrieved by the Controller.**