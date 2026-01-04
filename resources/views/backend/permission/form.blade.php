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
								<label>Select User Group for Form permission</label>
								<select class="form-select" id="formmenu">
									<option value="0">All Groups</option>
									@foreach($usertype as $m)
									<option value="{{$m->id}}">{{$m->typename}}</option>
									@endforeach
								</select>

							</div>



						</div>

					</div>
					<div class="card-body">
						@csrf
						<div class="row table-body">

						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</main>

@endsection