@extends('layout')

@section('title', isset($snippet) ? 'Edit Snippet' : 'Add New Snippet')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card bg-synapse-dark text-white shadow-lg border border-synapse-accent-green">
                <div class="card-body">
                    <h2 class="card-title text-center text-synapse-accent-green mb-4">{{ isset($snippet) ? 'Edit Snippet' : 'Add a New Code Snippet' }}</h2>

                    <form method="POST" action="{{ isset($snippet) ? route('snippets.update', $snippet) : route('snippets.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input name="title" value="{{ old('title', $snippet->title ?? '') }}" class="form-control" placeholder="e.g., Python List Comprehension, JS Async/Await">
                            @error('title')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Code Content</label>
                            <textarea name="code_content" rows="10" class="form-control" placeholder="Paste your code here...">{{ old('code_content', $snippet->code_content ?? '') }}</textarea>
                            @error('code_content')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Language</label>
                            <input name="language" value="{{ old('language', $snippet->language ?? '') }}" class="form-control" placeholder="e.g., Python, JavaScript, CSS">
                            @error('language')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="5" class="form-control" placeholder="Explain what this code does">{{ old('description', $snippet->description ?? '') }}</textarea>
                            @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" rows="3" class="form-control" placeholder="Optional: Any personal notes">{{ old('notes', $snippet->notes ?? '') }}</textarea>
                            @error('notes')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Source URL</label>
                            <input name="source_url" value="{{ old('source_url', $snippet->source_url ?? '') }}" class="form-control" placeholder="Optional: Where did you find this snippet?">
                            @error('source_url')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tags (comma-separated)</label>
                            <input name="tags" value="{{ old('tags', $snippet->tags ?? '') }}" class="form-control" placeholder="Optional: Add comma-separated tags">
                            @error('tags')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg mt-3">Save Snippet</button>
                            <a href="{{ route('snippets.index') }}" class="btn btn-secondary btn-lg mt-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
