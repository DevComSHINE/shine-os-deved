<?php namespace Modules\Calendar\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Calendar\Entities\Calendar; //model
use Shine\Libraries\IdGenerator;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\UserHelper;

use View, Response, Input, Datetime;

class CalendarController extends Controller {

    private $facility_id;

    public function __construct() {
        $this->middleware('auth');
        $this->user = UserHelper::getUserInfo();
        $this->facility = FacilityHelper::facilityInfo();

        //create Module table/s when required
        $dbtable = "CREATE TABLE IF NOT EXISTS `calendar` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `calendar_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL ,
          `allday` varchar(1) COLLATE utf8_unicode_ci DEFAULT '0',
          `start` datetime NOT NULL,
          `end` datetime NOT NULL,
          `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
          `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
          `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
          `color` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
          `textcolor` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
          `facility_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
          `user_id` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
          `deleted_at` timestamp NULL DEFAULT NULL,
          `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (id),
          UNIQUE KEY `calendar_calendar_id_unique` (`calendar_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        DB::statement($dbtable);
    }

    public function index()
    {
        $data['user'] = $this->user;
        $data['facilityInfo'] = $this->facility;

        return view('calendar::index')->with($data);
    }

    public function getEventData () {

        $data = Calendar::where('facility_id', '=', $this->facility->facility_id)
            ->where('user_id', $this->user->user_id)
            ->where('start', '>=', $_GET['start'])
            ->where('end', '<=', $_GET['end'])
            ->get();
        $caldata = json_encode($data);
        echo $caldata;
    }

    public function insertNewEvent () {

        $title = Input::get('title');
        $description = Input::get('description');
        $color = Input::get('color');
        $textcolor = Input::get('textcolor');
        $allday = Input::get('allday');
        $start = date('Y-m-d H:i:s', strtotime(Input::get('start')));
        $end = date('Y-m-d H:i:s', strtotime(Input::get('end')));

        $cal = new Calendar;

        $cal->calendar_id = IdGenerator::generateId();
        $cal->facility_id = $this->facility->facility_id;
        $cal->user_id = $this->user->user_id;
        $cal->title = $title;
        $cal->description = $description;
        $cal->start = $start;
        $cal->end = $end;
        $cal->allday = $allday ? 1 : 0;
        $cal->color = $color;
        $cal->textcolor = $textcolor;
        $cal->save();

        return Response::json('success', 200);
    }

    public function update () {

        $title = Input::get('title');
        $description = Input::get('description');
        $color = Input::get('color');
        $textcolor = Input::get('textcolor');
        $allday = Input::get('allday');
        $start = date("Y-m-d H:i:s", strtotime(Input::get('start')));
        $end = date("Y-m-d H:i:s", strtotime(Input::get('end')));

        $cal = new Calendar;

        $updateCal = array(
            //"facility_id" => Input::get('facility_id'),
            //"user_id" => Input::get('user_id'),
            "title" => $title,
            "description" => $description,
            "start" => $start,
            "end" => $end,
            "color" => $color,
            "textcolor" => $textcolor
        );
        $cal->where('calendar_id', Input::get('calendar_id'))
            ->update($updateCal);
    }

    public function moved () {

        $updateCal = array(
            "start" => Input::get('start'),
            "end" => Input::get('end')
        );

        $cal = new Calendar;

        $cal->where('calendar_id', Input::get('calendar_id'))
            ->update($updateCal);

    }

    public function delete () {

        $cal = new Calendar;

        $cal->where('calendar_id', Input::get('calendar_id'))
            ->delete();

    }

}


