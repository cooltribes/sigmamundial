<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<form class="form-signin" role="form">
    <h2 class="form-signin-heading">Sigma Mundial</h2>
    <input type="email" class="form-control" placeholder="Email address" required="" autofocus="">
    <input type="password" class="form-control" placeholder="Password" required="">
    <label class="checkbox">
        <input type="checkbox" value="remember-me"> Remember me
    </label>
    <button class="btn btn-lg btn-primary btn-block btn-ttc" type="submit">Entrar</button>
</form>