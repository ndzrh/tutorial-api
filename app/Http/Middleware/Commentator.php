<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Commentator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUser = auth()->user(); //who is current user login right now
        $comment = Comment::findOrFail($request->id);

        //if not commentator's comment
        if ($comment->user_id != $currentUser->id) {
            return response()->json(['message' => 'Data not available'], 404);
        }

        return $next($request);
    }
}
