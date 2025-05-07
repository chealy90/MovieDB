<?php

namespace App\Http\Controllers;

use App\Models\SavedList;
use Illuminate\Http\Request;

class SavedListController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'list_id' => 'required|exists:lists,id',
        ]);

        SavedList::create($request->only('user_id', 'list_id'));

        return response()->json(['message' => 'List saved successfully.']);
    }
}
