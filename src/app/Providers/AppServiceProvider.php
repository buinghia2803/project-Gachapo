<?php

namespace App\Providers;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginateCollection', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Paginator::useBootstrap();

        view()->composer('*', function ($view)
        {
            $userLogin = Auth::user();
            if($userLogin) {
                $id = $userLogin->id;
                $image = Image::where('item_id', $id)
                        ->where('type', USER_IMAGE_TYPE)
                        ->where('is_avatar', SET_AS_AVATAR)
                        ->first();
                if ($image) {
                    $view->with('currentUserImage', $image->image);
                } else {
                    $view->with('currentUserImage', null);
                }

            } else {
                $view->with('currentUserImage', null);
            }
        });
    }
}
