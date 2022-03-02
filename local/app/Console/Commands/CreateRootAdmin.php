<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;


class CreateRootAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:root';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to create root user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $newuser = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '123456',



        ];
        $users= User::create($newuser);
        $users->assignRole('Admin');



    }
}