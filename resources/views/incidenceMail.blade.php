<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>{{$title}}</title>
    <style type="text/css">
        .card{
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
            left:0;
            right:0;
            top: 0;
            bottom: 0;
            margin:auto;
        }
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        .card-img, .card-img-top {
            border-top-left-radius: calc(.25rem - 1px);
            border-top-right-radius: calc(.25rem - 1px);
        }
        .card-img, .card-img-bottom, .card-img-top {
            width: 100%;
        }
        #title-incidence{
            left:0;
            right:0;
            margin-bottom: 20px;
        }
        .card-body {
            flex: 1 1 auto;
            padding: 1rem 1rem;
        }
        .card-title {
            margin-bottom: .5rem;
        }
        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        .incidence-mail{
            width:60%;
            left:0;
            right:0;
            margin:auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container incidence-mail">
        <div id="title-incidence">{{$title}}</div>
        <div class="card" style="width: 18rem;">
            <img src="{{$image_uri}}" class="card-img-top bd-placeholder-img " alt="...">
            <div class="card-body">
                <h5 class="card-title">{{$incidence->name}}</h5>
                <p class="card-text">{{$incidence->description}}</p>
            </div>
        </div>
    </div>
        
</body>
</html>