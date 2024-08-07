<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Holidays</title>
</head>
<body>
  <h1>Holiday Plans!</h1>
  <br>
  @if (sizeof($holidays) > 0)
    @foreach ($holidays as $holiday)
      Title: {{$holiday['title']}} <br>
      Description: {{$holiday['description']}} <br>
      Date: {{$holiday['date']}} <br>
      Location: {{$holiday['location']}} <br>
      @if ($holiday['participants'])
          Participants: {{$holiday['participants']}} <br>
      @endif
      <hr>
  @endforeach
    Enjoy the Holidays!
  @else
    It appears you don't have any plans for this years holidays :(
  @endif
</body>
</html>
