<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DBListenServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        \DB::listen(function ($query) {
            $operate = current(explode(' ', $query->sql));
            if (in_array(strtolower($operate), ['insert', 'update', 'delete'])) {
                //                \Log::debug('SQL', [$query->sql, $query->bindings]);
            }
            //            \Log::debug('SQL', [vsprintf(str_replace('?', "'%s'", $query->sql), $query->bindings)]);
        });
    }
}
