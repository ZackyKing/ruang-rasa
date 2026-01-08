<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Post;
use App\Models\Answer;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    /**
     * Show the questions page
     */
    public function index()
    {
        // Get posts that are questions (category "Pertanyaan" / type question)
        // Assuming questions are posts with a specific category
        $questionCategory = \App\Models\Category::where('slug', 'pertanyaan')->first();

        if ($questionCategory) {
            $questions = Post::with(['user', 'category', 'likes', 'comments', 'reshares', 'saves'])
                ->where('category_id', $questionCategory->id)
                ->where('is_draft', false)
                ->latest()
                ->get();
        } else {
            // Fallback: get all questions from Question model
            // But we need to convert them or use Post model
            $questions = collect();
        }

        return view('pertanyaan', compact('questions'));
    }

    /**
     * Store a new question
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:5',
            'is_anonymous' => 'boolean',
        ]);

        // Find the question category
        $questionCategory = \App\Models\Category::where('slug', 'pertanyaan')->first();

        if (!$questionCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori pertanyaan tidak ditemukan',
            ], 404);
        }

        // Create as a Post with question category
        $post = Post::create([
            'user_id' => auth()->id(),
            'category_id' => $questionCategory->id,
            'content' => $request->content,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'is_draft' => false,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pertanyaan berhasil dibuat!',
                'post' => $post->load('user', 'category'),
            ]);
        }

        return redirect()->back()->with('success', 'Pertanyaan berhasil dibuat!');
    }

    /**
     * Answer a question
     */
    public function answer(Request $request, Question $question)
    {
        $request->validate([
            'content' => 'required|string|min:1',
        ]);

        $answer = Answer::create([
            'question_id' => $question->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil ditambahkan!',
            'answer' => $answer->load('user'),
            'answers_count' => $question->answers()->count(),
        ]);
    }

    /**
     * Get answers for a question
     */
    public function getAnswers(Question $question)
    {
        $answers = $question->answers()->with('user')->get();

        return response()->json([
            'success' => true,
            'answers' => $answers->map(function ($answer) {
                return [
                    'id' => $answer->id,
                    'author' => $answer->user->name,
                    'avatar' => $answer->user->avatar,
                    'content' => $answer->content,
                    'created_at' => $answer->created_at->diffForHumans(),
                ];
            }),
        ]);
    }
}
