<?php


namespace App\Core\Helpers;


class FormHelper
{
    /**
     * Renders dropdown options for select html component
     * @param array $items
     * @param null $selected
     */
    public static function renderDropdownOptions($items = [], $selected = null)
    {
        printf('<option value="-">SELECT</option>');
        foreach ( $items as $k => $v ) {
            $s = $k == $selected ? 'selected' : '';
            printf('<option value="%s" %s>%s</option>', $k, $s, $v);
        }
    }


    public static function required($message = "Required")
    {
        return sprintf("<span class='badge badge-danger'>%s</span>", $message);
    }

}


