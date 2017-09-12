<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 9/11/17
 * Time: 20:25
 */

namespace App\Models\Exercises;


class CountExercise implements ExerciseInterface
{
    protected $times;
    protected $count;
    protected $weight;

    public function __construct(array $info)
    {
        try {
            $this->count = $info['count'];
            $this->times = $info['times'];
            $this->weight = $info['weight'];
        } catch (\Exception $e) {
            throw new \LogicException('Wrong exercise data');
        }
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getTimes(): int
    {
        return $this->times;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'times' => $this->times,
            'count' => $this->count,
            'weight' => $this->weight,
        ];
    }
}