<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
Use \Carbon\Carbon;
use App\Charts\UserChart;

class dataController extends Controller
{
    public function index()
    {

        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)"

        ];

        $respone = Http::get('https://api.kawalcorona.com/indonesia/provinsi');
        // $respones = Http::get('https://api.kawalcorona.com/sembuh');
        $globalrespone = Http::get('https://api.kawalcorona.com/indonesia');


        $worldpositif = Http::get('https://api.kawalcorona.com/positif');
        $worldsembuh = Http::get('https://api.kawalcorona.com/sembuh');
        $worldmeninggal = Http::get('https://api.kawalcorona.com/meninggal');


        $datas = $respone->json();
        $global = $globalrespone->json();
        $pos = $worldpositif->json();
        $sem = $worldsembuh->json();
        $men = $worldmeninggal->json();

        \Carbon\Carbon::setLocale('id');
        $date = Carbon::now()->format('l, d F Y H:i');
        // dd($date);
        // $usersChart = new UserChart;
        // $usersChart->minimalist(true);
        // $usersChart->labels(['Positif']);
        $p;
        $s;
        $m;
       
        foreach ($global as $key) {
                $p=str_replace(",","",$key['positif']);
                $s=$key['sembuh'];
                $m=$key['meninggal'];
            }
        $usersChart = new UserChart;
        $usersChart->minimalist(true);
        $usersChart->displaylegend(true);
        $usersChart->labels(['Meninggal', 'Sembuh', 'Positif']);
        $usersChart->dataset('Users by trimester', 'doughnut', [$m, $s, $p])
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        return view('utama/index', compact('datas', 'global', 'pos', 'sem', 'men', 'date', 'usersChart'));
    }
}
