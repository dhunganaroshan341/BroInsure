@extends('backend.layout.main')
@section('main')

<main class="content">
	<div class="container-fluid p-0">



		<div class="row">
			<div class="col-12">

				<div class="card">
					<div class="card-header">
						<h5 class="card-title">{{$title}}</h5>

						<div class="row">
							<div class="col-md-4">
								<label>Select Menus for submenu permission</label>
								<select class="form-select" id="parentmenu">
									<option value="0">All Menu</option>
									@foreach($module as $m)
									<option value="{{$m->id}}">{{$m->modulename}}</option>
									@endforeach
								</select>

							</div>



						</div>

					</div>
					<div class="card-body">
						@csrf
						<div class="row table-body">
							@include($folder.'.table')
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</main>

@endsection