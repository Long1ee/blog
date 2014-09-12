<html>
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
        <script type="text/javascript">
           $(function(){
                $("#button").click(function() {
                    $.ajax({
                    url: "example/",
                    succes: function(data) {
                        $("#block").append("<p>" + data + "<p>")
                    }
                    })
                })

                 
           })
        </script>
    </head>
    <body>
        <h1>Мой блог</h1>
        <h2>jQuery</h2>
        <input type="button" name="button" id="button" value="Ajax me!">
        <div id="block"></div>
        <p></p>
    </body>
</html>