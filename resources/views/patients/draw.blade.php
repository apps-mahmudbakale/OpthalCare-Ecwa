<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title></title>
    <style type="text/css">
        body {
            font-family: Arial;
            font-size: 10pt;
        }

        .tools a {
            text-decoration: none;
        }

        #colors_sketch {
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="tools">
        <a href="#colors_sketch" data-tool="marker">Marker</a> <a href="#colors_sketch" data-tool="eraser">
            Eraser</a>
    </div>
    <br />
    <canvas id="colors_sketch" width="500" height="200" style="width: 550px;height: 500px;border-radius: 7px;">
    </canvas>
    <br />
    <br />
    <input type="button" id="btnSave" value="Save as Image" />
    <hr />
    <input type="hidden" id="sketch">
    <img id = "imgCapture" alt = "" style = "display:none;border:1px solid #ccc" />
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/mobomo/sketch.js/master/lib/sketch.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('#colors_sketch').sketch();
            $(".tools a").eq(0).attr("style", "color:#000");
            $(".tools a").click(function() {
                $(".tools a").removeAttr("style");
                $(this).attr("style", "color:#000");
            });
            $("#btnSave").bind("click", function() {
                var base64 = $('#colors_sketch')[0].toDataURL();
                $("#imgCapture").attr("src", base64);
                $("#sketch").attr("value", base64);

                $("#imgCapture").show();
            });

        });
    </script>
</body>

</html>
