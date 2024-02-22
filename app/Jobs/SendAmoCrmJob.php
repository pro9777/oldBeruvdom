<?php

namespace App\Jobs;

use App\Contracts\Crm\AddLeadInterface;
use App\Contracts\Crm\AddNotesInterface;
use Darryldecode\Cart\CartCollection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAmoCrmJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private string $name,
        private string $number,
        private string $leadName,
        private CartCollection $products,
        private int $price = 0
    ) {
    }

    /**
     * @param AddLeadInterface $addLead
     *
     * @return void
     */
    public function handle(AddLeadInterface $addLead, AddNotesInterface $addNotes): void
    {
        $addLead = $addLead->add(
            name: $this->name,
            number: $this->number,
            leadName: $this->leadName . ' BVD',
            price: $this->price,
            tagName: 'BERUVDOM.RU',
        );
        $addNotes->add($addLead, $this->products);
//        dd($NotesCollection);
//        $test = new Amocrm();
//
//        $addRefreshToken = $test->addRefreshToken();
//
//        dump($addRefreshToken);
//
//        $idContact = Amocrm::addContact($this->params['value']);
//        dump($idContact);
//        $idTask = Amocrm::addTask($idContact, $this->params);
//        if (!empty($this->params['products'])) {
//            Amocrm::addLeads($idTask, $this->params['products']);
//        }

    }
}
