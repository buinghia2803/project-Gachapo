<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   *
   * @return void
   */
  public function boot(ResponseFactory $factory)
  {
    // Successful
    $factory->macro('success', function ($data = null, $statusCode = 200) use ($factory) {
      $format = [];

      if ($data instanceof AnonymousResourceCollection) {
        $data = $data->response()->getData(true);
      } elseif ($data instanceof JsonResource) {
        // TODO: processing if need
      }

      if (isset($data['data'])) {
        $format = array_merge($data, $format);
      } else {
        $format['data'] = $data;
      }

      return $factory->make($format, $statusCode);
    });

    // Failure
    $factory->macro('failure', function (string $message = '', $statusCode = 400, $data = [], $code = '') use ($factory) {
      $format = [
        'code' => $code,
        'message' => $message,
        'data' => $data
      ];

      return $factory->make($format, $statusCode);
    });
  }
}
