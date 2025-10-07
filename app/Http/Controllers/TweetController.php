<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NewTweetNotification; 

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        //
    $tweets = Tweet::with(['user', 'liked'])->latest()->get();
    // dd($tweets);
    return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
          return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
      'tweet' => 'required|max:255',
    ]);
  $newTweet = $request->user()->tweets()->create($request->only('tweet'));

  // 🔽 定義された $newTweet を使用して通知を送信します
  $users = User::all();
  foreach ($users as $user) {
    $user->notify(new NewTweetNotification($newTweet));
  }

  return redirect()->route('tweets.index');
}
    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        //
         return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        //
         return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        //
         $request->validate([
      'tweet' => 'required|max:255',
    ]);

    $tweet->update($request->only('tweet'));

    return redirect()->route('tweets.show', $tweet);
  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        //
         $tweet->delete();

    return redirect()->route('tweets.index');
    }

public function search(Request $request)
{

  $query = Tweet::query();

  // キーワードが指定されている場合のみ検索を実行
  if ($request->filled('keyword')) {
    $keyword = $request->keyword;
    $query->where('tweet', 'like', '%' . $keyword . '%');
  }

  // ページネーションを追加（1ページに10件表示）
  $tweets = $query
    ->latest()
    ->paginate(10);

  return view('tweets.search', compact('tweets'));
}

}