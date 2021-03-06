<?php

/**
 * Test class for PlayoffTree.
 * Generated by PHPUnit on 2012-02-01 at 11:37:01.
 * @group playoff
 */
class PlayoffTreeTest extends PHPUnit_Framework_TestCase {

    /** @var PlayoffGenerator */
    protected $generator;
    /** @var PlayoffTree */
    protected $object;
    
    protected function setUp() {
        $this->generator = PlayoffGenerator::create(array('A', 'B', 'C', 'D'));
        $this->object = new PlayoffTree($this->generator);
    }

    public function test__construct() {
        parent::assertInstanceOf('PlayoffTree', $this->object);
        
        $invalid_values = array('a', null, false, array(), new Exception());
        foreach ($invalid_values as $value) {
            $this->invalid_arguments($value);
        }
    }
    
    public function testGet_array() {
        $result_array = $this->object->get_array();
        parent::assertArrayHasKey('team_count', $result_array);
        parent::assertArrayHasKey('round_count', $result_array);
        parent::assertArrayHasKey('rounds', $result_array);
        
        foreach ($result_array['rounds'] as $round) {
            foreach ($round as $match) {
                parent::assertTrue(in_array($match['home'], $this->generator->get_teams()));
                parent::assertTrue(in_array($match['away'], $this->generator->get_teams()));
            }
        }
    }
    
    private function invalid_arguments($argument) {
        try {
            new PlayoffTree($argument);
            parent::fail('This test did not fail as expected');
        } catch (PlayoffException $e) {
            parent::assertEquals($e->getCode(), PlayoffException::EXC4);
        }
    }

}

?>
