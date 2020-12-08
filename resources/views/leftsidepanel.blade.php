@foreach($advertisementdetails_top as $advertisements_top)
<div class="graybox-advertisement">
	<a href="{{$advertisements_top->url}}" target="blank"><img src= "{{url('public/storage/images/advertisements/'.$advertisements_top->image_name) }}" style="width:100%;height:{{$advertisements_top->height}}px" /></a>
</div>
@endforeach
<div class="clearfix"></div>

<ul class="tab-head">
    <li class="leftpaneltab1" onclick="leftPanelTab(1)">In The Scitech Journal</li>
    <li class="leftpaneltab2" onclick="leftPanelTab(2)">In The News & Features</li>
</ul>
<div class="clearfix"></div>
<div style="border-bottom: 3px solid #00b3e5;"></div>
<div class="clearfix"></div>

@foreach($sidepaneltabthescitechpostdetails as $sidepaneltabs)
<div class="tab-content leftpanelcontent1">
	<h2><a href="{{url('the-scitech-journal-post/'.$sidepaneltabs['slug'])}}">{{$sidepaneltabs['title']}}</a></h2>
</div>
@endforeach

@foreach($sidepaneltabpostdetails as $sidepaneltabs)
<div class="tab-content leftpanelcontent2">
	<h2><a href="{{url('post/'.$sidepaneltabs['slug'])}}">{{$sidepaneltabs['title']}}</a></h2>
</div>
@endforeach



<div class="clearfix pt-1"></div>

@foreach($advertisementdetails_bottom as $advertisements_bottom)
<div class="graybox-advertisement">
	<a href="{{$advertisements_bottom->url}}" target="blank"><img src= "{{url('public/storage/images/advertisements/'.$advertisements_bottom->image_name) }}" style="width:100%;height:{{$advertisements_bottom->height}}px" /></a>
</div>
@endforeach
<div class="clearfix"></div>