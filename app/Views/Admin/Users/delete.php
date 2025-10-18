<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Delete User<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Delete User</h1>

<p>Are you sure?</p>

<form action="<?= site_url('/admin/users/delete/' . $user->id) ?>" method="post">

    <?= csrf_field() ?>
    
    <button type="submit">Yes</button>
    <a href="<?= site_url('/admin/users/show/' . $user->id) ?>">Cancel</a>
</form>

<?= $this->endSection() ?>