<?php

namespace App\Policies;

use App\User;
use App\Foo;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Foo Policy
 */
class FooPolicy
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
     * Determine whether the user can view the foo.
     *
     * @param User $user
     * @param Foo $foo
     * @param null $parent
     * @return mixed
     */
    public function view(User $user, Foo $foo, $parent = null)
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
     * Determine whether the user can update the foo.
     *
     * @param User $user
     * @param Foo $foo
     * @param null $parent
     * @return mixed
     */
    public function update(User $user, Foo $foo, $parent = null)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the foo.
     *
     * @param User $user
     * @param Foo $foo
     * @param null $parent
     * @return mixed
     */
    public function delete(User $user, Foo $foo, $parent = null)
    {
        return true;
    }
}
