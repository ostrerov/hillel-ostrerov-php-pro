<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Psy\Readline\Hoa\ConsoleException;

class UserCommand extends Command
{
    protected $signature = 'user';

    protected $description = 'Command description';

    protected array $data = [];

    public function handle()
    {
        $this->data['name'] = $this->ask('What is your name?');
        $this->data['age'] = $this->ask('How old are you?');
        if ($this->data['age'] < 18 AND !$this->confirm('This command 18+. Do you want to continue?')) {
            $this->error('You chose \'No\'. Exit from command');
            return false;
        }

        $option = $this->choice('Choice your option', ['read', 'write']);
        if ($option === 'read' AND Storage::disk('local')->exists('Commands/UserCommand.txt')) {
            $file = Storage::disk('local')->get('Commands/UserCommand.txt');
            if (empty($file)) {
                $this->info('File is empty. End command');
                return false;
            }
            $this->comment('Data: ' . $file);
            return true;
        }

        if ($option === 'write') {
            $this->data['sex'] = $this->choice('What is your gender?', ['male', 'female', 'other']);
            if ($this->data['sex'] === 'other') {
                $this->data['sex'] = $this->ask('What is your gender name?');
            }
            $this->data['phone'] = $this->ask('What is your phone number?');
            $this->data['city'] = $this->ask('Where are you live?');

            $data = json_encode($this->data, JSON_FORCE_OBJECT);

            if (Storage::disk('local')->put('Commands/UserCommand.txt', $data)) {
                $file = Storage::disk('local')->get('Commands/UserCommand.txt');
                $this->info('Data wrote successful!');
                $this->comment('Data: ' . $file);
                return true;
            }

            $this->error('Writing error!');
            return false;
        }

        $this->error('Error! File not found!');
        return false;
    }
}
