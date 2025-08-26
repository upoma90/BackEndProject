<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TuitionPost;
use App\Models\Subject;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_tutors' => User::where('role', 'tutor')->count(),
            'total_posts' => TuitionPost::count(),
            'pending_posts' => TuitionPost::where('status', 'pending')->count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
        ];

        $recent_posts = TuitionPost::with(['user', 'subject'])
            ->latest()
            ->take(5)
            ->get();

        $recent_reports = Report::with(['reporter', 'reportedUser'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_reports'));
    }

    public function users()
    {
        $users = User::withCount(['tuitionPosts', 'applications'])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function userDetails(User $user)
    {
        $user->load(['tuitionPosts', 'applications']);
        return view('admin.users.show', compact('user'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,student,tutor'
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    public function tuitionPosts()
    {
        $posts = TuitionPost::with(['user', 'subject'])
            ->latest()
            ->paginate(20);

        return view('admin.tuition-posts.index', compact('posts'));
    }

    public function approvePost(TuitionPost $post)
    {
        $post->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Post approved successfully.');
    }

    public function rejectPost(TuitionPost $post)
    {
        $post->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Post rejected successfully.');
    }

    public function deletePost(TuitionPost $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully.');
    }

    public function reports()
    {
        $reports = Report::with(['reporter', 'reportedUser', 'tuitionPost'])
            ->latest()
            ->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    public function resolveReport(Report $report)
    {
        $report->update(['status' => 'resolved']);
        return redirect()->back()->with('success', 'Report resolved successfully.');
    }

    public function dismissReport(Report $report)
    {
        $report->update(['status' => 'dismissed']);
        return redirect()->back()->with('success', 'Report dismissed successfully.');
    }

    public function subjects()
    {
        $subjects = Subject::withCount('tuitionPosts')
            ->latest()
            ->paginate(20);

        return view('admin.subjects.index', compact('subjects'));
    }

    public function storeSubject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects',
            'description' => 'nullable|string',
        ]);

        Subject::create($request->all());

        return redirect()->back()->with('success', 'Subject created successfully.');
    }

    public function updateSubject(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $subject->update($request->all());

        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function deleteSubject(Subject $subject)
    {
        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully.');
    }

    public function statistics()
    {
        $monthlyStats = DB::table('tuition_posts')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        $userStats = [
            'students' => User::where('role', 'student')->count(),
            'tutors' => User::where('role', 'tutor')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        $postStats = [
            'total' => TuitionPost::count(),
            'pending' => TuitionPost::where('status', 'pending')->count(),
            'approved' => TuitionPost::where('status', 'approved')->count(),
            'rejected' => TuitionPost::where('status', 'rejected')->count(),
        ];

        return view('admin.statistics', compact('monthlyStats', 'userStats', 'postStats'));
    }
} 