<?php

namespace App\Contracts\Crm;

use AmoCRM\Models\Unsorted\FormUnsortedModel;

/** Добавление сделки */
interface AddLeadInterface
{
    /**
     * @param string $name
     * @param string $number
     * @param string $leadName
     * @param int $price
     * @param string $tagName
     * @param string $SourceName
     *
     * @return FormUnsortedModel
     */
    public function add(
        string $name,
        string $number,
        string $leadName,
        int $price = 0,
        string $tagName = '',
        string $SourceName = 'Beruvdom.ru'
    ): FormUnsortedModel;
}
