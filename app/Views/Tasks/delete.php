<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Delete task<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1>Delete task</h1>

<p>Are you sure?</p>

<form action="<?= site_url('tasks/delete/' . $task->id) ?>" method="post">

    <?= csrf_field() ?>
    
    <button type="submit">Yes</button>
    <a href="<?= site_url('tasks/show/' . $task->id) ?>">Cancel</a>
</form>

<?= $this->endSection() ?>