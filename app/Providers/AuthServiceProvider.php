<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('check-role', function (User $user, array $permittedRoles) {
            $authorized = false;
            foreach ($permittedRoles as $permittedRole) {
                $authorized = $authorized ? true : $user->role_id === $permittedRole;
            }
            return $authorized;
        });

        Gate::define('upload-blog', function (User $user, ?int $studentId = 0) {
            if ($user->role_id === 2) {
                $students = $user->students;
                $authorized = false;
                foreach ($students as $student) {
                    $authorized = $authorized ? true : $student->id === $studentId;
                }
                return $authorized;
            } elseif ($user->role_id === 3) {
                return !is_null($user->current_tutor);
            }
            return false;
        });

        Gate::define('delete-blog', function (User $user, Blog $blog) {
            return (
                $blog->author_id === $user->id ||
                (
                    $user->role_id === 2 &&
                    ($blog->author_id  === $user->id || $blog->receiver_id === $user->id)
                )
            );
        });

        Gate::define('delete-blogcomment', function (User $user, BlogComment $blogComment) {
            return (
                $blogComment->author_id === $user->id ||
                (
                    $user->role_id === 2 &&
                    ($blogComment->author_id  === $user->id || $blogComment->receiver_id === $user->id)
                )
            );
        });
    }
}
