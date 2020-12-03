<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;


class RequestHistory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'request_histories';

    public static function store ($request)
    {
        $data = [
            'pathInfo' => $request->path(),
            'method' => $request->method(),
        ];

        $log = new self();
        $log->data = $data;
        $log->save();
    }

}
