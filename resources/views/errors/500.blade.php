<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Internal server error</title>

<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">

<link href="{{ asset('css/theme/error.css') }}" rel="stylesheet">

</head>
<body>
  <div class="notFoundContainer">
    <div class="notfound">
      <div class="notfound-404">
        <h1>5<span>0</span>0</h1>
      </div>
      <h2>{{__('Internal server error.')}}</h2>
      <a href="/" class="button">{{__('Go Home')}}</a>
    </div>
  </div>
</html>