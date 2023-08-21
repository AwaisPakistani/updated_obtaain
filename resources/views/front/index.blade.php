

@extends('front.layout.main')

@section('content')

@include('front.inc.carousell')

<div class="container text-center mb-5">

@include('front.inc.alerts')

    <div class="row">

        @foreach($categories as $category)

        <div class="col-lg-4 my-4 mainhome">

            <a href="{{route('front.view_category_detail',$category->id)}}" style="text-decoration:none;">

                <img src="{{url('storage/'.$category->category_image->url)}}" alt="Category-image" >

    

                <h5 class="my-3">{{$category->category_name}}</h5>

            </a>  

        </div>

        @endforeach

        <!-- /.col-lg-4 -->

     

    </div>
    

</div>
<div class="container text-left px-2">
    <div class="row">
        <div class="col-lg-12">
           @if($pinnedJournals->count() > 0)
            <h3>Pinned Journals</h3><hr>
           @endif
            <ul>
                @foreach($pinnedJournals as $pin)
                <li>
                    <a style="text-decoration: none;" href="{{route('front.journal_detail',$pin->journal_id)}}">
                    {{$pin->id}}&nbsp;&nbsp;&nbsp;
                    {{$pin->journal_name}}
                    </a>
                </li> 
                @endforeach
            </ul>
            
        </div>
    </div>
</div><br>

@endsection