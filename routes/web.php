<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/perjalanan-12-tahap', function () {
    $stages = json_decode(file_get_contents(resource_path('data/stages.json')), true);
    $glossary = json_decode(file_get_contents(resource_path('data/glossary.json')), true);
    $quiz = json_decode(file_get_contents(resource_path('data/quiz.json')), true);

    return view('perjalanan-12-tahap.index', compact('stages', 'glossary', 'quiz'));
});
