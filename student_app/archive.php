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
<style>

    .tabulator-header-filter input[type=search]{
        border: none;
        border-radius: 5px;
        background-color: pink;
        padding: 2rem 0;
    }
</style>

<body class="bg-white py-0">
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
var researchData = [
    {id: 0, title:"Star Wars Visions: Ronin", authors:"Juan Dela Cruz", abstract:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo amet natus facilis blanditiis maxime repellendus earum qui eum error quae.", department:"Department", publishYear: "2022", image: "SWRonin-Cover.webp"},
    {id: 1, title:"Star Wars Visions: Ronin", authors:"Juan Dela Cruz", abstract:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo amet natus facilis blanditiis maxime repellendus earum qui eum error quae.", department:"Department", publishYear: "2022", image: "SWRonin-Cover.webp"},
    {id: 2, title:"Star Wars Visions: Ronin", authors:"Juan Dela Cruz", abstract:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo amet natus facilis blanditiis maxime repellendus earum qui eum error quae.", department:"Department", publishYear: "2022", image: "SWRonin-Cover.webp"},
    {id: 3, title:"Star Wars Visions: Ronin", authors:"Juan Dela Cruz", abstract:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo amet natus facilis blanditiis maxime repellendus earum qui eum error quae.", department:"Department", publishYear: "2022", image: "SWRonin-Cover.webp"},
]

//define Tabulator
var table = new Tabulator("#example-table", {
    height:"auto",
    layout:"fitColumns",
    paginationSize:10,
    pagination:"local",
    placeholder:"No data found, duck off", //enable pagination
    // paginationMode:"local", //enable remote pagination
    // ajaxURL:"http://testdata/data", //set url for ajax request
    // paginationSize:5, //optional parameter to request a certain number of rows per page
    // paginationInitialPage:1, //optional parameter to set the initial page to load
    columnDefaults:{
      resizable:true,
    },
    data:researchData,
    columns:[
        {title:"Cover", field:"image", formatter:function(cell, formatterParams, onRendered){

    return "<div class='p-2'><img class='infoImage img-fluid' src='<?php echo BASE_URL."images/research-covers/"; ?>" + cell.getValue() + "'></div>";
}, sorter:"string", headerFilter:true, headerFilterPlaceholder:"Title", hozAlign:"center"},
        {title:"Title", field:"title", sorter:"string", formatter:function(cell, formatterParams, onRendered){
    //cell - the cell component
    //formatterParams - parameters set for the column
    //onRendered - function to call when the formatter has been rendered
    
    return cell.getValue(); //return the contents of the cell;
},},
        {title:"Authors", field:"authors", sorter:"string"},
        {title:"Abstract", field:"abstract",formatter:"textarea", sorter:"string"},
    ],
    // rowFormatter:function(row){
    //     var element = row.getElement(),
    //     data = row.getData(),
    //     width = element.offsetWidth,
    //     rowTable, cellContents;

    //     //clear current row data
    //     while(element.firstChild) element.removeChild(element.firstChild);

    //     //define a table layout structure and set width of row
    //     rowTable = document.createElement("table")
    //     rowTable.style.width = (width - 18) + "px";

    //     rowTabletr = document.createElement("tr");

    //     //add image on left of row
    //     cellContents = "<td align='center'><img src='../images/research-covers/" + data.image + "' class='col-image' alt='cover-img' width='100'></td>";
        

    //     //add row data on right hand side
    //     // cellContents += "<td style='padding: 1.5rem 0; padding-left: .75rem;'><div><h2>" + data.title + "</h2></div><div><strong>Abstract:</strong> <p width='80'>" + data.abstract + "</p></div><div><strong>Rind:</strong> " + data.rind + "</div><div><strong>Colour:</strong> " + data.color + "</div><a href= " + data.id + ">Read more</a>" + "</td>"

    //     cellContents += "<td class='pl-3'><div><h2>" + data.title + "</h2></div></td>"
    //     rowTabletr.innerHTML = cellContents;

    //     rowTable.appendChild(rowTabletr);

    //     //append newly formatted contents to the row
    //     element.append(rowTable);
    // },

    rowClick:function(e, row){
        window.open("test.php");
    },

});


</script>
</html>