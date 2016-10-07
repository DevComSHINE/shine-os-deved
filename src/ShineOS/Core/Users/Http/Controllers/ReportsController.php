<?php namespace ShineOS\Core\Users\Http\Controllers;

use Illuminate\Routing\Controller;


use View,
    Response,
    Validator,
    Input,
    Mail,
    Session,
    Redirect,
    Hash,
    Auth,
    DB;

class ReportsController extends Controller {



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    /**
     * Display index
     *
     * @return Response
     */
    public function index()
    {
        $data = array();

        return view('users::report2.index')->with($data);
    }

    /**
     * Display a1
     *
     * @return Response
     */
    public function a1()
    {
        $data = array();

        return view('users::report2.a1')->with($data);
    }

    /**
     * Display a2
     *
     * @return Response
     */
    public function a2()
    {
        $data = array();

        return view('users::report2.a2')->with($data);
    }

    /**
     * Display a3
     *
     * @return Response
     */
    public function a3()
    {
        $data = array();

        return view('users::report2.a3')->with($data);
    }

    /**
     * Display m1
     *
     * @return Response
     */
    public function m1()
    {
        $data = array();

        return view('users::report2.m1')->with($data);
    }

    /**
     * Display m2
     *
     * @return Response
     */
    public function m2()
    {
        $data = array();

        return view('users::report2.m2')->with($data);
    }

    /**
     * Display q1
     *
     * @return Response
     */
    public function q1()
    {
        $data = array();

        return view('users::report2.q1')->with($data);
    }

    /**
     * Display q2
     *
     * @return Response
     */
    public function q2()
    {
        $data = array();

        return view('users::report2.q2')->with($data);
    }

    /**
     * Display abrgy
     *
     * @return Response
     */
    public function abrgy()
    {
        $data = array();

        return view('users::report2.abrgy')->with($data);
    }


    private function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }


}
