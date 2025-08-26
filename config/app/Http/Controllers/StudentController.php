<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TuitionPost;
use App\Models\Subject;
use App\Models\TuitionApplication;
use App\Models\Report;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        $myPosts = TuitionPost::where('user_id', $user->id)
            ->with(['subject', 'applications'])
            ->latest()
            ->get();

        $recentApplications = TuitionApplication::whereHas('tuitionPost', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['tutor', 'tuitionPost'])
        ->latest()
        ->take(5)
        ->get();

        return view('student.dashboard', compact('myPosts', 'recentApplications'));
    }

    public function browseTutors(Request $request)
    {
        $query = User::where('role', 'tutor')->withCount('applications');

        // Filter by subject
        if ($request->filled('subject')) {
            $query->whereHas('applications.tuitionPost', function($q) use ($request) {
                $q->where('subject_id', $request->subject);
            });
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('address', 'like', '%' . $request->location . '%');
        }

        // Filter by rating
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        $tutors = $query->latest()->paginate(12);
        $subjects = Subject::where('is_active', true)->get();

        return view('student.browse-tutors', compact('tutors', 'subjects'));
    }

    public function tutorProfile(User $tutor)
    {
        $tutor->load(['applications.tuitionPost']);
        
        return view('student.tutor-profile', compact('tutor'));
    }

    public function createPost()
    {
        $subjects = Subject::where('is_active', true)->get();
        return view('student.create-post', compact('subjects'));
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_level' => 'required|string',
            'location' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'availability' => 'nullable|string',
        ]);

        $post = TuitionPost::create([
            'user_id' => auth()->id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'class_level' => $request->class_level,
            'location' => $request->location,
            'budget' => $request->budget,
            'availability' => $request->availability,
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Tuition post created successfully!');
    }

    public function editPost(TuitionPost $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $subjects = Subject::where('is_active', true)->get();
        return view('student.edit-post', compact('post', 'subjects'));
    }

    public function updatePost(Request $request, TuitionPost $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_level' => 'required|string',
            'location' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'availability' => 'nullable|string',
        ]);

        $post->update($request->all());

        return redirect()->route('student.dashboard')->with('success', 'Tuition post updated successfully!');
    }

    public function deletePost(TuitionPost $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('student.dashboard')->with('success', 'Tuition post deleted successfully!');
    }

    public function myPosts()
    {
        $posts = TuitionPost::where('user_id', auth()->id())
            ->with(['subject', 'applications'])
            ->latest()
            ->paginate(10);

        return view('student.my-posts', compact('posts'));
    }

    public function postDetails(TuitionPost $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->load(['applications.tutor', 'subject']);
        
        return view('student.post-details', compact('post'));
    }

    public function acceptApplication(TuitionApplication $application)
    {
        if ($application->tuitionPost->user_id !== auth()->id()) {
            abort(403);
        }

        $application->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Application accepted successfully!');
    }

    public function rejectApplication(TuitionApplication $application)
    {
        if ($application->tuitionPost->user_id !== auth()->id()) {
            abort(403);
        }

        $application->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Application rejected successfully!');
    }

    public function reportUser(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string',
            'description' => 'required|string',
        ]);

        Report::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $user->id,
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'User reported successfully!');
    }

    public function reportPost(Request $request, TuitionPost $post)
    {
        $request->validate([
            'reason' => 'required|string',
            'description' => 'required|string',
        ]);

        Report::create([
            'reporter_id' => auth()->id(),
            'tuition_post_id' => $post->id,
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Post reported successfully!');
    }
} 