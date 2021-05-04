<?php

namespace App\Providers;

use App\Repositories\Question\QuestionRepository;
use App\Repositories\Question\QuestionRepositoryInterface;
use App\Repositories\Response\ResponseRepository;
use App\Repositories\Response\ResponseRepositoryInterface;
use App\Repositories\Room\RoomRepository;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QuestionRepositoryInterface::class, QuestionRepository::class);
        $this->app->bind(ResponseRepositoryInterface::class, ResponseRepository::class);
        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
