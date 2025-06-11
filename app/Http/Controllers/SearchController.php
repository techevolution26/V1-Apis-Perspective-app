<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perception;

class SearchController extends Controller
{
    /**
     * GET /api/search?query=…
     * Return a JSON array of matching perceptions.
     */
    public function search(Request $request)
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json([], 200);
        }

        $results = Perception::with('user')
            ->join('users', 'perceptions.user_id', '=', 'users.id')
            ->where(function ($q) use ($query) {
                $q->where('perceptions.body', 'LIKE', "%$query%")
                    ->orWhere('users.name', 'LIKE', "%$query%")
                    ->orWhere('users.profession', 'LIKE', "%$query%");
            })
            ->select('perceptions.*') // ensures only perceptions fields are returned
            ->latest()
            ->limit(30)
            ->get();

        return response()->json($results);
    }
}
