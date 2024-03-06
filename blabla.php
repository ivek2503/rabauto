<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button onclick="kliknul()">abc</button>

    <div id="box" style="width: 100px; height: 100px; background-color:red;"></div>

    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>
    <script>
        $("#box").hide();
        function kliknul(){
            $("#box").show();
        }
    </script>
</body>
</html>