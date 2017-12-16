<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 12/16/17
 * Time: 19:09
 */

namespace App\Jobs;


use App\Firebase\FirebaseTooManyRequestException;

abstract class FirebaseJob extends Job
{
    public function handle()
    {
        try {
            $this->fire();
        } catch (FirebaseTooManyRequestException $exception) {
            $this->release(self::DELAY);
            return;
        } catch (\Exception $exception) {
            $this->fail($exception);
        }
    }
}