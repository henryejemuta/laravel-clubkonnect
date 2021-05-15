<?php
/**
 * Created By: Henry Ejemuta
 * Project: laravel-clubkonnect
 * Class Name: InstallLaravelClubKonnect.php
 * Date Created: 9/27/20
 * Time Created: 6:00 PM
 */

namespace HenryEjemuta\LaravelClubKonnect\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallLaravelClubKonnect extends Command
{
    protected $signature = 'clubkonnect:init';

    protected $description = 'Install Laravel ClubKonnect package';

    public function handle()
    {
        $this->info('Installing Laravel ClubKonnect by Henry Ejemuta...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "HenryEjemuta\LaravelClubKonnect\ClubKonnectServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Configuration Published!');

        $this->info('Checking for environmental variable file (.env)');
        if (file_exists($path = $this->envPath()) === false) {
            $this->info('Environmental variable file (.env) not found!');
        } else {
            if ($this->isConfirmed() === false) {
                $this->comment('Phew... No changes were made to your .env file');
                return;
            }
            $this->info('Now writing .env file with ClubKonnect Environmental variable declaration for you to modify...');

            $this->writeChanges($path, "CLUBKONNECT_BASE_URL", "base_url", 'https://www.nellobytesystems.com/');
            $this->writeChanges($path, "CLUBKONNECT_USER_ID", "user_id", "");
            $this->writeChanges($path, "CLUBKONNECT_API_KEY", "api_key", "");
            $this->writeChanges($path, "CLUBKONNECT_DEFAULT_REDIRECT_URL", "default_redirect_url", "");

        }

        $this->info('Laravel ClubKonnect Package Installation Complete!');
    }

    private function writeChanges($path, string $key, string $configKey, $value){
        if (Str::contains(file_get_contents($path), "$key") === false) {
            $this->info("Now writing .env with $key=$value ...");
            file_put_contents($path, PHP_EOL."$key=$value".PHP_EOL, FILE_APPEND);
        }else{
            $this->info("Now updating $key value in your .env to $value ...");
            // update existing entry
            file_put_contents($path, str_replace(
                "$key=".$this->laravel['config']["clubkonnect.$configKey"],
                "$key=$value", file_get_contents($path)
            ));
        }
    }


    /**
     * Get the .env file path.
     *
     * @return string
     */
    protected function envPath()
    {
        if (method_exists($this->laravel, 'environmentFilePath')) {
            return $this->laravel->environmentFilePath();
        }

        // check if laravel version Less than 5.4.17
        if (version_compare($this->laravel->version(), '5.4.17', '<')) {
            return $this->laravel->basePath() . DIRECTORY_SEPARATOR . '.env';
        }

        return $this->laravel->basePath('.env');
    }

    /**
     * Check if the modification is confirmed.
     *
     * @return bool
     */
    protected function isConfirmed()
    {
        return $this->confirm(
            'If your ClubKonnect details are set within your .env file they would be overridden. Are you sure you want to override them if exists?'
        );
    }
}
