<table id="example" class="table table-striped" style="width:100%">
                <thead>
                   
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                    
                </thead>
                <tbody>
                @php
                $sr=1;
                @endphp
                
                    <tr>
                        <td>1</td>
                        
                        <td>
                            {{$author->first_name}} &nbsp;{{$author->last_name}}
                        </td>
                       

                        <td>{{$author->email}}</td>
                        
                    </tr>
                    
                        @php $sr=2; @endphp
                        @foreach($contributors as $con)
                        <tr id="conts">
                          <td>{{$sr}}</td>
                          <td>{{$con->first_name}} {{$con->last_name}}</td>
                          <td>{{$con->email}}</td>
                        </tr>

                        @php $sr++; @endphp
                        @endforeach
                    
                    
                
                </tbody>
                <tfoot>
                
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                
                </tfoot>
            </table>