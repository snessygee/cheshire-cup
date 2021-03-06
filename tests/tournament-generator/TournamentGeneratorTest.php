<?php

/**
 * Test class for TournamentGenerator.
 * Generated by PHPUnit on 2012-05-18 at 19:19:19.
 * @group tournament
 */
class TournamentGeneratorTest extends PHPUnit_Framework_TestCase {

    /** @var TournamentGenerator */
    private $object;
    private $groups;

    protected function setUp() {
        $tempGroups = array(
            'GROUP A' => array('Makov', 'Pardubice', 'Liberec', 'Plzeň'),
            'GROUP B' => array('Londýn', 'Manchester', 'Glasgow', 'Dublin'),
            'GROUP C' => array('New York', 'Los Angeles', 'Detroit', 'Toronto', 'Test'),
        );
        $this->groups = array();
        foreach ($tempGroups as $name => $teams) {
            $g = new TournamentGroup();
            $g->setGroupName($name);
            foreach ($teams as $team) {
                $g->addTeam($team);
            }
            $this->groups[] = $g;
        }
        $this->object = TournamentGenerator::create($this->groups);
    }

    public function testCreate() {
        parent::assertInstanceOf('TournamentGenerator', $this->object);
        // teams must be array
        $this->assertCreate(null);
        // items can be only instances of TournamentGroup
        $this->assertCreate(array_merge($this->groups, array(null)));
        // at least 2 teams in every group
        $this->assertCreate(array_merge($this->groups, array(new TournamentGroup())));
    }

    public function testGetGroupSchedules() {
        parent::assertTrue(is_array($this->object->getGroupSchedules()));
        foreach ($this->object->getGroupSchedules() as $schedule) {
            parent::assertInstanceOf('SeasonSchedule', $schedule);
        }
    }

    public function testGetTournamentSchedule() {
        parent::assertInstanceOf('SeasonSchedule', $this->object->getTournamentSchedule());
    }

    public function testGenerate() {
        // ok
        $this->object->generate(1);
        $this->object->generate(1,2);
        // periods must be integer <SEASON_MIN_PERIODS, SEASON_MAX_PERIODS>
        $this->assertGenerate(null, 2);
        $this->assertGenerate(SEASON_MIN_PERIODS - 1, 2);
        // fields must be null OR integer <1, depends of number of teams>
        $this->assertGenerate(1, false);
        $this->assertGenerate(1, 200);
        $this->assertGenerate(1, 1);
    }

    private function assertCreate($groups) {
        $this->invalid_arguments(
                array('TournamentGenerator', 'create')
        );
    }
    
    private function assertGenerate($periodCount, $fieldCount) {
        $this->invalid_arguments(
                array($this->object, 'generate'),
                $periodCount, 
                $fieldCount
        );
    }

    private function invalid_arguments($callback, $firstParam = null, $secondParam = null) {
        try {
            call_user_func($callback, $firstParam, $secondParam);
            parent::fail('This test did not fail as expected');
        } catch (Exception $e) {
            parent::assertInstanceOf('TournamentException', $e);
        }
    }

}

?>