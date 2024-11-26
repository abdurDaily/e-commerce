<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #error{
           height: 100vh;
           display: flex;
           align-items: center;
           justify-content: center;
           background: #000411;
        }
        #error img{
            width: 100%;
            max-width: 300px;
        }
        *{
            margin: 0
        }
    </style>
</head>
<body>
    <section id="error">
        <img src="{{ asset('images/404.webp') }}" alt="">
    </section>
</body>
</html>