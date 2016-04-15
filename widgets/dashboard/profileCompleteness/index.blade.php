<div class="box box-primary"><!--Profile Progress-->
	<div class="box-header with-border">
		<i class="fa fa-smile-o"></i>
		<h3 class="box-title text-shine-blue"> Your Profile</h3>
		<small><em>Completing your profile will help the system work for you better.</em></small>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		</div><!-- /.box-tools -->
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="progress">
		  <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="{{ $profile_completeness['percent'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $profile_completeness['percent'] }}%;">
		    Completeness: {{ $profile_completeness['percent'] }}%
		  </div>
		</div>
	</div><!-- /.box-body -->

	<div class="box-footer text-center">
		@if( Auth::check() )
		<?php $id = Auth::user()->user_id; ?>
		@endif

		<a href="{{ url('/users',[$id])}}" class="uppercase">Edit Profile</a>
	</div><!-- /.box-footer -->
</div><!--./End Profile Progress-->