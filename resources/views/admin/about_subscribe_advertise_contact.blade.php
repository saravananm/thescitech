
@extends('admin.layout.adminlayout')

@section('title', 'About Subscribe Advertise Contact Module')

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
    <form action="{{url('/about_subscribe_advertise_contact')}}" method="post" enctype="multipart/form-data" >
      @csrf
      <div class="form-group">
        <label for="about">About:</label>
        <textarea   class="form-control" name="about" placeholder="Enter about" id="about">@if(isset($data)){{old('about', $data->about)}}@else{{old('about')}}@endif</textarea>
      </div>
      <div class="form-group">
        <label for="subscribe">Subscribe:</label>
        <textarea   class="form-control" name="subscribe" placeholder="Enter subscribe" id="subscribe">@if(isset($data)){{old('subscribe', $data->subscribe)}}@else{{old('subscribe')}}@endif</textarea>
      </div>
      <div class="form-group">
        <label for="advertise">Advertise:</label>
        <textarea   class="form-control" name="advertise" placeholder="Enter advertise" id="advertise">@if(isset($data)){{old('advertise', $data->advertise)}}@else{{old('advertise')}}@endif</textarea>
      </div>
      <div class="form-group">
        <label for="contact">Contact:</label>
        <textarea   class="form-control" name="contact" placeholder="Enter contact" id="contact">@if(isset($data)){{old('contact', $data->contact)}}@else{{old('contact')}}@endif</textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
@push('head')
<!-- Scripts -->
<script src="{{ asset('public/js/ckeditor/ckeditor.js')}}"></script>
@endpush
<script>
      CKEDITOR.replace( 'about' );
      CKEDITOR.replace( 'subscribe' );
      CKEDITOR.replace( 'advertise' );
      CKEDITOR.replace( 'contact' );
</script>
@endsection
