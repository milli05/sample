<?php

/**
 * Game of Life in PHP
 * @package hacker-mom\phpgameoflife
 * @author hacker-mom
 * @since PHP 7.x
 * @license http://opensource.org/licenses/MIT
 *
 */
require('lib/Cell.php');
class World{
    protected $xSize;
    protected $ySize;
    protected $percentage;
    protected $iteration;
    protected $cells;

    public function __construct(){
        $this->precentage = 20;
        $this->seed();
    }

    protected function seed(){
        for($y = 1; $y <= 100; $y++) {
            print '<div class="row">';
                foreach($this->rowGen($y) as $val){
                    echo $val;
                }
            print '</div>';
        }
    }


    protected function rowGen($y){
        for ($x = 1; $x <= 100; $x++) {
            $random = mt_rand(0, 100);
            if($random < $this->precentage) {
                $state = 1;
            }else{
                $state = 0;
            }
            $this->cells[$x][$y] = new Cell($x, $y, $state);
            yield   $this->cells[$x][$y];

        }
    }

    public function tick()
    {
        //Parse the existing state of the map for the game rules
        for ($y = 1; $y < 100; $y++) {
            print '<div class="row">';
            for ($x = 1; $x < 100; $x++) {
                $currentState = $this->cells[$x][$y]->getState();
                if($x == 1 && $y == 1){
	                $liveNeighbors = ($this->cells[$x + 1][$y]->getState()
	                                 +  $this->cells[$x][$y + 1]->getState() + $this->cells[$x + 1][$y + 1]->getState())*2;
                }elseif($x >1 && $y == 1){
		            $liveNeighbors =  $this->cells[$x - 1][$y]->getState() + $this->cells[$x + 1][$y]->getState()
		                             + $this->cells[$x - 1][$y + 1]->getState() + $this->cells[$x][$y + 1]->getState() + $this->cells[$x + 1][$y + 1]->getState();

	            }elseif($x == 1 && $y > 1){
	                $liveNeighbors =  $this->cells[$x][$y - 1]->getState() + $this->cells[$x + 1][$y - 1]->getState()
	                              + $this->cells[$x + 1][$y]->getState()
	                                 +  $this->cells[$x][$y + 1]->getState() + $this->cells[$x + 1][$y + 1]->getState();

                }else{
	                $liveNeighbors = $this->cells[$x - 1][$y - 1]->getState() + $this->cells[$x][$y - 1]->getState() + $this->cells[$x + 1][$y - 1]->getState()
	                                 + $this->cells[$x - 1][$y]->getState() + $this->cells[$x + 1][$y]->getState()
	                                 + $this->cells[$x - 1][$y + 1]->getState() + $this->cells[$x][$y + 1]->getState() + $this->cells[$x + 1][$y + 1]->getState();

                }

                if(isset($this->cells[$x][$y])) {
                    if ($liveNeighbors < 2) {
                        $this->cells[$x][$y]->setState(0);
                    } elseif ($liveNeighbors < 4 && $currentState) {
                        $this->cells[$x][$y]->setState(1);
                    } elseif ($liveNeighbors == 3) {
                        $this->cells[$x][$y]->setState(1);
                    } else {
                        $this->cells[$x][$y]->setState(0);
                    }
                }
                print  $this->cells[$x][$y];
            }
            print '</div>';
        }
        //Persist the updated map
       /* for ($y = 0; $y < $this->ySize; $y++) {
            for ($x = 0; $x < $this->xSize; $x++) {
                $this->cells[$x][$y]->persist();
            }
        }*/
    }

}

