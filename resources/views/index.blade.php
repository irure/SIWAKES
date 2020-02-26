<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Roboto:400">
  <link rel="stylesheet" href="https://unpkg.com/ionicons@4.2.2/dist/css/ionicons.min.css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="https://hypertext-candy.s3-ap-northeast-1.amazonaws.com/posts/vue-laravel-tutorial/app.css">
  <link rel="stylesheet" href="https://lipis.github.io/bootstrap-social/bootstrap-social.css"  >
  <script src="https://cdn.jsdelivr.net/npm/vuelidate@0.7.4/dist/vuelidate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuelidate@0.7.4/dist/validators.min.js"></script>
  <script src="https://unpkg.com/vue-star-rating/dist/star-rating.min.js"></script>
  
</head>
<body>
  <div id="app"></div>
</body>
</html>

<style>
  html{
    background-color: antiquewhite;
    font-size: 62.5%;
}
.navbar{
    background-color:lightpink;
}
input,select{
  background-color:ivory;
}
.panel{
  text-align:center;
}
.sbutton{
  background-color:lightskyblue;
  color:#555;
}
.star-rating{
  justify-content:center;
  display:flex;
}

.fuchidori {
  text-shadow:1px 1px 0 #666, -1px -1px 0 #666,
              -1px 1px 0 #666, 1px -1px 0 #666,
              0px 1px 0 #666,  0-1px 0 #666,
              -1px 0 0 #666, 1px 0 0 #666;
}

body,input,select,button,p,label,div{
    font-size:1rem;
    line-height: 2;
    border-radius:6px;
    box-shadow: none;
}
table{
  border-spacing:3px;
}


@media screen and (max-width: 640px) {/* 640px以下*/
    body,input,select{
    font-size:0.9rem;
    line-height: 2;
}
}

@media screen and (max-width: 400px) {/* 640px以下*/
    body,input,select,button{
    font-size:0.5rem;
    line-height: 2;
}
}

</style>