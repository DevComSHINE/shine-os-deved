<div class="tab-pane step" id="photos">
    <fieldset id="photobooth">
        <legend>Patient Photo</legend>
        @if(isset($patient))
        <?php
            if($patient->photo_url) {
                $pic = $patient->photo_url;
            } else {
                $pic = "noimage_male.png";
            }
        ?>
        <fieldset>
            <div class="col-sm-12">
                <p>Uploading or taking a photo of patient is the patient's and Health Facility's discretion. Rest assured that your patient's data is secured and shall not be used or shared elsewhere.</p>
                <p>You can upload a photo from your computer or take your photo using your PC's webcam.</p>
                <br />
                <div class="col-md-4 centered">
                    <div id="pat_img" class="profile_image profile_image_big">
                        <img src="{{ url(uploads_url().'patients/'.$pic) }}" class="profile_image">
                    </div>
                    <input type="hidden" id="pat_hid" name="pic_attachment_file_path" value="" />
                </div>
                <div class="col-sm-4 main-box-body clearfix">
                    <h3>Upload your photo:</h3>
                    <br />
                    <div class="centered">
                    <span class="fa fa-cloud-upload text-info" style="font-size:80px;"></span>
                    </div>
                    <div class="centered">
                    <br />
                    <input type="file" name="profile_picture" size="20" />
                    <br />
                    <input type="submit" value="Upload" class="btn btn-info" />
                    </div>
                </div>
                <div class="col-sm-4 main-box-body clearfix border-left">
                    <h3>Take your photo:</h3>
                    <br />
                    <div class="centered">
                    <span class="fa fa-camera text-info" style="font-size:80px;"></span>
                    </div>
                    <br /><br /><br />
                    <div class="centered">
                    <a href="#camerabox" class="btn btn-info custom_form cameraon" data-toggle="modal" data-target="#camerabox">Take</a>

                    </div>
                </div>
                <br clear="all" />
                <br />
            </div>

        </fieldset>
        @else
        <div class="col-sm-12">
            <p class="small">Patient photo should be specifically approved and allowed by the patient before photo is taken. Assure patient that all data provided including his or her photo will be kept for privacy and shall not be shared with any other project.</p>
            <blockquote>
            <p class="text-danger"><mark>Save the patient data</mark> first before capturing patient's photo.</p>
            </blockquote>
            <br />
            <div class="col-md-4 centered">
                <div id="pat_img" class="profile_image profile_image_big" style="background: url('content/uploads/patients/') no-repeat center center;"></div>
                <input type="hidden" id="pat_hid" name="pic_attachment_file_path" value="" />
            </div>
            <br clear="all" />
            <br />
        </div>
        @endif
    </fieldset>
</div><!-- /.tab-pane -->
