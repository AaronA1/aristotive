<?php

namespace App\Repositories\Question;

interface QuestionRepositoryInterface
{
    public function getLatestQuestion($roomId);
}
