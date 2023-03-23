<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TreeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TreeController extends Controller
{
    private TreeService $service;

    /**
     * @param TreeService $service
     */
    public function __construct(TreeService $service)
    {
        $this->service = $service;
    }

    public function create() :View
    {

        return view('tree.create');
    }

    public function store(Request $request) : JsonResponse
    {
        $request->validate([
            'parent_id' => ['numeric', 'nullable'],
            'position' => [ 'numeric', 'nullable'],
            'title' => ['string','nullable'],
            'level' =>  [ 'numeric', 'nullable']
        ]);
        $tree= $this->service->create($request);

       return response()->json($tree,200,[],JSON_PRETTY_PRINT);
    }
    public function autoCreate() :View
    {

        return view('tree.autocreate',['exists'=>$this->service->isExistsTree()]);
    }
    public  function generate(Request $request)
    {
        $request->validate([

            'level' =>  [ 'numeric', 'required']
        ]);
        $level = $request->level;
        $this->service->autoCreate($level);
        return redirect()->route('tree.show')

    }
    public function show()
    {

        $tree = $this->service->getTree();
                dd($tree);
        $html = $this->service->drawChildren("<div class='tree'>",$tree);
        return view('tree.show',['tree'=>$html]);

    }

}
