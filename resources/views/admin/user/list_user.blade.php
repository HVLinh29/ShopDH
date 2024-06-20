@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
       Liệt kê User
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="myTable">
          <style>
            .custom-button {
                background-color: brown;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 5px 2px;
                cursor: pointer;
                border: none;
                border-radius: 4px;
            }
            span.dt-column-title {
                font-size: large;
            }
        </style>
        <a href="{{ URL::to('/add-users') }}" class="custom-button" >Thêm User</a>
          <?php
          $message = Session::get('message');
          if($message){
              echo '<span class="text-alert">'.$message.'</span>';
              Session::put('message',null);
          }
          ?>
          <thead>
            <tr>
              
              <th style="color: brown">Tên User</th>
              <th style="color: brown">Email</th>
              <th style="color: brown">Phone</th>
              <th style="color: brown">Password</th>
              <th style="color: brown">Author</th>
              <th style="color: brown">Admin</th>
              <th style="color: brown">User</th>
            
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($admin as $key => $user)
            <form action="{{url('/assign-roles')}}" method="POST">
              @csrf
              <tr>
                <td>{{ $user->admin_name }}</td>
                <td>{{ $user->admin_email }} 
                  <input type="hidden" name="admin_email" value="{{ $user->admin_email }}">
                  <input type="hidden" name="admin_id" value="{{ $user->admin_id }}">
                </td>
                <td>{{ $user->admin_phone }}</td>
                <td>{{ $user->admin_password }}</td>
                <td><input type="checkbox" name="author_role" {{$user->hasRole('author') ? 'checked' : ''}}></td>
                <td><input type="checkbox" name="admin_role"  {{$user->hasRole('admin') ? 'checked' : ''}}></td>
                <td><input type="checkbox" name="user_role"  {{$user->hasRole('user') ? 'checked' : ''}}></td>

              <td>
                  
                    
                <p><input type="submit" value="Phân quyền" class="btn btn-sm btn-default"></p>
                <p><a style="margin: 5px 0" class="btn btn-sm btn-danger" href="{{url('/delete-user-roles/'.$user->admin_id)}}">Xóa User</a></p>
                <p><a style="margin: 5px 0" class="btn btn-sm btn-success" href="{{url('/transferrights/'.$user->admin_id)}}">Chuyển quyền</a></p>
              </td> 
              </td> 

              </tr>
            </form>
          @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection

