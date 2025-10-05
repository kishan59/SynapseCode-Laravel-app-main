<?php

namespace App\Http\Controllers;

use App\Models\Snippet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class SnippetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Snippet::where('user_id', $user->id)->orderBy('created_at', 'desc');

        if ($search = $request->query('q')) {
            $keywords = array_filter(explode(' ', Str::lower($search)));
            foreach ($keywords as $kw) {
                $query->where(function($q) use ($kw) {
                    $q->where('title', 'like', "%{$kw}%")
                      ->orWhere('description', 'like', "%{$kw}%")
                      ->orWhere('code_content', 'like', "%{$kw}%")
                      ->orWhere('notes', 'like', "%{$kw}%")
                      ->orWhere('tags', 'like', "%{$kw}%");
                });
            }
        }

        if ($lang = $request->query('language_filter')) {
            $query->where('language', 'like', "%{$lang}%");
        }

        $snippets = $query->paginate(10)->withQueryString();

        return view('snippets.my_snippets', compact('snippets'));
    }

    public function create()
    {
        return view('snippets.add_snippet');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:100',
            'code_content' => 'required|string',
            'language' => 'required|string|max:50',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'source_url' => 'nullable|url|max:255',
            'tags' => 'nullable|string|max:255',
        ]);

        $data['user_id'] = Auth::id();

        Snippet::create($data);

        return Redirect::route('snippets.index')->with('success', 'Your snippet has been added!');
    }

    public function edit(Snippet $snippet)
    {
        if ($snippet->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to edit this snippet.');
        }

        return view('snippets.add_snippet', ['snippet' => $snippet, 'edit' => true]);
    }

    public function update(Request $request, Snippet $snippet)
    {
        if ($snippet->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to edit this snippet.');
        }

        $data = $request->validate([
            'title' => 'required|string|max:100',
            'code_content' => 'required|string',
            'language' => 'required|string|max:50',
            'description' => 'required|string',
            'notes' => 'nullable|string',
            'source_url' => 'nullable|url|max:255',
            'tags' => 'nullable|string|max:255',
        ]);

        $snippet->update($data);

        return Redirect::route('snippets.index')->with('success', 'Your snippet has been updated!');
    }

    public function destroy(Request $request, Snippet $snippet)
    {
        if ($snippet->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to delete this snippet.');
        }

        $snippet->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Snippet deleted successfully!']);
        }

        return Redirect::route('snippets.index')->with('success', 'Your snippet has been deleted!');
    }

    public function json(Snippet $snippet)
    {
        if ($snippet->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json($snippet);
    }
}
