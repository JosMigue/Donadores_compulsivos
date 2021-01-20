<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show($campaignId = null){
        if($campaignId){
            return view('quiz.quiz', compact('campaignId'));
        }else{
            return redirect()->route('campaigns.listing');
        }
    }
}
