<?php

namespace App\Rules;

use App\Models\Room;
use App\Repositories\Room\RoomRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class RoomExists implements Rule
{
    private $repo;

    /**
     * Create a new rule instance.
     *
     * @param RoomRepositoryInterface $repo
     */
    public function __construct(RoomRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return Model|false
     */
    public function passes($attribute, $value)
    {
        return $this->repo->find($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This room does not exist';
    }
}
