document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll("nav a");
    const contentDiv = document.getElementById("content");

    function loadPage(page) {
        fetch(`index.php?page=${page}&ajax=1`)
            .then(res => res.text())
            .then(html => contentDiv.innerHTML = html)
            .catch(err => console.error(err));
    }

    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const page = this.getAttribute("data-page");
            loadPage(page);
            history.pushState(null, '', `?page=${page}`);
        });
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function () {
        const params = new URLSearchParams(window.location.search);
        const page = params.get('page') || 'dashboard';
        loadPage(page);
    });
});
