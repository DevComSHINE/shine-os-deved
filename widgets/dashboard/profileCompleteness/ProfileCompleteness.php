<?php
namespace widgets\dashboard\profileCompleteness;

use Arrilot\Widgets\AbstractWidget;
use ShineOS\Core\Users\Entities\Users;
use Shine\Libraries\UserHelper;
use View;

class ProfileCompleteness extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $id = UserHelper::getUserInfo();
        $profile_completeness = Users::computeProfileCompleteness($id->user_id);

        View::addNamespace('profile_completeness', 'widgets/dashboard/profileCompleteness/');
        return view("profile_completeness::index", [
            'config' => $this->config,
            'profile_completeness' => $profile_completeness,
        ]);
    }
}
