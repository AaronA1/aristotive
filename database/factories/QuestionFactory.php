<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_id' => 'testRoomId',
            'type' => 'multi-choice',
            'question' => 'What is 2+2',
            'options' => json_encode(['1', '2', '3', '4']),
            'image' => '',
        ];
    }

}
