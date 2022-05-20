<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Route;
use App\Models\Node;
use App\Models\NodeOwner;
use App\Models\NodeNotification;
use Illuminate\Support\Facades\DB;
use Lang;
use Carbon\Carbon;
use Storage;

class NodeController extends Controller
{

    public function __construct()
    {
        $this->setDefaultMiddleware('node');
    }

    public function index($routeId)
    {
        $data = Route::find($routeId);
        if(!$data) {
            return redirect()->back()->with(['info' => Lang::get("Data not found")]);
        }

        return view('system.node.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $nodes = $request->node ?? [];
            foreach ($nodes as $index => $node) {
                $data = new Node();
                if($node['id']) {
                    $data = Node::find($node['id']);
                }

                $data->route_id = $request->route_id;
                $data->node_type = $node['node_type'];
                $data->node_owner_type = $node['node_owner_type'];
                $data->connector1 = $node['connector1'];
                $data->connector2 = $node['connector2'];
                $data->position_top = $node['position_top'];
                $data->position_left = $node['position_left'];
                $data->connector2 = $node['connector2'];
                $data->save();

                $nodeOwners = array();
                $nodeNotifications = array();
                foreach ($node['owner_id'] ?? [] as $ownerId) {
                    array_push(
                        $nodeOwners,
                        new NodeOwner([
                            "owner_id"=> $ownerId,
                        ])
                    );
                }
                foreach ($node['notification_id'] ?? [] as $notificationId) {
                    array_push(
                        $nodeNotifications,
                        new NodeNotification([
                            "notification_template_id"=> $notificationId,
                        ])
                    );
                }

                $data->syncNodeOwners($nodeOwners);
                $data->syncNodeNotifications($nodeOwners);
                $nodes[$index]['id'] = $data->id;
            }

            foreach ($nodes as $index => $node) {
                $data = Node::find($node['id']);
                if(!$data) continue;

                $data->next_node1_id = null;
                $data->next_node2_id = null;

                if($node['next_node1_id']) {
                    $nextNode = $this->getNode($nodes, $node['next_node1_id']);
                    if($nextNode) {
                        $data->next_node1_id = $nextNode['id'];
                    }
                }
                if($node['next_node2_id']) {
                    $nextNode = $this->getNode($nodes, $node['next_node2_id']);
                    if($nextNode) {
                        $data->next_node2_id = $nextNode['id'];
                    }
                }

                $data->save();
            }

            $route = Route::find($request->route_id);
            $fileName = 'workflow/route/'.str_replace(' ', '_', $route->name).'_'.Carbon::now()->timestamp.".json";
            Storage::put($fileName, $route->nodes()->with('nodeOwners', 'nodeNotifications')->get()->toJson());
            $route->file_location = $fileName;
            $route->save();

            DB::commit();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Data has been stored")
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }
    }

    private function getNode($nodes, $tempId) {
        foreach ($nodes as $node) {
            if ($node['temp_id'] == $tempId) {
                return $node;
            }
        }

        return null;
    }

}
