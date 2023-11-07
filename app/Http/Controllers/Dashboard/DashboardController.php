<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardGoal()
    {
        // Menghitung total category / total contact
        $totalContact = DB::table('contact_categories')
            ->select(DB::raw('count(distinct category_id) as count'))
            ->get();

        // Check if $totalContact is not null before accessing its properties
        $totalContactCount = $totalContact->count();
        // $totalContactCount = $totalContact ? $totalContact->count : 0;

        // Menghitung total total template
        $totalMessageTemplate = DB::table('message_templates')
            ->select(DB::raw('count(*) as count'))
            ->get();

        // Check if $totalMessageTemplate is not null before accessing its properties
        $totalMessageTemplateCount = $totalMessageTemplate->count();

        // Menghitung total task
        $totalCompletedTasks = DB::table('tasks')
            ->select('user_id')
            ->selectRaw('count(*) as count')
            ->where('status', 'Completed')
            ->groupBy('user_id')
            ->get();

        // Check if $totalCompletedTasks is not null before accessing its properties
        $totalCompletedTasksCount = $totalCompletedTasks->count();

        // Menghitung total event yang akan datang
        $upcomingEvent = DB::table('events')
            ->select('user_id')
            ->selectRaw('count(*) as count')
            ->where('start_date', '>', Carbon::now())
            ->groupBy('user_id')
            ->get();

        // Check if $upcomingEvent is not null before accessing its properties
        $upcomingEventCount = $upcomingEvent->count();

        // Menyusun hasil dalam format yang diinginkan
        $result = [
            [
                'name' => 'contact',
                'count' => $totalContactCount,
                'total' => $totalContactCount
            ],
            [
                'name' => 'template',
                'count' => $totalMessageTemplateCount,
                'total' => $totalMessageTemplateCount
            ],
            [
                'name' => 'task',
                'count' => $totalCompletedTasksCount,
                'total' => $totalCompletedTasksCount
            ],
            [
                'name' => 'event',
                'count' => $upcomingEventCount,
                'total' => $upcomingEventCount,
            ],
        ];

        if (true) {
            return response()->json([
                'data' => $result,
                'message' => 'Successfully',
                'status' => true,
            ]);
        } else {
            return response()->json([
                'message' => 'Failure Message',
                'status' => false,
            ]);
        }
    }



    public function dashboardUpComingEvent()
    {
        // 5 aktivitas yang akan datang
        $fiveUpComingEvent = DB::table('events')
            ->select(DB::raw('start_date, count(*) as limaAktifitasAkanDatang'))
            ->groupBy('start_date')
            ->take(5)
            ->get();

        $fiveUpComingEventCount = $fiveUpComingEvent->count();

        $result2 = [
            [
                'name' => 'event',
                'count' => $fiveUpComingEventCount,
                'total' => $fiveUpComingEventCount
            ]
        ];

        return response()->json([
            'message' => 'Successfully',
            'status' => true,
            'data' => $result2
        ]);
    }

    public function updateDailyTask()
    {
        // task harian
        $totalTaskDaily = DB::table('tasks')
            ->select(DB::raw('user_id, count(*) as total_Task_Daily'))
            ->where('status', 'Completed')
            ->groupBy('user_id', 'status')
            ->get();

        $totalTaskDailyCount = $totalTaskDaily->count();

        $result3 = [
            [
                'name' => 'task',
                'count' => $totalTaskDailyCount,
                'total' => $totalTaskDailyCount
            ],
        ];

        return response()->json([
            'message' => 'Successfully',
            'status' => true,
            'data' => $result3
        ]);
    }
}
