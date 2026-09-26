const themeToggle = document.getElementById('themeToggle');
const globalSearch = document.getElementById('globalSearch');
const statusFilter = document.getElementById('statusFilter');
const dateFilter = document.getElementById('dateFilter');
const clearFilters = document.getElementById('clearFilters');
const tasks = document.querySelectorAll('.recent-task');
const filterEmpty = document.getElementById('filterEmpty');

function setTheme(theme) {
    document.documentElement.dataset.theme = theme;
    localStorage.setItem('taskflow-theme', theme);
    themeToggle.textContent = theme === 'dark' ? '☀' : '☼';
}

setTheme(localStorage.getItem('taskflow-theme') || 'light');

themeToggle.addEventListener('click', function () {
    const theme = document.documentElement.dataset.theme;

    setTheme(theme === 'dark' ? 'light' : 'dark');
});

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

function filterTasks() {
    const search = globalSearch.value.toLowerCase().trim();
    const status = statusFilter.value;
    const date = dateFilter.value;

    let visibleTasks = 0;

    tasks.forEach(function (task) {
        const name = task.dataset.taskName;
        const description = task.dataset.description;
        const taskStatus = task.dataset.status;
        const taskDate = task.dataset.dueDate;

        const matchesSearch =
            name.includes(search) ||
            description.includes(search);

        const matchesStatus =
            status === 'all' ||
            taskStatus === status;

        const matchesDateFilter =
            matchesDate(taskDate, date);

        const visible =
            matchesSearch &&
            matchesStatus &&
            matchesDateFilter;

        task.hidden = !visible;

        if (visible) {
            visibleTasks++;
        }
    });

    filterEmpty.hidden = visibleTasks > 0;
}

globalSearch.addEventListener('input', filterTasks);
statusFilter.addEventListener('change', filterTasks);
dateFilter.addEventListener('change', filterTasks);

clearFilters.addEventListener('click', function () {
    globalSearch.value = '';
    statusFilter.value = 'all';
    dateFilter.value = 'all';

    filterTasks();
});

filterTasks();