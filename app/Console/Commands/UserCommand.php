<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UserCommand extends Command
{
    protected $signature = 'user';

    protected $description = 'Command description';

    protected array $data = [];

    public function handle()
    {
        $confirm = true;
        $this->data['name'] = $this->ask('What is your name?');
        $this->data['age'] = $this->ask('How old are you?');
        if ($this->data['age'] < 18) {
            if ($this->confirm('This command 18+. Do you want to continue?') === false) {
                $confirm = false;
                $this->error('You chose \'No\'. Exit from command');
            }
        }

        if ($confirm) {
            $option = $this->choice('Choice your option', ['read', 'write']);
            if ($option === 'read') {
                if (Storage::disk('local')->exists('Commands/UserCommand.txt')) {
                    $file = Storage::disk('local')->get('Commands/UserCommand.txt');
                    if (!empty($file)) {
                        $this->comment('Data: ' . $file);
                    } else {
                        $this->info('File is empty. End command');
                    }
                } else {
                    $this->error('Error! File not found!');
                }
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
                } else {
                    $this->error('Writing error!');
                }
            }
        }
    }
}
