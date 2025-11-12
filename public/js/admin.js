document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar .nav-link');

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});

// File input validation
document.getElementById('csv_file')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName && !fileName.endsWith('.csv')) {
        alert('Пожалуйста, выберите файл в формате CSV');
        e.target.value = '';
    }
});

// Tree expand/collapse functionality
document.addEventListener('DOMContentLoaded', function() {
    // Toggle individual items
    document.querySelectorAll('.tree-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const parent = this.closest('li');
            const childList = parent.querySelector('ul');

            if (childList) {
                childList.classList.toggle('collapsed');
                this.textContent = childList.classList.contains('collapsed') ? '+' : '−';
            }
        });
    });

    // Expand all
    document.getElementById('expandAll')?.addEventListener('click', function() {
        document.querySelectorAll('.tree ul').forEach(ul => {
            ul.classList.remove('collapsed');
        });
        document.querySelectorAll('.tree-toggle').forEach(toggle => {
            toggle.textContent = '−';
        });
    });

    // Collapse all
    document.getElementById('collapseAll')?.addEventListener('click', function() {
        document.querySelectorAll('.tree ul').forEach(ul => {
            ul.classList.add('collapsed');
        });
        document.querySelectorAll('.tree-toggle').forEach(toggle => {
            toggle.textContent = '+';
        });
    });
});