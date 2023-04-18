<?php
    use NN\Session;
    use NN\Module\DB;
?>
<?php $this->layout('temp/layout', ['title' => 'LOGIN PROGRAM ABSENSI']) ?>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-sm-8 col-lg-6">
            <div class="card mt-100">
                <div class="card-body">
                    <?php $this->insert('landing/info/info') ?>
                    <h3>LOGIN</h3>
                    <h4 class="text-dark-1">PROGRAM ABSENSI SISWA</h4>
                    <form action="<?= PATH ?>/login/proccess" method="post">
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
                                    </div>
                                    <input type="username" autocomplete="off" name="username" class="form-control" id="username" placeholder="Username" aria-describedby="validationTooltipUsernamePrepend" required>
                                    <div class="invalid-tooltip">
                                    Please choose a unique and valid username.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
                                    </div>
                                    <input type="password" autocomplete="off" name="password" class="form-control" id="password" placeholder="Password" aria-describedby="validationTooltipUsernamePrepend" required>
                                    <div class="invalid-tooltip">
                                    Please choose a unique and valid username.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="<?= PATH ?>/forgot/password">forgout password</a>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->push('scripts'); ?>

<?php if(Session::get('message') != '') : ?>
<script>
    $("#openinfo").modal('show');
</script>
<?php endif; ?>
<?php
    Session::delete('message');
?>
<?php $this->end(); ?>
