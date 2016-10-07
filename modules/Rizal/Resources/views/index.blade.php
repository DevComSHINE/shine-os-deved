@extends('rizal::layouts.master')

@section('heads')
<!-- Anything you need to add in the head part of the HTML page -->

@stop

@section('rizal-content')
<!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header">
                    <h2>Hello Dr. Jose P. Rizal</h2>
                    <p class="lead">Dr. Jose Rizal, the our hero-physician of the Philippines.</p>
                </div>
                <div class="box-body pad20">
                    <p><img src="{!! url('modules/Rizal/Assets/img/Jose_Rizal.jpg') !!}" style="float:right;margin-left:50px;" /> <strong>José Protasio Rizal Mercado y Alonso Realonda</strong> or popularly known as <strong>José Rizal</strong> (Spanish pronunciation: [xoˈse riˈsal]; June 19, 1861 – December 30, 1896) was a Filipino nationalist and polymath during the tail end of the Spanish colonial period of the Philippines. An ophthalmologist by profession, Rizal became a writer and a key member of the Filipino Propaganda Movement which advocated political reforms for the colony under Spain. He was executed by the Spanish colonial government for the crime of rebellion after an anti-colonial revolution, inspired in part by his writings, broke out. Though he was not actively involved in its planning or conduct, he ultimately approved of its goals which eventually led to Philippine independence. He is widely considered one of the greatest heroes of the Philippines, and is implied by Philippine law to be one of the national heroes. He was the author of the novels Noli Me Tángere, and El filibusterismo, and a number of poems and essays.<br /><small>Source: <a href="https://en.wikipedia.org/wiki/Jos%C3%A9_Rizal">Wikipedia</a></small></p>

                    <blockquote>
                    <p><strong>SHINE OS+</strong> is dedicated to our Dr. Rizal who, in his self serving heroism, helped a many people in his practice of medicine as an Opthalmologist. <strong>SHINE OS+</strong> is created to improve healthcare services in managing data and continuity of health services by making access to pertinent data fast and efficient.</p>
                    <p>This Rizal Module is a sample module to demonstrate the ease of creating new extensions for ShineOS+.</p>
                    </blockquote>

                    <p>Go to the Extensions page to check out other SHINE OS+ extensions. <br /><a href="{{ url('extensions') }}" class="btn btn-primary">Extensions</a></p>
                </div><!-- /.box-body -->
                <div class="box-footer">

                </div>
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
@stop

@section('scripts')
<!-- Any custom scripts that goes before the closing body tag -->
@stop
