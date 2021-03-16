<?php

namespace App\Repositories\Question;

use App\Models\Question;
use App\Repositories\BaseRepository;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{

    public function __construct(Question $model)
    {
        parent::__construct($model);
    }

    public function getLatestQuestion($roomId)
    {
        return $this->model->where('room_id', $roomId)->latest()->first();
    }
}
