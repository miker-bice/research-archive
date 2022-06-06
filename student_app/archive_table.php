<!-- this is the archives table -->
<div id="archives-table py-4 px-3">
    <!-- this is the hearder of the card -->
    <div class="archive-header d-flex justify-content-between">
        <div class="title">
            <h2 class="text-primary">Archive List</h2>
        </div>
        <div class="upload-btn">
            <button class="btn btn-primary">Upload File</button>
        </div>
    </div>
    <div class="archive-form ">
        <hr class="bg-primary">
        <div class="d-flex">
            <input id="filter-value" class="form-control mx-2" type="text" placeholder="Title">

            <input id="filter-value" class="form-control mx-2" type="text" placeholder="Year Level">

            <input id="filter-value" class="form-control mx-2" type="text" placeholder="Department">

            <button class="btn btn-primary mx-2" id="filter-clear">Clear Filter</button>
        </div>

        <div class="mt-3" id="example-table"></div>
    </div>
</div>