<?php


namespace App;


class FormHelper
{

    public static function createSelectOptions($data, $selected = null)
    {
        foreach ( $data as $key => $value ) {
            $s = $key == $selected ? 'selected' : '';
            ?>
            <option value="<?= $key ?>" <?= $s ?>><?= $value ?></option>
            <?php
        }
    }

}