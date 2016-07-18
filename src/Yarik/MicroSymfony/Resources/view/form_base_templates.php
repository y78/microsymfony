<?php

use \Yarik\MicroSymfony\Component\Form\FormView;

function form_attributes($form)
{
    if (!isset($form['attr'])) {
        return;
    }

    foreach ($form['attr'] as $key => $value) {
        echo(' ' . $key . '="' . $value . '"');
    }
}

function form_value($form)
{
    if (!isset($form['value'])) {
        return;
    }

    echo ('value="' . $form['value'] . '"');
}

return [
    'text' => function ($form, FormView $view) { ?>
        <input type="text" name="<?=$form['name']?>" <? form_value($form)?> <? form_attributes($form)?> />
    <? },

    'file' => function ($form, FormView $view) { ?>
        <input type="file" name="<?=$form['name']?>" <? form_value($form)?> <? form_attributes($form)?> />
    <? },

    'integer' => function ($form, FormView $view) { ?>
        <input type="number" name="<?=$form['name']?>" <? form_value($form)?> <? form_attributes($form)?> />
    <? },

    'email' => function ($form, FormView $view) {?>
        <input type="email" name="<?=$form['name']?>" <? form_value($form)?> <? form_attributes($form)?> />
    <? },

    'checkbox' => function ($form, FormView $view) {?>
        <input type="checkbox" name="<?=$form['name']?>" <?=$form['value'] ? 'checked' : ''?> <? form_attributes($form)?> />
    <? },

    'choice' => function ($form, FormView $view) {
        $current = null;
        foreach ($form['choices'] as $value) {
            if ($value == $current) {
                $current = $value;
            }
        }
    ?>
        <select name="<?=$form['name']?>" <? form_attributes($form)?>>
            <option value="">-/-</option>
            <? foreach ($form['choices'] as $key => $value) {?>
                <option value="<?=$key?>" <?= isset($form['value']) && $form['value'] == $key ? 'selected' : '' ?> ><?=$value?></option>
            <? }?>
        </select>
    <? },

    'textarea' => function ($form, \Yarik\MicroSymfony\Component\Form\FormView $view) {?>
        <textarea name="<?=$form['name']?>" <? form_attributes($form)?>><?=isset($form['value']) ? $form['value'] : ''?></textarea>
    <? },
];
