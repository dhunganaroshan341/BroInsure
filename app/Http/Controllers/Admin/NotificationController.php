<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DataTables;



class NotificationController extends BaseController
{
    public function __construct()
    {

        $this->folder = 'backend.notification';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $users = Notification::select('*')->where('user_id', getUserDetail()->id)->orderBy('id', 'desc');
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    if ($row->is_seen != 'Y') {
                        $btn .= '<button class="btn btn-success markAsSeen" data-id="' . $row->id . '" title="Mark as Seen"> <i class="fas fa-eye "
                         style="float:right;"></i></button>';
                    }
                    if (strpos($row->type, 'Download') !== false) {
                        $btn .= '<a class="btn btn-sm btn-primary ' . ($row->is_seen != 'Y' ? 'notificationAnkor' : '') . '"   download="' . substr($row->redirect_url, strrpos($row->redirect_url, '/') + 1) . '" title="Download" data-id="' . $row->id . '"
                        href="' . ($row->redirect_url != null ? asset('storage/' . $row->redirect_url) : '#') . '"
                        >Download</a>';
                    } else {
                        $btn .= '<a class="btn btn-sm btn-primary ' . ($row->is_seen != 'Y' ? 'notificationAnkor' : '') . '" href="' . ($row->redirect_url != null ? $row->redirect_url : '#') . '" title="Visit" data-id="' . $row->id . '">View</a>';
                    }



                    return $btn;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $data['title'] = 'Notification List';
            $data['folder'] = $this->folder;
            $data['extraCss'] = commonDatatableFiles('css');
            $data['extraJs'] = commonDatatableFiles();
            return view($this->folder . '.list', $data);

        }


    }


    public function markAsSeen(Request $request)
    {
        $user = getUserDetail();
        if ($request->id == 'all') {
            $update = Notification::where('user_id', $user->id)
                ->update(['is_seen' => 'Y']);
        } else {
            $update = Notification::where('id', $request->id)
                ->where('user_id', $user->id)
                ->update(['is_seen' => 'Y']);
        }
        if ($update) {
            $notificationsCount = Notification::where('user_id', $user->id)->where('is_seen', '!=', 'Y')->count();
            return $this->sendResponse($notificationsCount, getMessageText('update'));
        } else {
            return $this->sendError(getMessageText('update', false));
        }
    }
}
