<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
class CakeCron extends Command
{
   /**
   * The name and signature of the console command.
   *
   * @var string
   */
   protected $signature = 'cake:cron';
   /**
   * The console command description.
   *
   * @var string
   */
   protected $description = 'Cake Command Executed Successfully!';
   //Description will be shown when the php artisan list command is executed.
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
    \Log::info("Cake Cron execution!");
    $this->info('Cake:Cron Command is working fine!');
  }
}