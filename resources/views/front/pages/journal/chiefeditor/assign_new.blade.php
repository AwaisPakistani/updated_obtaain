@php 

use App\Models\Frontuser;

use App\Models\Contributor;

@endphp

@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

@section('content')

@include('front.inc.journal_content_hero')

<div class="container mb-3 mt-3">

    <div class="row">

    <div class="col-lg-12 text-center">

    @include('front.inc.pages_journal_buttons')

    </div>

    </div>

    <div class="row">

    @include('front.inc.alerts')

      

        <div class="col-lg-12 mt-2 text-end py-2" style="text-decoration:none;">

       



        <div class="content">

            <div class="collapse multi-collapse" id="multiCollapseExample2">

              <div class="card card-body">

              

              </div>

            </div>

        <div>

              <div class="card card-body">

                  <div class="row">

                    <div class="col-lg-12">

                        <span>

                          <h3 class="text-start">Assign New Paper</h3>

                          

                        </span>

                       

                      

                    </div>

                     

                  </div>

                  <hr/>

                  <div class="row">

                    <div class="col-lg-6">

                        <div class="row">

                        <div class="col-lg-12 text-start">

                        <form method="post" action="{{route('front.chief.papers_assignnew',$paper->id)}}">@csrf

                            <!-- <select name="assignto" class="text-start"   style="width:100%; height:40px;">

                                <option>SelectUser</option>

                                @if(!empty($reviewers))

                                @foreach($reviewers as $rev)

                                <Option value="{{$rev->id}}">{{$rev->first_name}} {{$rev->last_name}} (Reviewer)</Option>
                                


                                @endforeach

                                @endif

                                @if(!empty($editors))

                                @foreach($editors as $editor)

                                <Option value="{{$editor->id}}">{{$editor->first_name}} {{$editor->last_name}} (Editor)</Option>

                                @endforeach

                                @endif

                            </select> -->
                            @if(!empty($reviewers))

                            @foreach($reviewers as $rev)
                            <input type="checkbox" class="text-start form-check-input" id="{{$rev->id}}" name="reviewer[]" value="{{$rev->id}}">
                                <label class="form-check-label" for="check2">{{$rev->first_name}} {{$rev->last_name}} (Reviewer)</label><br>
                            @endforeach

                            @endif
                           
                            

                        

                        </div>

                        <div class="col-lg-2">

                        <button type="submit" class="btn btn-primary">Assign</button>

                        </div>

                        </div>

                        </form>

                    </div>

                    <div class="col-lg-6">

                    

                    </div>



                  </div>

              </div>

            </div>



        </div>

        

        

         

        </div>

    </div>

</div>



@endsection

<script src="{{url('assets/front/dist/js/jquery.min.js')}}"></script>

    <script src="{{url('assets/front/dist/js/datatable_net.min.js')}}"></script>

    <script src="{{url('assets/front/dist/js/datatable.min.js')}}"></script>

    <script>

    $(document).ready(function () {

    $('#example').DataTable();

    });

</script>

