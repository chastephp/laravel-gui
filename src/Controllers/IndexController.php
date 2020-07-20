<?php
/**
 * User: widdy
 * Date: 2019/11/1
 * Time: 23:36
 */

namespace ChastePhp\LaravelGUI\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{

    public function index()
    {
        Artisan::call('list --format=json');
        $commands = json_decode(Artisan::output(), true);
        return view('gui::index', ['commands' => $commands['commands']]);
    }

    public function execute()
    {
        $command = request('command');

        Artisan::call($command);
        $log = Artisan::output();
        return Response::json([
            'code' => 0,
            'message' => 'success',
            'data' => $log
        ]);
    }

}
