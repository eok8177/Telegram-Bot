<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\TelegramUser;
use App\Client;

class DashboardController extends Controller
{
    public function index() {
        return view('backend.index', [
            'clients' => Client::all(),
            'tUsers' => TelegramUser::all(),
        ]);
    }
}
