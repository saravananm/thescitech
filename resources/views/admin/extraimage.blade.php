
@extends('admin.layout.adminlayout')

@section('title', 'Extra Image Settings')

@section('content')
<div class="contentarea">
  <div class="col-sm-12">
    @if($errors->any())
    <div class="alert alert-danger" role="alert">
      <ul class="error-list">
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
    </ul>
    </div>
    @endif
    @if(session('message'))
     <div class="alert alert-success" role="alert"> {{session('message')}}</div>
    @endif


    <form action="{{url('/extraimages')}}" method="post" enctype="multipart/form-data" >
      @csrf
      <input type="hidden"  name="id" value="@if(isset($edit_data)){{old('id', $edit_data->id)}}@else{{old('id')}}@endif">
      
      <div class="row">
        <div class="form-group">
          <label for="image_name">Image/Video/Docx</label>
          <input type="file" class="form-control-file" id="image_name" name="image_name">
        </div>
        
      </div>
      <div class="form-group">
         @if(isset($edit_data))
          <a target="_blank" href= "{{url('public/storage/images/extraimage/'.$edit_data->name) }}" >{{url('public/storage/images/extraimage/'.$edit_data->name) }}</a>
          @endif
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<div class="contentarea">
  <div class="col-sm-12">
    <table class="table table-hover mt-2">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">URL</th>
          <th scope="col">Edit</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $extraimage)
          <tr>
          <th scope="row">{{$extraimage->id}}</th>
          <td>
            <a target="_blank" href= "{{url('public/storage/images/extraimage/'.$extraimage->name) }}" >{{url('public/storage/images/extraimage/'.$extraimage->name) }}</a>
          </td>
          <td><a href="{{url('extraimages/' . $extraimage->id)}}">Edit</a></td>
        </tr>
        @endforeach
        
      </tbody>
    </table>
    {{$data->links()}}
  </div>
</div>
@endsection
