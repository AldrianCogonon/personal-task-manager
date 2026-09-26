const themeToggle = document.getElementById('themeToggle');

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
