<?php

class TeilnehmerAnwesenheiten
{

    private Teilnehmer $teilnehmer;
    /**
     * @var Anwesenheit[]
     */
    private array $anwesenheiten;

    /**
     * @param Teilnehmer $teilnehmer
     * @param Anwesenheit[] $anwesenheiten
     */
    public function __construct(Teilnehmer $teilnehmer, array $anwesenheiten)
    {
        $this->teilnehmer = $teilnehmer;
        $this->anwesenheiten = $anwesenheiten;
    }


    public function updateTeilnehmerForOneMonth(array $days): bool
    {
        echo '<pre>';
        print_r($days);
        echo '</pre>';
        foreach ($days as $key => $day){
            echo '<br>' . ($key + 1) . ' ' . $day . ' ' .$this->anwesenheiten[$key]->getStatus(). ' ' . $day ;
            if ($this->anwesenheiten[$key]->getStatus() == $day){
                //echo ' gleich' .'<br>';
            } else {
                // jetzt Datensatz updaten
                echo $key;
                echo ' ungleich' .'<br>';

                $this->anwesenheiten[$key]->setDozentenId($_SESSION['userId']);
                $this->anwesenheiten[$key]->setStatus($day);


            }
        }
        return true;

    }
}