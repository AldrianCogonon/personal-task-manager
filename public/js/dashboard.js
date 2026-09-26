const themeToggle = document.getElementById('themeToggle');
const statusFilter = document.getElementById('statusFilter');
const dateFilter = document.getElementById('dateFilter');
const clearFilters = document.getElementById('clearFilters');
const recentList = document.getElementById('recentList');
const filterEmpty = document.getElementById('filterEmpty');

function setTheme(theme) {
    document.documentElement.dataset.theme = theme;
    localStorage.setItem('taskflow-theme', theme);

    if (themeToggle) {
        themeToggle.textContent = theme === 'dark' ? '☀' : '☼';
    }
}

setTheme(localStorage.getItem('taskflow-theme') || 'light');

if (themeToggle) {
    themeToggle.addEventListener('click', function () {
        const theme = document.documentElement.dataset.theme;

        setTheme(theme === 'dark' ? 'light' : 'dark');
    });
}

function matchesDate(taskDate, filter) {
    if (filter === 'all') {
        return true;
    }

    if (filter === 'none') {
        return taskDate === '';
    }

    if (!taskDate) {
        return false;
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const date = new Date(taskDate + 'T00:00:00');

    if (filter === 'today') {
        return date.getTime() === today.getTime();
    }

    if (filter === 'week') {
        const nextWeek = new Date(today);
        nextWeek.setDate(today.getDate() + 7);

        return date >= today && date <= nextWeek;
    }

    if (filter === 'month') {
        return (
            date.getMonth() === today.getMonth() &&
            date.getFullYear() === today.getFullYear()
        );
    }

    if (filter === 'overdue') {
        return date < today;
    }

    return true;
}
function applyFilters() {
    const status = statusFilter.value;
    const date = dateFilter.value;
    const tasks = document.querySelectorAll('.recent-task');

    let visibleTasks = 0;

    tasks.forEach(function (task) {
        const taskStatus = task.dataset.status;
        const taskDate = task.dataset.dueDate;

        const matchesStatus =
            status === 'all' ||
            taskStatus === status;

        const matchesDateFilter =
            matchesDate(taskDate, date);

        const visible =
            matchesStatus &&
            matchesDateFilter;

        task.hidden = !visible;

        if (visible) {
            visibleTasks++;
        }
    });

    filterEmpty.hidden = visibleTasks > 0;
}

function displayTasks(tasks) {
    recentList.innerHTML = '';

    tasks.forEach(function (task) {
        const article = document.createElement('article');

        article.className = 'recent-task';
        article.dataset.status = task.status || '';
        article.dataset.dueDate = task.due_date || '';  

        const info = document.createElement('div');
        info.className = 'recent-task-info';

        const title = document.createElement('h4');
        title.textContent = task.task_name;

        const description = document.createElement('p');
        description.textContent =
            task.description || 'No description provided.';

        info.appendChild(title);
        info.appendChild(description);

        const dateContainer = document.createElement('div');
        dateContainer.className = 'recent-task-date';

        const dateLabel = document.createElement('span');
        dateLabel.textContent = 'Due';

        const dateValue = document.createElement('strong');
        dateValue.textContent = task.due_date || 'Indefinite';

        dateContainer.appendChild(dateLabel);
        dateContainer.appendChild(dateValue);

        const status = document.createElement('span');
        status.className = `status-badge ${task.status || ''}`;
        status.textContent = task.status
            ? task.status.charAt(0).toUpperCase() + task.status.slice(1)
            : '';

        article.appendChild(info);
        article.appendChild(dateContainer);
        article.appendChild(status);

        recentList.appendChild(article);
    });

    applyFilters();

    if (tasks.length === 0) {
        filterEmpty.hidden = false;
    }
}

statusFilter.addEventListener('change', function () {
    applyFilters();
});

dateFilter.addEventListener('change', function () {
    applyFilters();
});

clearFilters.addEventListener('click', function () {
    statusFilter.value = 'all';
    dateFilter.value = 'all';

    applyFilters();
});

applyFilters();
