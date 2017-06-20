<?php

namespace App\Http\Controllers;

use App\AccessCode;
use Illuminate\Support\Facades\File;
use App\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('rateLimiting')->only('login');
        $this->middleware('accessCode')->only('login');
        $this->middleware('sessionRefresh')->only('loginForm');
        $this->middleware('verifySession')->only('ballot');
    }

    public function loginForm()
    {
        $welcome = config('vote.messages.welcome') . (empty(config('vote.messages.welcome')) ? '' : '<br/>');
        $message = session('message');
        $messageClass = (session('messageType') === 'exception') ? 'danger' : 'success';
        $logoPath = config('vote.branding.logo');

        return view('loginForm', [
            'welcome' => $welcome,
            'message' => $message,
            'messageClass' => $messageClass,
            'logoPath' => File::exists(base_path() . '/public/' . $logoPath) ? asset($logoPath) : null
        ]);
    }

    public function ballot()
    {
        $categories = AccessCode::find(session()->get('accessCodeId'))
            ->categories()
            ->get();

        $squashed = (bool)config('vote.categories.squash');

        return view('ballot', [
            'categories' => $categories,
            'squashed' => $squashed
        ]);
    }

    public function submitBallot(Request $request)
    {
        $requestKeys = array_keys($request->all());
        $selectedElems = preg_grep('/^category-[0-9]+-radios$/', $requestKeys);

        foreach ($selectedElems as $elem) {
            $categoryId = [];
            preg_match('/^category-([0-9]+)-radios/', $elem, $categoryId);

            // Gets any current vote for this Access Code and Category
            $currentVotes = Vote::where('category_id', $categoryId[1])
                ->where('access_code_id', $request->input('access-code-id'))
                ->get();

            if ($currentVotes->isEmpty()) {
                $vote = new Vote;
                $vote->access_code_id = $request->input('access-code-id');
                $vote->category_id = $categoryId[1];
                $vote->film_id = $request->input($elem);
                $vote->save();
            } else {
                if ($currentVotes->count() > 1) {
                    throw new \Exception('Multiple voting within a category is not implemented yet.');
                } else {
                    $vote = $currentVotes->first();
                    $vote->film_id = $request->input($elem);
                    $vote->save();
                }
            }
        }

        return redirect('/vote');
    }

    public function login()
    {
        return redirect('ballot')->with([
            'timestamp' => time()
        ]);
    }
}