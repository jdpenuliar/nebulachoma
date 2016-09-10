<!DOCTYPE html>
<html>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<link href="./style.css" rel="stylesheet" type="text/css" />
<script src="./icheck.js" type="text/javascript"></script>
<link href="./css/theme.default.css" rel="stylesheet" type="text/css" />
<script src="./jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="./jquery.tablesorter.widgets.min.js" type="text/javascript"></script>
<script>
function togglecheckboxes(master,group){
	var cbarray = document.getElementsByClassName(group);
	for(var i = 0; i < cbarray.length; i++){
		var cb = document.getElementById(cbarray[i].id);
		cb.checked = master.checked;
	}
}
</script>
	
    <!-- DATA TABLES -->
        <link href="./css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
         <!-- DATA TABES SCRIPT -->
        <script src="./js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="./js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
</head>
<body>
<?php
echo "<input type=\"checkbox\" id=\"cbgroup1_master\" onchange=\"togglecheckboxes(this,'cbgroup1')\"> Toggle All";
echo "<br><br>";
echo "<input type=\"checkbox\" id=\"cb1_1\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"1\"> Item 1<br>";
echo "<input type=\"checkbox\" id=\"cb1_2\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"2\"> Item 2<br>";
echo "<input type=\"checkbox\" id=\"cb1_3\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"3\"> Item 3<br>";
echo "<input type=\"checkbox\" id=\"cb1_4\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"4\"> Item 4<br>";

echo "<input type=\"checkbox\" id=\"cb1_5\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"5\"> Item 5<br>";
echo "<input type=\"checkbox\" id=\"cb1_6\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"5\"> Item 5<br>";
echo "<input type=\"checkbox\" id=\"cb1_7\" class=\"cbgroup1\" name=\"cbg1[]\" value=\"5\"> Item 5<br>";

echo '<div>Using Check all function</div>
<div id="selectCheckBox">
<input type="checkbox" class="all" />Select All
<input type="checkbox" class="check" />Check Box 1
<input type="checkbox" class="check" />Check Box 2
<input type="checkbox" class="check" />Check Box 3
<input type="checkbox" class="check" />Check Box 4</div>
';

?>
<div>Using Check all function</div>
<div id="selectCheckBox">
<input type="checkbox" class="all" />Select All
<input type="checkbox" class="check" />Check Box 1
<input type="checkbox" class="check" />Check Box 2
<input type="checkbox" class="check" />Check Box 3
<input type="checkbox" class="check" />Check Box 4</div>
  

    
    
     <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                            	<th><input type="checkbox" class="all" /></th>
                                                <th>Rendering engine</th>
                                                <th>Browser</th>
                                                <th>Platform(s)</th>
                                                <th>Engine version</th>
                                                <th>CSS grade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            	<td><input type="checkbox" class="check" /></td>
                                                <td>Trident</td>
                                                <td>Internet
                                                    Explorer 4.0</td>
                                                <td>Win 95+</td>
                                                <td> 4</td>
                                                <td>X</td>
                                            </tr>
                                            <tr>
                                            <td><input type="checkbox" class="check" /></td>
                                                <td>Trident</td>
                                                <td>Internet
                                                    Explorer 5.0</td>
                                                <td>Win 95+</td>
                                                <td>5</td>
                                                <td>C</td>
                                            </tr>
                                            <tr>
                                            <td><input type="checkbox" class="check" /></td>
                                                <td>Trident</td>
                                                <td>Internet
                                                    Explorer 5.5</td>
                                                <td>Win 95+</td>
                                                <td>5.5</td>
                                                <td>A</td>
                                            </tr>
                                           
                                    </table>

</body>
</html>