<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Emoji;
use Illuminate\Http\Request;

class EmojiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emojis = Emoji::all();
        return view('emoji.index', compact('emojis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('emoji.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $emoji = Emoji::create([
        //     'emoji' => $request->emoji
        // ]);
        $emoji = new Emoji();
        $emoji->emoji = $request->emoji;
        $emoji->save();

        Activity::createLog('emoji', 'Add a new emoji to the system');

        return redirect(route('emoji-manager'))->with('message', 'Added Emoji');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
