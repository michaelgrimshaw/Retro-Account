<?php

namespace Tests\Traits;

use App\User\Models\User;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Arr;

/**
 * Class AutoLoginTrait
 *
 * @package Tests\Traits
 */
trait AutoLoginTrait
{
    /**
     * Act all test cases as a logged in user
     *
     * @var bool
     */
    protected $autoLogin = true;

    /**
     * Acting user
     *
     * @var null|User
     */
    protected $actor = null;


    /**
     * Test setup hook
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        if ($this->shouldAutoLogin()) {
            $this->doAutoLogin();
        }
    }

    /**
     * Get the user to auto log in as
     *
     * @param array $params
     *
     * @return Authenticatable
     */
    protected function autoLoginAs(array $params = [])
    {
        return User::factory()->create($params);
    }

    /**
     * Handle auto login
     *
     * @return \Tests\Feature\Portal\PortalTestCase
     */
    protected function doAutoLogin()
    {
        $this->actingAs($this->actor = $this->autoLoginAs(), 'portal');

        return $this;
    }

    /**
     * Check whether the test should run auto login
     * This method will check test annotations for @autoLogin
     *
     * @return bool|mixed|null
     */
    protected function shouldAutoLogin()
    {
//        $annotations    = $this->getAnnotations();
//        $annotationSays = Arr::get($annotations['method'], 'autoLogin.0', null);
//
//        switch ($annotationSays) {
//            case "":
//                $annotationSays = true;
//                break;
//
//            case false:
//            case "false":
//                $annotationSays = false;
//                break;
//
//            case true:
//            case "true":
//                $annotationSays = true;
//                break;
//
//            default:
//                $annotationSays = null;
//        }
//
//        if (!is_null($annotationSays)) {
//            return $annotationSays;
//        }

        return $this->autoLogin;
    }
}
