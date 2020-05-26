<?php

namespace App\Presenters;

use Nette\Application\UI;


final class HomepagePresenter extends BasePresenter
{

    protected function createComponentFilterForm()
    {
        $form = new UI\Form;
        $form->setMethod('GET');
        $form->addText('search', 'Hledat');
        $form->addSelect('order_by', 'Řadit podle', array(
            'order_no' => 'Doporučené',
            'newest' => 'Nejnovější',
            'lowest_price' => 'Nejnižší ceny',
            'highest_price' => 'Nejvyšší ceny'
        ))->setRequired(true);
        $form->addInteger('start_price', 'Cena od')->setHtmlAttribute('placeholder', 'Cena od');
        $form->addInteger('end_price', 'Cena do')->setHtmlAttribute('placeholder', 'Cena do');
        //$form->addCheckbox('in_stock', 'Skladem');


        $form->addRadioList('categories', 'Kategorie', [30 => 'kategorie1', 20 => 'kategorie2', 10 => 'kategorie3']); /*Itemy se nastaví renderu*/


        $form->addSubmit('filter', 'Filtrovat');
        $form->onSuccess[] = [$this, 'filterFormSucceeded'];
        return $form;
    }

    public function filterFormSucceeded($form, $values)
    {
        if($this->isAjax()){
            $this->redrawControl('filterFormArea');
            $this->redrawControl('filterForm');
            $this->payload->postGet = TRUE;
            $this->payload->url = $this->link('this', $this->getParameters()); //muselo se tam dát natvrdo https protože jinak se tam dávalo http a to dělalo problém při pushState
        }
    }
}
