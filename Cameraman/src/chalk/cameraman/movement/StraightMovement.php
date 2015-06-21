<?php

/**
 * @author ChalkPE <amato0617@gmail.com>
 * @since 2015-06-20 17:24
 */

namespace chalk\cameraman\movement;

use chalk\cameraman\Cameraman;
use pocketmine\math\Vector3;

class StraightMovement extends Movement {
    private $dx, $dy, $dz;
    private $distance, $d = 0;

    /**
     * @param Vector3 $origin
     * @param Vector3 $destination
     */
    function __construct(Vector3 $origin, Vector3 $destination){
        parent::__construct($origin, $destination);

        $this->dx = $this->getDestination()->getX() - $this->getOrigin()->getX();
        $this->dy = $this->getDestination()->getY() - $this->getOrigin()->getY();
        $this->dz = $this->getDestination()->getZ() - $this->getOrigin()->getZ();

        $this->distance = Cameraman::TICKS_PER_SECOND * max(abs($this->dx), abs($this->dy), abs($this->dz));
        if($this->distance === 0){
            throw new \InvalidArgumentException("distance cannot be zero");
        }
    }

    /**
     * @param number $slowness
     * @return Vector3|boolean
     */
    public function tick($slowness){
        $progress = $this->d++ / ($this->distance * $slowness);
        return ($progress > 1) ? false : $this->getOrigin()->add($this->dx * $progress, $this->dy * $progress, $this->dz * $progress);
    }

}