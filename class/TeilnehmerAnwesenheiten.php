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


    public function updateTeilnehmerForOneMonth(int $teilnehmerId, int $month, int $year, array $days): bool
    {


    }
}