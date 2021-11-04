<?php

namespace App\Providers;

use App\Models\Models\Team;
use App\Policies\TeamPolicy;
use App\Models\Models\Design;
use App\Models\Models\Comment;
use App\Models\Models\Message;
use App\Policies\DesignPolicy;
use App\Policies\CommentPolicy;
use App\Policies\MessagePolicy;
use App\Models\Models\Invitation;
use App\Policies\InvitationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Design::class => DesignPolicy::class,
        Comment::class => CommentPolicy::class,
        Team::class => TeamPolicy::class,
        Invitation::class => InvitationPolicy::class,
        Message::class => MessagePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
