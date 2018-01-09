<?php

namespace App;

class TimeTableGenerator {

    /**
     * Number of hours that make up an academic day
     * @var int
     */
    protected $sizeOfDay = 9;

    /**
     * Number of days in an academic week
     * @var int
     */
    protected $daysOfWeek = 5;

    /**
     * Array index to use as break time
     * @var int
     */
    protected $indexOfBreak = 6;

    /**
     * Number of hours to use for break
     * @var int
     */
    protected $numOfHoursForBreak = 1;

    /**
     * String to be used to denote free / empty periods
     * @var string
     */
    protected $emptyIndicator = '-';

    /**
     * The timetable object to store the final result
     * @var array[][]
     */
    protected $timeTable;

    /**
     * Keep track of slots that have prefilled data
     * so that they cannot be reassigned...
     * @var array
     */
    protected $usedSlots = [];

    /**
     * The gene data. Typically gotten from the database.
     * In this case, the courses
     * @var
     */
    protected $gene;

    /**
     * Individual courses represented as a whole
     * in multiples of their units...
     * @var
     */
    protected $chromosomes;

    /**
     * TimeTableGenerator constructor.
     * @param array $gene
     */
    public function __construct(array $gene)
    {
        $this->gene = $gene;
        $this->initializeTimeTable();
        return $this;
    }

    /**
     * Initialize the timetable array object
     * @return array
     */
    public function initializeTimeTable()
    {
        return $this->timeTable = array(array(), array());
    }

    /**
     * This method compares the available slots
     * with the total number of units.
     * @return bool
     */
    private function slotsAreEnough()
    {
        $totalUnits = 0;
        $totalSlots = ($this->sizeOfDay * $this->daysOfWeek) - $this->daysOfWeek;

        foreach ($this->gene as $gene) {
            $totalUnits += $gene['units'];
        }

        return $totalUnits <= $totalSlots;
    }

    /**
     * Split the genes into chromosomes.
     * In this case, split the courses
     * into individual entities.
     */
    private function makeChromosomes()
    {
        $chromosomes = array();
        foreach ($this->gene as $gene) {
            for ($x = 0; $x < $gene['units']; $x++) {
                $chromosomes[] = $gene['code'];
            }
        }
        $this->chromosomes = $chromosomes;
        return $this;
    }

    /**
     * Create an initial generation with zero elements
     * @return $this
     */
    private function createInitialGeneration()
    {
        for ($y = 0; $y < $this->daysOfWeek; $y++) {
            for ($z = 0; $z < $this->sizeOfDay; $z++) {
                $this->timeTable[$y][$z] = $this->emptyIndicator;
            }
        }
        return $this;
    }

    /**
     * Perform the actual schedule
     * @return TimeTableGenerator
     */
    private function startSelection()
    {
        $totalSlot = $this->daysOfWeek * $this->sizeOfDay;
        $size = count($this->chromosomes);

        for ($x = 0; $x < $size; $x++) {
            $seed = rand(1, $totalSlot);

            for ($y = 0; $y < $this->daysOfWeek; $y++) {
                for ($z = 0; $z < $this->sizeOfDay; $z++) {
                    if ($this->hasAssigned($seed)) continue;
                    $row = (int) ($seed / $this->sizeOfDay);
                    $col = $seed % $this->sizeOfDay;
                    $this->timeTable[$row][$col] = $this->chromosomes[$x];
                }
            }
        }
        return $this;
    }

    /**
     * Check if a seed has already been assigned
     * @param $seed
     * @return bool
     */
    private function hasAssigned($seed){
        return in_array($seed, $this->usedSlots);
    }

    /**
     * Call necessary methods and return the timetable array
     * @return \array[][]
     */
    public function generate()
    {
        if (!$this->slotsAreEnough()) {
            abort(500, 'The number of units exceed the available spaces.');
        }
        $this->makeChromosomes();
        $this->createInitialGeneration();
        $this->startSelection();
        return $this->timeTable;
    }
}