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
     * Checks if double period should be allowed
     * @var bool
     */
    private $allowDoublePeriods = true;

    /**
     * String to be used to denote free / empty periods
     * @var string
     */
    protected $emptyIndicator = '-';

    /**
     * Indicates if timetable is for department or level
     *
     * @var
     */
    protected $is_general;

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
     * Saves level wide courses
     * @var null
     */
    protected $levelWideCourses = null;

    /**
     * Individual courses represented as a whole
     * in multiples of their units...
     * @var
     */
    protected $chromosomes;

    /**
     * Store locations for each break element
     * @var array
     */
    protected $break = ['B', 'R', 'E', 'A', 'K'];

    /**
     * Holds a list of all available venues
     *
     * @var array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    protected $venues = [];

    /**
     * Holds the instance of the venue model
     *
     * @var
     */
    protected $venue;

    protected $hasDoublePeriod = [];

    /**
     * TimeTableGenerator constructor.
     * @param array $gene
     */
    public function __construct(array $gene)
    {
        $this->gene = $gene;
        $this->indexOfBreak = (new Setting())->getByKey('break_time');
        $this->initializeTimeTable();
        $this->venue = new Venue();

        $this->venues = $this->venue->all();

        return $this;
    }

    /**
     * Allow or disallow double periods.
     * @param bool $allow
     */
    public function allowDoublePeriods($allow = true)
    {
        $this->allowDoublePeriods = $allow;
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
     * Add level wide courses if they exists
     * @param $courses
     * @return $this
     */
    public function levelWideCourse($courses)
    {
        $this->levelWideCourses = $courses;
        return $this;
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

        return $totalUnits <= ($totalSlots - 5);
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
                $indicator = $this->emptyIndicator;
                if ($z == $this->indexOfBreak) $indicator = $this->break[$y];
                if ($this->hasLevelWideCourses()) {
                    if ($this->levelWideCourses[$y][$z] != '-') $indicator = $this->levelWideCourses[$y][$z];
                }
                $this->timeTable[$y][$z] = $indicator;
            }
        }
        return $this;
    }

    /**
     * Checks if the level wide courses is not null
     * @return bool
     */
    public function hasLevelWideCourses()
    {
        return $this->is_general == "0" ? false : true;
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
                    if ($this->isBreakTimeZone($seed)) continue;
                    $row = (int) ($seed / $this->sizeOfDay);
                    $col = $seed % $this->sizeOfDay;

                    if ($this->hasLevelWideCourses() && $this->levelWideCourses[$row][$col] != '-') {
                        $this->timeTable[$row][$col] = $this->levelWideCourses[$row][$col];
                    } else {
                        $this->timeTable[$row][$col] = $this->chromosomes[$x];
                    }
                    if (isset($this->chromosomes[$x + 1])){
                        if ($this->chromosomes[$x + 1] === $this->chromosomes[$x] && !$this->hasUsedDoublePeriods($this->chromosomes[$x])) {
                            $this->timeTable[$row][$col + 1] = $this->chromosomes[$x];
                            $this->hasDoublePeriod[] = $this->chromosomes[$x];
                        }
                    }

                    $this->usedSlots[] = $seed;

                    $this->selectVenue($this->chromosomes[$x], $row, $col);
                }
            }
        }
        return $this;
    }

    /**
     * Check if the seed falls withing the break time zone
     * @param $seed
     * @return bool
     */
    public function isBreakTimeZone($seed)
    {
        if ($seed < $this->sizeOfDay)
            return $seed == $this->indexOfBreak;
        return ($seed - $this->sizeOfDay) % $this->indexOfBreak === 0;
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
     * @param $dept
     * @return \array[][]
     */
    public function generate($dept)
    {
        $this->is_general = $dept;
        if (!$this->slotsAreEnough()) {
            abort(500, 'The number of units exceed the available spaces.');
        }
        $this->makeChromosomes();
        $this->createInitialGeneration();
        $this->startSelection();
        return $this->timeTable;
    }

    /**
     * Intelligently select a venue for a schedule
     *
     * @param $course_id
     * @param $day
     * @param $period
     */
    public function selectVenue($course_id, $day, $period)
    {
        $venueCount = count($this->venues);
        $found = false;
        $iteration = 0;

        while ($found === false) {
            $iteration++;
            if ($iteration > $venueCount) break;

            $seed = rand(0, $venueCount - 1);
            $selected = $this->venues[$seed];

            if (! $selected->hasBeenAssignedOn($day, $period)) {
                $selected->markAsAssignedOn($course_id, $day, $period);
                $found = true;
            }
        }
    }

    public function hasUsedDoublePeriods($course)
    {
        return in_array($course, $this->hasDoublePeriod);
    }
}