<?php
require '../config/config.php';
require GLOBAL_FUNC;
require CL_SESSION_PATH;
require CONNECT_PATH;
require VALIDATOR_PATH; // library for form validation


$g_user_role = $session_class->getValue('role_id');
include "redirect.php";

$csrf = new CSRF($session_class); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include DOMAIN_PATH."/app/global/meta_data.php";
        include DOMAIN_PATH."/app/global/include_top.php";
    ?>

</head>
<body class="bg-white">
    <!-- insert here the topbar -->
    <?php  include TOPBAR; ?>

    <!-- insert here the navbar -->
    <?php  include MAIN_NAVBAR; ?>

    <!-- insert here the main content of the page -->
    <div class="main-content mt-3 container">
        <?php  include ARCHIVE_TABLE; ?>
    </div>
    
    <!-- insert here the footer -->
    <?php  include BOTTOM_BAR; ?>
    
</body>
<?php include DOMAIN_PATH."/app/global/include_bottom.php"; ?>

<script>
    //Define some test data
var cheeseData = [
    {id:1, type:"Brie", rind:"mould", age:"10 weeks", color:"white", image:"SWRonin-Cover.webp", link:"id"},
    {id:2, type:"Cheddar", rind:"none", age:"1 year", color:"yellow", image:"cheddar.jpg", link:"id"},
    {id:3, type:"Gouda", rind:"wax", age:"6 months", color:"cream", image:"gouda.jpg", link:"id"},
    {id:4, type:"Swiss", rind:"none", age:"9 months", color:"yellow", image:"swiss.jpg", link:"id"},
]

//define Tabulator
var table = new Tabulator("#example-table", {
    height:"311px",
    layout:"fitColumns",
    columnDefaults:{
      resizable:true,
    },
    data:cheeseData,
    columns:[
        {title:"Cheese", field:"type", sorter:"string"},
    ],
    rowFormatter:function(row){
        var element = row.getElement(),
        data = row.getData(),
        width = element.offsetWidth,
        rowTable, cellContents;

        //clear current row data
        while(element.firstChild) element.removeChild(element.firstChild);

        //define a table layout structure and set width of row
        rowTable = document.createElement("table")
        rowTable.style.width = (width - 18) + "px";

        rowTabletr = document.createElement("tr");

        //add image on left of row
        cellContents = "<td  width='300'><img src='../images/research-covers/" + data.image + "' class='img-fluid' alt='cover-img' height='20'></td>";

        //add row data on right hand side
        cellContents += "<td style='padding: 1.5rem 0; padding-left: .75rem;'><div><strong>Title:</strong> " + data.type + "</div><div><strong>Age:</strong> " + data.age + "</div><div><strong>Rind:</strong> " + data.rind + "</div><div><strong>Colour:</strong> " + data.color + "</div><a href= " + data.link + ">Read more</a>" + "</td>"

        rowTabletr.innerHTML = cellContents;

        rowTable.appendChild(rowTabletr);

        //append newly formatted contents to the row
        element.append(rowTable);
    },
});
</script>
</html>