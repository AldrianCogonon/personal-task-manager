# PERSONAL TASK MANAGER
---
# PROJECT CODE
WST21-PM-2026-SF
---
# STUDENT NAME
Aldrian A. Cogonon
---
# Course & Year
BSIT - 2ND YEAR
---
# DATABASE USED 
MYSQL
---
## Features
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
The Dashboard is the main page of TaskFlow. It gives the user a quick overview of their tasks, provides a shortcut for creating a task, shows pending tasks that need attention, and allows the user to search and filter tasks.
## 1. SIDE BAR NAVIGATION
The sidebar is located on the left side of the Dashboard. It contains the TaskFlow logo and two navigation options:
- DASHBOARD
- ALL TASKS
The Dashboard link takes the user to the main dashboard page, while the All Tasks link takes the user to the page containing the complete list of tasks.

The sidebar is fixed to the left side of the screen, while the main content is placed beside it. The project uses a 230px-wide sidebar and a content area that takes the remaining screen width. :contentReference[oaicite:0]{index=0} :contentReference[oaicite:1]{index=1}

## 2. Top Search Bar

The search bar is located at the top of the Dashboard. It allows the user to search for a specific task.

### How it works

1. The user types a task name in the search bar.
2. JavaScript detects the input.
3. The search waits for 300 milliseconds before sending the request.
4. JavaScript uses `fetch()` to send the search text to the Laravel search route.
5. Laravel receives the search request through the `tasks.search` route.
6. `TaskController@search` searches the `task_name` column in the database.
7. Laravel returns the matching tasks as JSON.
8. JavaScript receives the JSON response.
9. The matching task names are displayed below the search bar.
10. When the user clicks a result, the user is redirected to that task's View page.

The search request uses:

`/tasks/search?q=search_text`

The Controller searches using a `LIKE` query so that the search text can match part of a task name.

Example:

Searching for `laravel` can match:
- Learn Laravel
- Laravel Assignment
- Study Laravel Routing
<img src="screenshots/LightMode.png" alt="LightMode" width="900">
---
##DARK MODE/TO-DO LIST/SEARCH BAR

## Dashboard

<img src="screenshots/DarkMode.png" alt="DarkMode" width="900">
