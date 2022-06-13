<!-- this is the uploads -->
<div id="archives-table py-4 px-3">
    <!-- this is the hearder of the card -->
    <div class="archive-header d-flex justify-content-between">
        <div class="title">
            <h2 class="text-primary">Submit Research</h2>
        </div>
        <div class="upload-btn">
            <a href="./upload_archive.php" class="btn text-white btn-primary">Upload File</a>
        </div>
    </div>
    <div class="archive-form ">
        <hr class="bg-primary">
        <form>
            <div class="form-group">
                <label for="exampleFormControlInput1">Research Title</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Sample Research Title">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Academic Year</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="2022">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">College Department</label>
                <select class="form-control" id="exampleFormControlSelect1">
                    <option>Department of Computer and Informatics</option>
                    <option>Department of Business and Accountancy</option>
                    <option>Department of Arts, Sciences and Teacher Education</option>
                </select>
            </div>

            <!-- add the rich text editor here (use tinymce) -->
            <div id="header_text"></div>
            
        </form>

        <div class="mt-3" id="example-table"></div>
    </div>
</div>