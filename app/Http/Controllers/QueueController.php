<?php

namespace App\Http\Controllers;
use App\Models\QueueDb;
use App\Models\TellerDb;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\DequeueingEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class QueueController extends Controller{

    public function enqueue(Request $request){
        $latestPerson = QueueDb::latest('created_at')->first(); //getting latest queued person
        $currentDate = Carbon::now();   //getting current date

        //Uncomment code during testing purposes only
        // $currentDate->addDay(); 
        
        
        if (!$latestPerson || $latestPerson->created_at->format('Y-m-d') !== $currentDate->format('Y-m-d')) {
            $priorityNumber = 1; // Reset priority to 1 if last person is created yesterday
        } else {
            $priorityNumber = $latestPerson->priority_number + 1;   //else, increments priority number
        }
    
        $queue = new QueueDb();                             //creates new instance of from queuedb
        $queue->priority_number = $priorityNumber;      
        $queue->status = 'Waiting';
        $queue->purpose = $request->input('purpose');
        $queue->save();
    
        $latestPriorityNumber = QueueDb::orderByDesc('priority_number')->value('priority_number'); //gets latest priority number
        
        $successMessage = 'Successfully enqueued.';

        
        return $this->frontDeskDisplay($successMessage);
    }
    

    public function dequeue(){
        // Find the next person in the queue
        $nextPerson = QueueDb::where('status', 'Waiting')->orderBy('priority_number')->first();
        
        if ($nextPerson === null) {
            return redirect()->route('table')->with('fail', 'No one in queue');
        }

        // Update the teller_db table with the new current_customer_id based on the user's role
        $user = auth()->user();
        if ($user->role !== 'frontDesk') {
            $tableName = 'Table ' . substr($user->role, -1);

            // Get the previous customer served by this teller
            $previousCustomer = TellerDb::where('teller_name', $tableName)->first();
            if ($previousCustomer && $previousCustomer->current_customer_id) {
                // Update the status of the previous customer to 'Finished'
                QueueDb::where('id', $previousCustomer->current_customer_id)->update(['status' => 'Finished']);
            }

            // Update the current customer ID for the teller to the next person in the queue
            TellerDb::where('teller_name', $tableName)->update(['current_customer_id' => $nextPerson->id]);
        }

        // Update the status of the dequeued person in the queue_db to 'Serving'
        $nextPerson->status = 'Serving';
        $nextPerson->save();
        $data['hasUpdates'] = true;

        
        $this->updatePreviousCustomerStatus();
        session(['hasUpdates' => true]);
        
        return response('', 204);       
        
    }

    private function updatePreviousCustomerStatus(){
        $user = auth()->user();
        if ($user->role !== 'frontDesk') {
            $tableName = 'Table ' . substr($user->role, -1);
            
            // Get the previous customer served by this teller
            $previousCustomer = TellerDb::where('teller_name', $tableName)->first();

            if ($previousCustomer && $previousCustomer->current_customer_id) {
                // Update the status of the previous customer to 'Finished'
                QueueDb::where('id', $previousCustomer->current_customer_id)->update(['status' => 'Finished']);
            }
        }
    }


    public function showData()
    {
        // Retrieve all rows from the database
        $data = QueueDb::orderBy('id', 'desc')->get();

        // Get the unique dates from the 'created_at' column
        $uniqueDates = QueueDb::selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->pluck('date');

        return view('db', [
            'data' => $data,
            'uniqueDates' => $uniqueDates,
        ]);
    }

    public function frontDeskDisplay($successMessage = null){
        // Get the latest priority number from the queue
        $latestEntry = QueueDb::latest('created_at')->first();
        $latestPriorityNumber = $latestEntry ? $latestEntry->priority_number : null;
    
        // Get the total number of rows with status 'Waiting' and created on the same day
        $currentDate = date('Y-m-d');
        $waitingCount = QueueDb::where('status', 'Waiting')
            ->whereDate('created_at', $currentDate)
            ->count();

            
    
        // Return the view with the data
        return view('frontdesk', [
            'latestPriorityNumber' => $latestPriorityNumber,
            'waitingCount' => $waitingCount,
            'successMessage' => $successMessage,
        ]);
    }

    public function tellerDisplay(){
        $user = auth()->user();
        $currentUserTable = null;
        if ($user->role !== 'frontDesk') {
            $tableName = 'Table ' . substr($user->role, -1);
            $currentUserTable = TellerDb::where('teller_name', $tableName)->first();
        }

        //gets the current priority number served by the teller
        $currentPriorityNumber = ($currentUserTable && $currentUserTable->current_customer_id)
            ? QueueDb::find($currentUserTable->current_customer_id)->priority_number
            : '- - -';

        //retrieves # of people waiting in that same date
        $currentDate = date('Y-m-d');
        $waitingCount = QueueDb::where('status', 'Waiting')
            ->whereDate('created_at', $currentDate)
            ->count();

        return view('table', [
            'currentPriorityNumber' => $currentPriorityNumber,
            'waitingCount' => $waitingCount,
        ]);
    }

    public function getUpdatedQueueInfo(){ //for my AJAX of teller_info
        $user = auth()->user();
        $currentUserTable = null;

        if ($user->role !== 'frontDesk') {
            $tableName = 'Table ' . substr($user->role, -1);
            $currentUserTable = TellerDb::where('teller_name', $tableName)->first();
        }

        $currentPriorityNumber = ($currentUserTable && $currentUserTable->current_customer_id)
            ? QueueDb::find($currentUserTable->current_customer_id)->priority_number
            : '- - -';

        $latestPerson = QueueDb::latest('created_at')->first();
        $currentDate = date('Y-m-d');
        $waitingCount = QueueDb::where('status', 'Waiting')
            ->whereDate('created_at', $currentDate)
            ->count();
        
        $previousWaitingCount = session('previousWaitingCount', null);
        $latestPriorityNumber = $latestPerson ? $latestPerson->priority_number : '- - -';
        $newChanges = $previousWaitingCount !== null && $waitingCount < $previousWaitingCount;
        session(['previousWaitingCount' => $waitingCount]);

        return response()->json([
            'currentPriorityNumber' => $currentPriorityNumber,
            'waitingCount' => $waitingCount,
            'latestPriorityNumber' => $latestPriorityNumber,
            'newChanges' => $newChanges,
        ]);
    }

    public function getUpdatedQueueData(){ //for ajax in queue.js
        $tableData = $this->getTableData();

        $html = '';

        //dynamically updates data using code below
        foreach ($tableData as $data) {
            $html .= '<div class="table_container">
                <h3>' . $data['tableName'] . '</h3>
                <div class="Status">' . $data['status'] . '</div>
                <div class="serving">' . $data['serving'] . '</div>
            </div>';
        }

        $hasUpdates = $data['hasUpdate'];
        // return response()->json(['html' => $html]);
        return response()->json(['html' => $html, 'hasUpdates' => $hasUpdates]);
    }

    
    //Used in function above ^^^
    private function getTableData(){ //controller for queueView.blade.php

        $lastClientPollTimestamp = request()->input('last_poll_timestamp');

        $tables = ['Table 1', 'Table 2', 'Table 3', 'Table 4'];
        $tableData = [];

        foreach ($tables as $tableName) {
            $tableInfo = TellerDb::where('teller_name', $tableName)->first();
            $hasUpdate = $tableInfo && $tableInfo->last_update_at > $lastClientPollTimestamp;

            if (!$tableInfo) {
                $status = 'Closed';
                $serving = '---';
            } else {
                $status = $tableInfo->status === 'ACTIVE' ? 'Now Serving' : 'Closed';
                $serving = $tableInfo->status === 'ACTIVE' && $tableInfo->current_customer_id
                    ? QueueDb::find($tableInfo->current_customer_id)->priority_number
                    : '---';
            }

            $tableData[] = [
                'tableName' => $tableName,
                'status' => $status,
                'serving' => $serving,
                'hasUpdate' => $hasUpdate,
            ];
        }

        return $tableData;
    }

    
    public function displayView(){
        $tableData = $this->getTableData();

        return view('queueView', [
            'tableData' => $tableData,
        ]);
    }

    


}
