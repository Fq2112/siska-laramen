<?php
/**
 * Created by PhpStorm.
 * User: fiqy_
 * Date: 5/28/2018
 * Time: 12:20 AM
 */

namespace App\Support;

class Chart
{

    public function parse($data, $withPercent = true)
    {
        $newData = [];

        $total = $this->getTotalCount($data);

        foreach ($data as $key => $value) {
            if ($withPercent) {
                array_push($newData, [
                    $key . ' (' . number_format($this->getPercent($value, $total), 2) . '%)',
                    $value
                ]);
            } else {
                array_push($newData, [
                    $key, $value
                ]);
            }
        }

        return collect($newData);
    }

    private function getTotalCount($data)
    {
        $sum = 0;

        foreach ($data as $key => $value)
            $sum += $value;

        return $sum;
    }

    private function getPercent($part, $sum)
    {
        return $part / $sum * 100;
    }

}