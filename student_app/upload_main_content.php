<!-- this is the uploads -->
<div id="archives-table py-4 px-3">
    <!-- this is the hearder of the card -->
    <div class="archive-header d-flex justify-content-between">
        <div class="title">
            <h2 class="text-primary">Submit Research</h2>
        </div>
        <div class="upload-btn">
            
        </div>
    </div>
    <div class="archive-form ">
        <hr class="bg-primary">
        <div>
            <div class="form-group">
                <label for="research-title">Research Title</label>
                <input type="text" class="form-control" id="research-title" name="research-title" placeholder="Sample Research Title">
            </div>
            <div class="form-group">
                <label for="research-year">Academic Year</label>
                <input type="text" class="form-control" id="research-year" name="research-year" placeholder="2022">
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
            <label for="research-abstract">Research Abstract</label>
            <div id="header_text" name="research-abstract" id="research-abstract"></div>

            <div class="form-group">
                <label for="research-authors">Authors</label>
                <input type="textarea" class="form-control" name="research-authors" id="research-authors" placeholder="Juan Dela Cruz">
            </div>

            <div class="form-group">
                <label for="research-authors">Upload</label>
                <br>
                <div id="traditional-uploader"></div>
            </div>
            
            <div>
                <button id="submit-research" class="btn text-white btn-primary">Upload</button>
            </div>
        </div>

        <div class="mt-3" id="example-table"></div>
    </div>
</div>