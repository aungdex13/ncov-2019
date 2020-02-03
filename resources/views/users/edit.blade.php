@extends('layouts.index')
@section('contents')
<div class="page-breadcrumb bg-light">
	<div class="row">
		<div class="col-12 d-flex no-block align-items-center">
			<h4 class="page-title"><span style="display:none;">Edit user</span></h4>
			<div class="ml-auto text-right">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
						<li class="breadcrumb-item active" aria-current="page">Edit</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="d-md-flex align-items-center" style="border-bottom:1px solid #EAEAEA">
						<div>
							<h4 class="card-title">บริหารจัดการผู้ใช้งานระบบ</h4>
							<h5 class="card-subtitle">ID Flu-BOE</h5>
						</div>
					</div>
					<div class="my-4">
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<strong>Whoops!</strong> There were some problems with your input.<br><br>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
								<div class="form-group">
									<label for"name">คำนำหน้าชื่อ</label>
									{!! Form::text('title_name', null, array('placeholder' => 'Title name','class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
								<div class="form-group">
									<label for"name">ชื่อ</label>
									{!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
								<div class="form-group">
									<label for"lastname">นามสกุล</label>
									{!! Form::text('lname', null, array('placeholder' => 'Lastname','class' => 'form-control')) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
								<div class="form-group">
									<label for="email">Email:</label>
									{!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
								<div class="form-group">
									<label for="pwd">Password:</label>
									{!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
								<div class="form-group">
									<label for="confirmpwd">Confirm Password:</label>
									{!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12">
								<div class="form-group">
									<label for="role">Role:</label>
									{!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple roles')) !!}
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12">
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
	$('.roles').select2();
});
</script>
@endsection
