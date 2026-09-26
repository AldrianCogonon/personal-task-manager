const globalSearch = document.getElementById('globalSearch');
const searchResults = document.getElementById('searchResults');

let searchTimeout;

globalSearch.addEventListener('input', function () {
    clearTimeout(searchTimeout);

    const search = this.value.trim();

    if (search === '') {
        searchResults.innerHTML = '';
        searchResults.style.display = 'none';
        return;
    }

    searchTimeout = setTimeout(async function () {
        try {
            const response = await fetch(
                `/tasks/search?q=${encodeURIComponent(search)}`
            );

            if (!response.ok) {
                throw new Error('Search failed.');
            }

            const tasks = await response.json();

            searchResults.innerHTML = '';

            if (tasks.length === 0) {
                searchResults.innerHTML = `
                    <div class="search-no-results">
                        No matching tasks found.
                    </div>
                `;

                searchResults.style.display = 'block';
                return;
            }

            tasks.forEach(function (task) {
                const result = document.createElement('button');

                result.type = 'button';
                result.className = 'search-result';

                result.innerHTML = `
                    <span class="search-result-icon">⌕</span>
                    <span class="search-result-name"></span>
                `;

                result.querySelector('.search-result-name').textContent =
                    task.task_name;

                result.addEventListener('click', function () {
                    window.location.href = task.url;
                });

                searchResults.appendChild(result);
            });

            searchResults.style.display = 'block';

        } catch (error) {
            console.error(error);
            searchResults.innerHTML = '';
            searchResults.style.display = 'none';
        }
    }, 300);
});

document.addEventListener('click', function (event) {
    if (!event.target.closest('.search-bar')) {
        searchResults.style.display = 'none';
    }
});

globalSearch.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        searchResults.style.display = 'none';
        globalSearch.blur();
    }
});