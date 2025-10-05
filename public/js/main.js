// main.js copied from Flask app
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('footer-year').innerHTML = new Date().getFullYear();

    const snippetModal = new bootstrap.Modal(document.getElementById('snippetModal'));
    const modalTitle = document.getElementById('modalSnippetTitle');
    const modalLanguage = document.getElementById('modalSnippetLanguage');
    const modalCreatedAt = document.getElementById('modalSnippetCreatedAt');
    const modalUpdatedAt = document.getElementById('modalSnippetUpdatedAt');
    const modalDescription = document.getElementById('modalSnippetDescription');
    const modalCode = document.getElementById('modalSnippetCode');
    const modalNotes = document.getElementById('modalSnippetNotes');
    const modalSourceUrl = document.getElementById('modalSnippetSourceUrl');
    const modalTags = document.getElementById('modalSnippetTags');
    const modalEditBtn = document.getElementById('modalEditBtn');
    const modalDeleteBtn = document.getElementById('modalDeleteBtn');

    document.querySelectorAll('.view-code-btn').forEach(button => {
        button.addEventListener('click', function() {
            const snippetId = this.dataset.snippetId;

            modalDeleteBtn.dataset.snippetId = snippetId;
            modalEditBtn.href = `/snippets/${snippetId}/edit`;

            fetch(`/snippets/${snippetId}/json`)
                .then(response => response.json())
                .then(data => {
                    modalTitle.innerText = data.title;
                    modalLanguage.innerText = data.language;
                    modalCreatedAt.innerText = new Date(data.created_at).toLocaleString();
                    modalUpdatedAt.innerText = new Date(data.updated_at).toLocaleString();
                    modalDescription.innerText = data.description;
                    modalNotes.innerText = data.notes || 'N/A';
                    modalSourceUrl.href = data.source_url || '#';
                    modalSourceUrl.innerText = data.source_url || 'N/A';
                    if (!data.source_url) modalSourceUrl.classList.add('pe-none'); else modalSourceUrl.classList.remove('pe-none');
                    modalTags.innerText = data.tags || 'N/A';

                    modalCode.textContent = data.code_content;
                    modalCode.className = `language-${data.language.toLowerCase()}`;
                    Prism.highlightElement(modalCode);
                })
                .catch(error => { console.error(error); alert('Could not load snippet details.'); });
        });
    });

    modalDeleteBtn.addEventListener('click', function() {
        const snippetIdToDelete = this.dataset.snippetId;
        if (!confirm('Are you sure you want to delete this snippet?')) return;
        fetch(`/snippets/${snippetIdToDelete}/delete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
            .then(response => {
                // If the server returned JSON, parse it. Otherwise just reload (e.g., redirect response).
                if (response.ok) {
                    // Try to parse JSON, but fallback to reload if parsing fails
                    return response.json().catch(() => { location.reload(); });
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => { location.reload(); })
            .catch(e => { console.error(e); alert('Failed to delete snippet'); });
    });

    document.querySelectorAll('.delete-snippet-btn').forEach(button => {
        button.addEventListener('click', function() {
            const snippetIdToDelete = this.dataset.snippetId;
            if (!confirm('Are you sure?')) return;
            fetch(`/snippets/${snippetIdToDelete}/delete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
                .then(response => response.ok ? response.json().catch(() => {}) : Promise.reject())
                .then(() => location.reload())
                .catch((err) => { console.error(err); alert('Failed to delete'); });
        });
    });
});
