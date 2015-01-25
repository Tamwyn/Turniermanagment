<!-- Include jQuery before this code -->
<form id="export-form" method="post" accept-charset="utf-8">
    <a id="submit-form" href="#">Turnierliste herunterladen</a>
</form>

<script type="text/javascript">

    $(document).ready(function() {
        $("#submit-form").click(function(){
            $.ajax({
                type        : 'POST', 
                url         : 'libs/GenerateCSV.php', 
                data        : 'export',
                success     : function (data) {
                    setTimeout("self.location.href='libs/turniere.csv'",1000);//Just for debugging, later a redirection to a file is planned 
                }
            });
        });
    });
</script>