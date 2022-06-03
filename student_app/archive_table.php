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
            <select id="filter-field" class="form-control">
                <option></option>
                <option value="name">Name</option>
                <option value="progress">Progress</option>
                <option value="gender">Gender</option>
                <option value="rating">Rating</option>
                <option value="col">Favourite Colour</option>
                <option value="dob">Date Of Birth</option>
                <option value="car">Drives</option>
                <option value="function">Drives & Rating < 3</option>
            </select>

            <select id="filter-type" class="form-control">
                <option value="=">=</option>
                <option value="<">
                    << /option>
                <option value="<=">
                    <=< /option>
                <option value=">">></option>
                <option value=">=">>=</option>
                <option value="!=">!=</option>
                <option value="like">like</option>
            </select>

            <input class="form-control" id="filter-value" type="text" placeholder="value to filter">

            <button class="btn btn-primary" id="filter-clear">Clear Filter</button>
        </div>

        <div id="example-table"></div>
    </div>
</div>