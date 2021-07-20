<?php

use App\Http\Controllers\EntrarController;
use App\Http\Controllers\EpisodiosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TemporadasController;
use App\Mail\NovaSerie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', [SeriesController::class, 'index']);

Route::get('/series', [SeriesController::class, 'index'])->name('listar_series');
Route::get('/series/criar', [SeriesController::class, 'create'])->name('form_criar_serie')->middleware('autenticador');
Route::post('/series/criar', [SeriesController::class, 'store'])->middleware('autenticador');
Route::delete('/series/{id}', [SeriesController::class, 'destroy'])->middleware('autenticador');
Route::post('/series/{id}/editaNome', [SeriesController::class, 'editaNome'])->middleware('autenticador');

Route::get('/series/{serieId}/temporadas', [TemporadasController::class, 'index']);

Route::get('/temporadas/{temporada}/episodios', [EpisodiosController::class, 'index']);

Route::post('/temporadas/{temporada}/episodios/assistir', [EpisodiosController::class, 'assistir'])->middleware('autenticador');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/entrar', [EntrarController::class, 'index']);
Route::post('/entrar', [EntrarController::class, 'entrar']);
Route::get('/registrar', [RegistroController::class, 'create']);
Route::post('/registrar', [RegistroController::class, 'store']);

Route::get('/sair', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/entrar');
});

Route::get('/visualizando-email', function() {
    return new \App\Mail\NovaSerie(
        nome:'Arrow',
        qtdTemporadas: 5,
        qtdEpisodios:10
    );
});

Route::get('/enviando-email', function() {

    $email = new NovaSerie(
        nome:'Arrow',
        qtdTemporadas: 5,
        qtdEpisodios:10
    );

    $email->subject = 'Nova Série Adicionada';

    $user = 'gustavo@teste.com';

    Mail::to($user)->send($email);

    return 'Email enviado!';
});
