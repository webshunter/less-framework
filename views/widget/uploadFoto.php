<div class="modal fade" id="cropAvatarmodal<?= $data->id ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <div class="img-container">
            <img id="uploadedAvatar-<?= $data->id ?>" src="https://avatars0.githubusercontent.com/u/3456749">
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop-<?= $data->id ?>">Crop</button>
        </div>
    </div>
    </div>
</div>

<div class="col-5 col-sm-12" style="position: relative;">
    <div class="w-100" id="autosize-img-<?= $data->id ?>" style="display:inline-block;width: fit-content; height: fit-content;overflow:hidden;border-radius:50%;margin:0;padding:0;">
    <img style="margin:0;padding:0;" id="profile-img-<?= $data->id ?>" class="w-100 mb-3" src="<?= $profile ?>">
    </div>
    <label style="position: absolute; bottom: 0; right:0; background: transparent; outline:none;border:none;" class="label custom-file-upload btn btn-light" data-toggle="tooltip" title="" data-original-title="Change foto profile">
    <input type="file" class="d-none" id="file-input-<?= $data->id ?>" name="image" accept="image/*">
    <i class="fa fa-camera"></i>
    </label>
</div>
<script>

  (function autosize(){
    var f = document.getElementById('autosize-img-<?= $data->id ?>');
    f.style.height = f.clientWidth+'px';
    setTimeout(function(){
      autosize();
    },100)
  })();

</script>