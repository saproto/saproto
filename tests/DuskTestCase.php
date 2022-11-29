<?php

namespace Tests;

use Exception;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;
use Proto\Models\Member;
use Proto\Models\User;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static bool $firstTest = true;
    protected static User $testUser;

    /**
     * Register the base URL with Dusk.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        if (static::$firstTest) {
            $this->artisan('migrate:fresh', ['--seed' => true]);
            static::$testUser = self::createTestUser();
            static::$firstTest = false;
        }
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            $this->shouldStartMaximized(),
            ...$this->shouldStartHeadless()
        ]);

        return RemoteWebDriver::create(
            env('SAIL_SELENIUM_URL', 'http://selenium:4444'),
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return array<string>
     */
    protected function shouldStartHeadless()
    {
        return env('DUSK_HEADLESS_DISABLED') ? [] : [
            '--disable-gpu',
            '--headless',
        ];
    }

    /**
     * Determine if the browser window should start maximized.
     *
     * @return string
     */
    protected function shouldStartMaximized()
    {
        return env('DUSK_START_MAXIMIZED') ? '--start-maximized' : '--window-size=1920,1080';
    }

    /**
     * Create persisting test user with membership.
     *
     * @return User
     */
    protected static function createTestUser()
    {
        /** @var Member $member */
        $member = Member::factory()
            ->create([
                'user_id' => User::factory()
                    ->hasBank()
                    ->hasAddress()
                    ->state([
                        'name' => 'Test User',
                        'calling_name' => 'Test',
                        'email' => 'test.user@example.com',
                    ]),
            ]);
        $member->user->setPassword('test');
        return $member->user;
    }
}
