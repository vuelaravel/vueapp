@extends('admin.admin_master')
@section('admin')
<div class="card card-default">
										<div class="card-header card-header-border-bottom">
											<h2>User Profile Update</h2>
										</div>
										@if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{session('success')}}</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
       @endif
										<div class="card-body">
											<form method ="post" action="{{route('update.user')}}"  class="form-pill" enctype="multipart/form-data">
												@csrf
												<div class="form-group">
													<label for="exampleFormControlPassword3">User Name</label>
													<input type="text" class="form-control" name="name" value="{{$user['name']}}">
													
												</div>
                                                <div class="form-group">
													<label for="exampleFormControlPassword3">User Email</label>
													<input type="text" class="form-control" name="email" value="{{$user['email']}}">
													
												</div>
												<div class="form-group">
											     @if(!empty($user['profile_photo_path']))
												 <img src="{{asset('storage/'.$user['profile_photo_path'])}}" style="height:40px; width:70px">
												 @endif
													<label for="exampleFormControlPassword3">User Profile Pic</label>
													<input type="file" class="form-control" name="user_profile_pic">
													<input type="hidden" name="old_image" value="{{$user['profile_photo_path']}}">	
												</div>
                                               
                                             <button type="submit" class="btn btn-primary btn-default">Update</button>
											</form>
										</div>
									</div>

								

@endsection