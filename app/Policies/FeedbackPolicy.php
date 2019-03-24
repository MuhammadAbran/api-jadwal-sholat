<?php

namespace App\Policies;

use App\User;
use App\Feedback;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Feedback Policy
 */
class FeedbackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view list of model.
     *
     * @param User $user
     * @param null $parent
     * @return mixed
     */
    public function index(User $user, $parent = null)
    {
        return true;
    }

    /**
     * Determine whether the user can view the feedback.
     *
     * @param User $user
     * @param Feedback $feedback
     * @param null $parent
     * @return mixed
     */
    public function view(User $user, Feedback $feedback, $parent = null)
    {
        return true;
    }

    /**
     * Determine whether the user can create dummyPluralModel.
     *
     * @param User $user
     * @param null $parent
     * @return mixed
     */
    public function create(User $user, $parent = null)
    {
        return true;
    }

    /**
     * Determine whether the user can update the feedback.
     *
     * @param User $user
     * @param Feedback $feedback
     * @param null $parent
     * @return mixed
     */
    public function update(User $user, Feedback $feedback, $parent = null)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the feedback.
     *
     * @param User $user
     * @param Feedback $feedback
     * @param null $parent
     * @return mixed
     */
    public function delete(User $user, Feedback $feedback, $parent = null)
    {
        return true;
    }
}
