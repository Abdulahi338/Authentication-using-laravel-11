{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Dashboard</title>
</head>
<body>

    <div class="container mt-5">
        @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
        <h1>Welcome, {{ $user->name }}</h1>
        <p>Email: {{ $user->email }}</p>
    

        <form action="{{ url('/logout') }}" method="POST">
            @csrf
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    // Use the AuthorizesRequests trait
    use AuthorizesRequests;

    // Display the user's posts
    public function index()
    {
        $posts = Auth::user()->posts;
        return view('posts.index', compact('posts'));
    }

    // Show the form to create a new post
    public function create()
    {
        return view('posts.create');
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Auth::user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    // Show the form to edit a post
    public function edit(Post $post)
    {
        // Authorization check
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    // Update a post
    public function update(Request $request, Post $post)
    {
        // Authorization check
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    // Delete a post
    public function destroy(Post $post)
    {
        // Authorization check
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}

            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</body>
</html>
