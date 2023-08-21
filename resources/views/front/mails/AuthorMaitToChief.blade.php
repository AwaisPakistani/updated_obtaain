<!DOCTYPE html>
<html>
<head>
  <title>Obtaain | Author-Message </title>
    <style>
        table tr td b{
            color:red;
        }
    </style>
</head>
<body>
<table style="border:0px;">

    <tr>
      <td><b>Email:</b></td>
      <td>{{$from_mail}}</td>
    </tr>
    <tr>
       <td><b>Subject:</b></td>
       <td>{{$subject}}</td>
    </tr>
    <tr>
       <td><b>Message:</b></td>
       <td>{!!$body!!}</td>
    </tr>
</table>
</body>
</html>
