@extends('layout')

@section('title','My Snippets')

@section('content')
    <h1 class="text-center mb-4 text-synapse-accent-green">My Code Snippets</h1>

    <div class="text-center mb-4">
        <a href="{{ route('snippets.create') }}" class="btn btn-primary btn-lg">Add New Snippet</a>
    </div>

    @if($snippets->count() || request()->query('q') || request()->query('language_filter'))
    <div class="row mb-4 justify-content-center">
        <div class="col-md-8 col-lg-7">
            <form method="GET" action="{{ route('snippets.index') }}" class="input-group mw-100">
                <input type="text" class="form-control" placeholder="Search keywords (title, code, description, tags)..." name="q" value="{{ request('q','') }}">
                <input type="text" class="form-control" placeholder="Filter by language (e.g., Python, JS, HTML)" name="language_filter" value="{{ request('language_filter','') }}">
                <button class="btn btn-primary" type="submit">Search</button>
                @if(request('q') || request('language_filter'))
                    <a href="{{ route('snippets.index') }}" class="btn btn-outline-secondary  d-flex align-items-center justify-content-center">Clear</a>
                @endif
            </form>
        </div>
    </div>
    @endif

    @if($snippets->count())
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($snippets as $snippet)
                <div class="col">
                    <div class="card h-100 shadow-sm border border-synapse-accent-green bg-synapse-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title text-synapse-accent-green mb-2">{{ $snippet->title }}</h5>
                            <h6 class="card-subtitle mb-2 text-light text-capitalize">{{ $snippet->language }}</h6>
                            <p class="card-text small text-light">{{ Str::limit($snippet->description, 100) }}</p>
                            <div class="code-preview mt-3 mb-3 border border-dark rounded overflow-auto">
                                <pre><code class="language-{{ Str::lower($snippet->language) }}">{{ $snippet->code_content }}</code></pre>
                            </div>

                            <hr class="border-light opacity-25">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="#" class="btn btn-sm btn-primary view-code-btn" data-bs-toggle="modal" data-bs-target="#snippetModal" data-snippet-id="{{ $snippet->id }}">View Code</a>
                                <div>
                                    <a href="{{ route('snippets.edit', $snippet) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                    <form method="POST" action="{{ route('snippets.destroy', $snippet) }}" style="display:inline; padding: 0;">@csrf<button type="submit" class="btn btn-sm btn-danger">Delete</button></form>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-synapse-dark-blue text-light small">
                            Created: {{ $snippet->created_at->format('Y-m-d H:i') }}
                            @if($snippet->updated_at && $snippet->updated_at != $snippet->created_at)
                                <br>Updated: {{ $snippet->updated_at->format('Y-m-d H:i') }}
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert bg-synapse-dark text-light border border-synapse-accent-green text-center py-4" role="alert">
            <h4 class="alert-heading text-synapse-accent-green">No Snippets Yet!</h4>
            <p>It looks like you haven't added any code snippets. Start organizing your knowledge now!</p>
            <hr class="border-light opacity-25">
            <p class="mb-0">Click the button above to add your first snippet.</p>
        </div>
    @endif

    {{ $snippets->links() }}

    <!-- modal -->
    <div class="modal fade" id="snippetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content bg-synapse-dark-blue text-white border-synapse-accent-green">
                <div class="modal-header border-bottom border-synapse-accent-green">
                    <h5 class="modal-title">Snippet Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h4 id="modalSnippetTitle" class="text-synapse-accent-green mb-3"></h4>
                    <p class="text-muted small mb-1">Language: <span id="modalSnippetLanguage" class="badge bg-synapse-primary"></span></p>
                    <p class="text-muted small mb-3">Created: <span id="modalSnippetCreatedAt"></span> | Updated: <span id="modalSnippetUpdatedAt"></span></p>

                    <h6 class="text-synapse-accent-green">Description:</h6>
                    <p id="modalSnippetDescription" class="text-light"></p>

                    <h6 class="text-synapse-accent-green mt-4">Code:</h6>
                    <div class="position-relative">
                        <pre class="rounded bg-synapse-dark p-3" data-prismjs-copy="Copy to Clipboard"><code id="modalSnippetCode" class="language-undefined"></code></pre>
                    </div>

                    <h6 class="text-synapse-accent-green mt-4">Notes:</h6>
                    <p id="modalSnippetNotes" class="text-light fst-italic"></p>

                    <h6 class="text-synapse-accent-green mt-4">Source URL:</h6>
                    <p><a href="#" id="modalSnippetSourceUrl" class="text-synapse-primary text-decoration-none" target="_blank"></a></p>

                    <h6 class="text-synapse-accent-green mt-4">Tags:</h6>
                    <p id="modalSnippetTags" class="text-synapse-accent-green"></p>
                </div>
                <div class="modal-footer border-top border-synapse-accent-green">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" id="modalEditBtn" class="btn btn-warning">Edit</a>
                    <button type="button" class="btn btn-danger" id="modalDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection
