<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Signup<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="title">Forgot password</h1>

<?= form_open("/password/processforgot") ?>

<?= csrf_field() ?>

    <div>
        <label for="email">email</label>
        <input type="text" name="email" id="email" value="<?= old('email') ?>">
    </div>

    <button>Send</button>
<?= form_close() ?>

<?= $this->endSection() ?> 