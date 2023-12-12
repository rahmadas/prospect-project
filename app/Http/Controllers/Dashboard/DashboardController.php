<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    public function dashboardGoal()
    {
        // $result = Dashboard::where('user_id', auth()->user()->id)->orderBy('user_id', 'asc');
        // Menghitung total category / total contact
        $totalContact = DB::table('contact_categories')
            ->select(
                DB::raw('count(distinct category_id) as count_category'),
                DB::raw('count(*) as count_total')
            )
            ->get();

        // Access the counts
        $totalCategoryCount = $totalContact[0]->count_category;
        $totalTotalCount = $totalContact[0]->count_total;

        // Menghitung total total template
        $totalMessageTemplate = DB::table('message_templates')
            ->select(DB::raw('count(*) as count_message_template'))
            ->get();

        // Check if $totalMessageTemplate is not null before accessing its properties
        $totalMessageTemplateCount = $totalMessageTemplate[0]->count_message_template;

        // Menghitung total task yang diselesaikan
        $totalCompletedTasks = DB::table('tasks')
            ->select(
                DB::raw('user_id, count(*) as count_task_completed')
            )
            ->where('status', 'Completed')
            ->groupBy('user_id')
            ->get();

        // Menghitung total semua task
        $totalTasks = DB::table('tasks')
            ->select(
                DB::raw('user_id, count(*) as total_tasks')
            )
            ->groupBy('user_id')
            ->get();
        if (!$totalCompletedTasks->isEmpty()) {
            $totalCompletedTasksCount = $totalCompletedTasks[0]->count_task_completed;
            $totalTasksCount = $totalTasks[0]->total_tasks;
        } else {
            $totalCompletedTasksCount = 0;
            $totalTasksCount = 0;
        }



        // Menghitung total event yang akan datang per user
        $upcomingEventsPerUser = DB::table('events')
            ->select('user_id')
            ->selectRaw('count(*) as count_total_event')
            ->where('end_date', '>', Carbon::now())
            ->groupBy('user_id')
            ->get();

        // 
        $totalEventUp = DB::table('events')
            ->select(
                DB::raw('user_id, count(*) as total_event')
            )
            ->groupBy('user_id')
            ->get();

        // Check if $upcomingEventsPerUser is not null before accessing its properties
        if (!$upcomingEventsPerUser->isEmpty()) {
            $upcomingEvents = $upcomingEventsPerUser[0]->count_total_event;
            $totalEvents = $totalEventUp[0]->total_event;
        } else {
            $upcomingEvents = 0;
            $totalEvents = 0;
        }


        // Menyusun hasil dalam format yang diinginkan
        $result = [
            [
                'goal_name' => 'countCategory_by_totalContact',
                'count_category' => $totalCategoryCount,
                'total_contact' => $totalTotalCount
            ],
            [
                'goal_name' => 'count_total_template',
                'total_message_template' => $totalMessageTemplateCount
            ],
            [
                'goal_name' => 'countComplitedTask_by_totalTask',
                'count_complited_task' => $totalCompletedTasksCount,
                'total_task' => $totalTasksCount
            ],
            [
                'goal_name' => 'event',
                'count_upcoming_event' => $upcomingEvents,
                'total_event' => $totalEvents,
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
            ->orderBy('start_date', 'desc')
            ->take(5)
            ->get();

        foreach ($fiveUpComingEvent as $event) {
            $result2[] = [
                'name' => 'five up coming event',
                'date' => $event->start_date
            ];
        }

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
            ->select(
                DB::raw(
                    ' 
            tasks.reminder, 
            CONCAT(contacts.first_name, " ", contacts.last_name) as full_name, 
            tasks.title,
            tasks.status
            '
                )
            )
            ->join('contacts', 'tasks.contact_id', '=', 'contacts.id')
            ->where('tasks.status', 'completed')
            ->groupBy('tasks.reminder', 'contacts.first_name', 'contacts.last_name', 'tasks.title',  'tasks.status')
            ->orderBy('tasks.reminder', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'message' => 'Successfully',
            'status' => true,
            'data' => $totalTaskDaily
        ]);
    }
}
