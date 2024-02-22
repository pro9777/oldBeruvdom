<?php

namespace App\Contracts\Crm;

use AmoCRM\Collections\NotesCollection;
use AmoCRM\Models\Unsorted\FormUnsortedModel;
use Darryldecode\Cart\CartCollection;

/** Добавление примечания */
interface AddNotesInterface
{

    public function add(FormUnsortedModel $formUnsortedModel, CartCollection $products): NotesCollection;
}
