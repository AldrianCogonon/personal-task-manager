const themeToggle = document.getElementById('themeToggle');

const filterButtons = document.querySelectorAll('.filter-button');

const taskList = document.getElementById('taskList');

const taskRows = [...document.querySelectorAll('.all-task-row')];

const searchInput = document.getElementById('taskSearch');

const taskSort = document.getElementById('taskSort');

function setTheme(theme) {
    document.documentElement.dataset.theme = theme;

    localStorage.setItem('taskflow-theme', theme);

    themeToggle.textContent = theme === 'dark' ? '☀' : '☼';
}

setTheme(
    localStorage.getItem('taskflow-theme') || 'light'
);

themeToggle.addEventListener('click', function () {
    const currentTheme =
        document.documentElement.dataset.theme;

    setTheme(
        currentTheme === 'dark'
            ? 'light'
            : 'dark'
    );
});

let currentFilter = 'all';

function updateTasks() {
    const search =
        searchInput.value.toLowerCase().trim();

    taskRows.forEach(function (task) {

        const status =
            task.dataset.status;

        const content =
            task.textContent.toLowerCase();

        const matchesFilter =
            currentFilter === 'all' ||
            status === currentFilter;

        const matchesSearch =
            content.includes(search);

        task.style.display =
            matchesFilter && matchesSearch
                ? 'grid'
                : 'none';
    });
}

filterButtons.forEach(function (button) {

    button.addEventListener('click', function () {

        filterButtons.forEach(function (item) {
            item.classList.remove('active');
        });

        button.classList.add('active');

        currentFilter =
            button.dataset.filter;

        updateTasks();
    });

});

searchInput.addEventListener(
    'input',
    updateTasks
);

taskSort.addEventListener('change', function () {

    const rows = [...taskRows];

    rows.sort(function (a, b) {

        if (taskSort.value === 'newest') {
            return Number(b.dataset.created) -
                Number(a.dataset.created);
        }

        if (taskSort.value === 'oldest') {
            return Number(a.dataset.created) -
                Number(b.dataset.created);
        }

        if (taskSort.value === 'due') {
            return Number(a.dataset.due) -
                Number(b.dataset.due);
        }

    });

    rows.forEach(function (row) {
        taskList.appendChild(row);
    });

});

updateTasks();