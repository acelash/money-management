<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

        if (method_exists($this, 'boot')) {
            // resolve the boot dependencies
            $reflect = new \ReflectionMethod($this, 'boot');
            $reflectedParameters = $reflect->getParameters();

            $bootArguments = [];

            foreach ($reflectedParameters as $reflectedParameter) {
                preg_match("/.*<required> (.+) \\\${$reflectedParameter->getName()}/", $reflectedParameter, $typeHint);

                if (count($typeHint) == 2) {
                    $className = $typeHint[1];
                    $resolved = app()->make($className);

                    array_push($bootArguments, $resolved);
                }
            }


            call_user_func_array([&$this, 'boot'], $bootArguments);
        }
    }
}
