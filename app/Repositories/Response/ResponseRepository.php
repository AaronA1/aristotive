<?php

namespace App\Repositories\Response;

use App\Models\Response;
use App\Repositories\BaseRepository;

class ResponseRepository extends BaseRepository implements ResponseRepositoryInterface
{

    public function __construct(Response $model)
    {
        parent::__construct($model);
    }

}
