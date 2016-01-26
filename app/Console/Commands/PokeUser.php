<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class PokeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:poke {user : The ID of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to a user, by passing his userId';
    /**
     * @var Dingo\Api\Dispatcher
     */
    private $dispatcher;

    /**
     * Create a new command instance.
     *
     * @param Dingo\Api\Dispatcher $dispatcher
     */
    public function __construct(\Dingo\Api\Dispatcher $dispatcher)
    {
        parent::__construct();
        $this->dispatcher = $dispatcher;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uri = $this->setUri();

        $user = $this->dispatcher->be(User::find(1))->version('v2')->get($uri);

        var_dump($user->toArray());
    }

    public function setUri()
    {
        return 'api/users/'.$this->argument('user').'?include=posts';
    }
}
