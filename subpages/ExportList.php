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
                    alert("success");//setTimeout("self.location.href='libs/turniere.csv'",1000);
                }
            });
        });
    });
</script>
