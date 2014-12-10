<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
	'Register',
);
?>
<form action="<?php echo $this->createUrl("site/register");?>" method="post">
<div>
    <label>First name</label>
    <input type="text" name="firstname" /></br>
    <label>Last name</label>
    <input type="text" name="lastname" /></br>
    <label>Email</label>
    <input type="text" name="email" /></br>
    <label>Password</label>
    <input type="password" name="password" /></br>
    <label>confirm password</label>
    <input type="password" name="re_pass" /></br>
    <input type="submit" name="submit"/>
</div>
</form>
