@extends('front.layout.main')

<link href="{{url('assets/front/dist/css/datatable.min.css')}}" rel="stylesheet">

<link href="{{url('assets/front/dist/css/cdn.css')}}" rel="stylesheet">

<style>

 .author-links a{

    text-decoration:none;

 }

 .author-links a:hover{

    color:#ff8000;

 }

</style>

@section('content')

@include('front.inc.journal_content_hero')

<div class="container mb-3 mt-3">

    <div class="row">

       <div class="col-lg-12 text-end">

       <a href="{{ url()->previous() }}" class="btn btn-warning">Previous Link <-</a>

       </div>

      </div>

    <div class="row">

    

        <div class="col-lg-12 mt-2 text-end py-2 text-start" style="text-decoration:none;">

        @include('front.inc.alerts')

        <div class="author-links text-start px-5 py-2">

        

            <table id='example' class="table table-striped table-bordered">

                <thead>

                  <tr>

                    <th>Sr#</th>

                    <th>Content</th>

                    <th>Date of Rejection</th>

                    <th>Status</th>

                  </tr>

                </thead>

                <tbody>

                    @php

                    $sr=1;

                    @endphp

                    @foreach($notifications as $notify)

                    <tr>

                        <td>{{$sr}}</td>

                        <td>{{$notify->content}}</td>

                        <td>

                        @php

                        echo date("d-m-Y", strtotime($notify->created_at));

                        @endphp 

                        </td>

                        <td>

                          <button @if($notify->status=='rejected') class="btn btn-danger" @else class="btn btn-primary" @endif>{{$notify->status}}</button>

                        </td> 

                        

                        

                    </tr>

                    @php

                    $sr++;

                    @endphp

                    @endforeach

                </tbody>

                <tfoot>

                    <th></th>

                    <th></th>

                    <th></th>

                    <th></th>

                    

                </tfoot>

            </table>

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

