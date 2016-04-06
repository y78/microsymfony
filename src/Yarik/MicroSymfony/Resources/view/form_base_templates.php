<?php

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
    'text' => function ($form, \Yarik\MicroSymfony\Component\Form\FormView $view) { ?>
        <input type="text" name="<?=$form['name']?>" <?php form_value($form)?> <?php form_attributes($form)?> />
    <?php },
    'file' => function ($form, \Yarik\MicroSymfony\Component\Form\FormView $view) { ?>
        <input type="file" name="<?=$form['name']?>" <?php form_value($form)?> <?php form_attributes($form)?> />
    <?php },
    'integer' => function ($form, \Yarik\MicroSymfony\Component\Form\FormView $view) { ?>
        <input type="number" name="<?=$form['name']?>" <?php form_value($form)?> <?php form_attributes($form)?> />
    <?php },
    'email' => function ($form, \Yarik\MicroSymfony\Component\Form\FormView $view) {?>
        <input type="email" name="<?=$form['name']?>" <?php form_value($form)?> <?php form_attributes($form)?> />
    <?php },
    'choice' => function ($form, \Yarik\MicroSymfony\Component\Form\FormView $view) {?>
        <select name="<?=$form['name']?>" <?php form_attributes($form)?>>
            <?php foreach ($form['choices'] as $key => $value) { ?>
                <option value="<?=$key?>" <?= isset($form['value']) && $form['value'] == $key ? 'selected' : '' ?> ><?=$value?></option>
            <?php } ?>
        </select>
    <?php },
    'textarea' => function ($form, \Yarik\MicroSymfony\Component\Form\FormView $view) {?>
        <textarea name="<?=$form['name']?>" <?php form_attributes($form)?>><?=isset($form['value']) ? $form['value'] : ''?></textarea>
    <?php },
];
